<?php
namespace MINAV\Layerslider\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Manfred Rutschmann <manfred@rutschmann.biz>, Rutschmann.BIZ
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use MINAV\Layerslider\Domain\Model\FileReference;
use MINAV\Layerslider\Domain\Model\Item;
use MINAV\Layerslider\Domain\Model\Slide;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class ItemController extends ActionController
{

    /**
     * itemRepository
     *
     * @var \MINAV\Layerslider\Domain\Repository\ItemRepository
     * @inject
     */
    protected $itemRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Core\Resource\FileRepository
     * @inject
     */
    protected $fileRepository;

    /**
     * action new
     *
     * @param Slide $slide
     * @param Item $item
     * @dontvalidate $item
     * @return void
     */
    public function newAction(Slide $slide, Item $item = null)
    {
        if ($item === null) {
            /** @var Item $item */
            $item = $this->objectManager->get(Item::class);
            /* @var $item Item */
            $item->setTitle('New Item');
            $item->setContenttype('paragraph');
            $item->setContent('New Item');
            $item->setSlide($slide);
            $item->setSorting(99);
        }
        $this->forward('create', null, null, array('item' => $item));
    }

    /**
     * action create
     *
     * @param Item $item
     * @return void
     */
    public function createAction(Item $item)
    {
        $this->itemRepository->add($item);
        /** @var PersistenceManager $persistenceManager */
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();

        $this->redirectToUri($this->uriBuilder->reset()->setArguments(array(
            'tx_layerslider_web_layersliderm1' => array(
                'slider' => $item->getSlide()->getSlider(),
                'controller' => 'Slider',
                'action' => 'edit'
            )
        ))->setSection('item' . $item->getUid())->buildBackendUri());
    }

    /**
     * action edit
     *
     * @param Item $item
     * @return string
     */
    public function editAction(Item $item)
    {
        $this->view->assign('fileWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'file', false, true)));
        $this->view->assign('linkWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'wizard', false, true)));
        $this->view->assign('item', $item)->assign('slide', $item->getSlide());
        return $this->view->render();
    }

    /**
     * action delete
     *
     * @param Item $item
     * @return void
     */
    public function deleteAction(Item $item)
    {
        $into_table = 'sys_file_reference';
        $where_clause = 'uid_foreign =' . $item->getUid() . ' AND tablenames="tx_layerslider_domain_model_item" AND fieldname="falimage" AND table_local="sys_file"';
        $field_values = array('deleted' => 1);
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($into_table, $where_clause, $field_values);
        $this->itemRepository->remove($item);
        $this->redirect('edit', 'Slider', null, array('slider' => $item->getSlide()->getSlider()));

    }

    /**
     * @param int $file
     * @param Item $item
     */
    public function linkFileAction($file, Item $item)
    {
        /** @var File $falimage */
        $falimage = $this->fileRepository->findByUid($file);
        if ($falimage instanceof File) {

            $into_table = 'sys_file_reference';
            $where_clause = 'uid_foreign =' . $item->getUid() . ' AND tablenames="tx_layerslider_domain_model_item" AND fieldname="falimage" AND table_local="sys_file"';
            $field_values = array('deleted' => 1);
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery($into_table, $where_clause, $field_values);

            /** @var FileReference $fileReference */
            $fileReference = $this->objectManager->get(FileReference::class);
            $fileReference->setFile($falimage);
            $item->setFalimage($fileReference);
            $this->itemRepository->update($item);
            /** @var PersistenceManager $persistenceManager */
            $persistenceManager = $this->objectManager->get(PersistenceManager::class);
            $persistenceManager->persistAll();
            $this->addFlashMessage(LocalizationUtility::translate('controller.item.linkfile.image.attached',
                'layerslider'), LocalizationUtility::translate('controller.success', 'layerslider'),
                AbstractMessage::OK);
        } else {
            $this->addFlashMessage(LocalizationUtility::translate('controller.item.linkfile.image.notattached',
                'layerslider'), LocalizationUtility::translate('controller.error', 'layerslider'),
                AbstractMessage::ERROR);
        }
        $this->view->assign('item', $item);
        $this->view->assign('fileWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'file', false, true)));
        $this->view->assign('linkWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'wizard', false, true)));

    }

    /**
     * @param Item $item
     * @param Slide $slide
     */
    public function pasteAction(Item $item, Slide $slide)
    {

        /** @var PersistenceManager $persistenceManager */
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);

        /** @var Item $itemCopy */
        $itemCopy = $this->objectManager->get(Item::class);
        $itemCopy->setTitle($item->getTitle());
        $itemCopy->setContent($item->getContent());
        $itemCopy->setConfiguration($item->getConfiguration());
        $itemCopy->setLink($item->getLink());
        $itemCopy->setContenttype($item->getContenttype());
        $itemCopy->setTitle('Copy from: ' . $itemCopy->getTitle());
        $itemCopy->setSorting($item->getSorting());
        $itemCopy->setHidden($item->getHidden());

        if ($itemCopy->getContenttype() == 'image') {
            if ($item->getFalimage() !== null) {
                /** @var FileReference $fileReference */
                $fileReference = $this->objectManager->get(FileReference::class);
                $fileReference->setFile($item->getFalimage()->getOriginalResource()->getOriginalFile());
                $itemCopy->setFalimage($fileReference);
            }
        }
        $itemCopy->setSlide($slide);
        $this->itemRepository->add($itemCopy);
        $persistenceManager->persistAll();
        $this->forward('edit', null, null, array('item' => $itemCopy));
    }
}
