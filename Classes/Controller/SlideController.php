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
use MINAV\Layerslider\Domain\Model\Slider;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class SlideController extends ActionController
{

    /**
     * slideRepository
     *
     * @var \MINAV\Layerslider\Domain\Repository\SlideRepository
     * @inject
     */
    protected $slideRepository;

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
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        /** @var QueryResult $slides */
        $slides = $this->slideRepository->findAll();
        $this->view->assign('slides', $slides);
    }

    /**
     * action show
     *
     * @param Slide $slide
     * @return void
     */
    public function showAction(Slide $slide)
    {
        $this->view->assign('slide', $slide);
    }

    /**
     * action new
     *
     * @param Slider $slider
     * @param Slide $newSlide
     * @dontvalidate $newSlide
     * @return void
     */
    public function newAction(Slider $slider, Slide $newSlide = null)
    {
        if ($newSlide === null) {
            /** @var Slide $newSlide */
            $newSlide = $this->objectManager->get(Slide::class);
            $newSlide->setTitle('New Slide');
            $newSlide->setSlider($slider);
            $newSlide->setSorting(99999);
        }
        $this->forward('create', null, null, array('newSlide' => $newSlide));
    }

    /**
     * @param Slider $slider
     * @param Slide $slide
     * @return void
     */
    public function pasteAction(Slider $slider, Slide $slide)
    {

        /** @var Slide $slideCopy */
        $slideCopy = $this->objectManager->get(Slide::class);
        /** @var PersistenceManager $persistenceManager */
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);

        $slideCopy->setTitle($slide->getTitle());
        $slideCopy->setConfiguration($slide->getConfiguration());
        $slideCopy->setSorting($slide->getSorting());
        $slideCopy->setHidden($slide->getHidden());
        $slideCopy->setSlider($slider);

        if ($slide->getFalimage() !== null) {
            /** @var FileReference $fileReference */
            $fileReference = $this->objectManager->get(FileReference::class);
            $fileReference->setFile($slide->getFalimage()->getOriginalResource()->getOriginalFile());
            $slideCopy->setFalimage($fileReference);
        }

        $slideCopy->setTitle('Copy from: ' . $slideCopy->getTitle());
        $this->slideRepository->add($slideCopy);
        $persistenceManager->persistAll();
        /** proVCodeBlock **/
        /** Check if there are Layers to copy */
        if ($slide->getItems()->count() > 0) {
            /** @var ObjectStorage $itemObjectStorage */
            $itemObjectStorage = $this->objectManager->get(ObjectStorage::class);
            /** @var Item $item */
            foreach ($slide->getItems() as $item) {
                echo $item->getUid().'|';
                /** @var Item $itemCopy */
                $itemCopy = $this->objectManager->get(Item::class);
                $itemCopy->setTitle($item->getTitle());
                $itemCopy->setContent($item->getContent());
                $itemCopy->setConfiguration($item->getConfiguration());
                $itemCopy->setLink($item->getLink());
                $itemCopy->setContenttype($item->getContenttype());
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
                $itemCopy->setSlide($slideCopy);
                $itemObjectStorage->attach($itemCopy);
            }
            $slideCopy->setItems($itemObjectStorage);
            $this->slideRepository->update($slideCopy);
            $persistenceManager->persistAll();
        }
        /** proVCodeBlock **/
        exit;
    }

    /**
     * action create
     *
     * @param Slide $newSlide
     * @return void
     */
    public function createAction(Slide $newSlide)
    {
        $this->slideRepository->add($newSlide);
        /** @var PersistenceManager $persistenceManager */
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();
        $this->redirect('edit', 'Slider', null, array('slider' => $newSlide->getSlider()));
    }

    /**
     * action edit
     *
     * @param Slide $slide
     * @return string
     */
    public function editAction(Slide $slide)
    {
        $this->view->assign('fileWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'file', false, true)));
        $this->view->assign('linkWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'wizard', false, true)));
        $this->view->assign('slide', $slide);
        return $this->view->render();
    }

    /**
     * action update
     *
     * @param Slide $slide
     * @return void
     */
    public function updateAction(Slide $slide)
    {
        $this->slideRepository->update($slide);
        $this->addFlashMessage('Your Slide was updated.');
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param Slide $slide
     * @return void
     */
    public function deleteAction(Slide $slide)
    {
        $into_table = 'sys_file_reference';
        $where_clause = 'uid_foreign =' . $slide->getUid() . ' AND tablenames="tx_layerslider_domain_model_slide" AND fieldname="falimage" AND table_local="sys_file"';
        $field_values = array('deleted' => 1);
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($into_table, $where_clause, $field_values);

        if ($slide->getItems()->count() > 0) {
            foreach ($slide->getItems() as $item) {
                $into_table = 'sys_file_reference';
                $where_clause = 'uid_foreign =' . $item->getUid() . ' AND tablenames="tx_layerslider_domain_model_item" AND fieldname="falimage" AND table_local="sys_file"';
                $field_values = array('deleted' => 1);
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery($into_table, $where_clause, $field_values);
            }
        }
        $this->slideRepository->remove($slide);
        $this->redirect('edit', 'Slider', null, array('slider' => $slide->getSlider()));
    }

    /**
     * @param int $file
     * @param Slide $slide
     */
    public function linkFileAction($file, Slide $slide)
    {
        /** @var File $falimage */
        $falimage = $this->fileRepository->findByUid($file);
        if ($falimage instanceof File) {

            $into_table = 'sys_file_reference';
            $where_clause = 'uid_foreign =' . $slide->getUid() . ' AND tablenames="tx_layerslider_domain_model_slide" AND fieldname="falimage" AND table_local="sys_file"';
            $field_values = array('deleted' => 1);

            $GLOBALS['TYPO3_DB']->exec_UPDATEquery($into_table, $where_clause, $field_values);

            /** @var FileReference $fileReference */
            $fileReference = $this->objectManager->get(FileReference::class);
            $fileReference->setFile($falimage);
            $slide->setFalimage($fileReference);
            $this->slideRepository->update($slide);
            /** @var PersistenceManager $persistenceManager */
            $persistenceManager = $this->objectManager->get(PersistenceManager::class);
            $persistenceManager->persistAll();


            $this->addFlashMessage(LocalizationUtility::translate('controller.slide.linkfile.image.attached',
                'layerslider'), LocalizationUtility::translate('controller.success', 'layerslider'),
                AbstractMessage::OK);
        } else {
            $this->addFlashMessage(LocalizationUtility::translate('controller.slide.linkfile.image.notattached',
                'layerslider'), LocalizationUtility::translate('controller.success', 'layerslider'),
                AbstractMessage::ERROR);
        }
        $this->view->assign('slide', $slide);
        $this->view->assign('fileWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'file', false, true)));
        $this->view->assign('linkWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'wizard', false, true)));
    }

}
