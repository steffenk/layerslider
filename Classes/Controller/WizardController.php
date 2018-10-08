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
use MINAV\Layerslider\Domain\Model\Slide;
use MINAV\Layerslider\Domain\Model\Slider;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class WizardController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * sliderRepository
     *
     * @var \MINAV\Layerslider\Domain\Repository\SliderRepository
     * @inject
     */
    protected $sliderRepository;

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
     * @var \TYPO3\CMS\Core\Resource\StorageRepository
     * @inject
     */
    protected $storageRepository;


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
     * @var \TYPO3\CMS\Extbase\Service\ImageService
     * @inject
     */
    protected $imageService;

    /**
     * @param array $configuration
     */
    public function indexAction($configuration = null)
    {
        if ($configuration === null) {
            $configuration['controls'] = 'light';
            $configuration['thumbs'] = 'hover';
            $configuration['slidedelay'] = 4;
            $configuration['transition'] = 5;
            $configuration['sliderType'] = 'normal';
        }
        $this->view->assign('configuration', $configuration);
    }

    /**
     * @param array $configuration
     */
    public function step1Action($configuration)
    {
        if (substr($configuration['images'], strlen($configuration['images']) - 1, 1) == ",") {
            $configuration['images'] = substr($configuration['images'], 0, strlen($configuration['images']) - 1);
        }
        if (strlen($configuration['images']) > 0) {
            $imageStorage = array();
            foreach (explode(",", $configuration['images']) as $imageUid) {
                $imageStorage[] = $this->fileRepository->findByUid($imageUid);
            }
            $this->view->assign('imageStorage', $imageStorage);
        }

        $this->view->assign('configuration', $configuration);
        $this->view->assign('fileWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'file', false, true)));
    }

    /**
     * @param array $configuration
     */
    public function step2Action($configuration)
    {
        if ($configuration['action'] == 'prev') {
            $this->redirect('index', null, null, array('configuration' => $configuration));
        } else {
            if (strlen($configuration['images']) == 0) {
                $this->addFlashMessage('You need at least one image!', 'Error', AbstractMessage::ERROR);
                $this->redirect('step1', null, null, array('configuration' => $configuration));
            } else {
                if (substr($configuration['images'], strlen($configuration['images']) - 1, 1) == ",") {
                    $configuration['images'] = substr($configuration['images'], 0,
                        strlen($configuration['images']) - 1);
                }
                if (strlen($configuration['images']) > 0) {
                    $imageStorage = array();
                    foreach (explode(",", $configuration['images']) as $imageUid) {
                        $imageStorage[] = $this->fileRepository->findByUid($imageUid);
                    }
                    $this->view->assign('imageStorage', $imageStorage);
                }
                $this->view->assign('configuration', $configuration);
            }
        }
    }

    /**
     * @param int $file
     */
    public function getimageAction($file)
    {
        /** @var File $falimage */
        $falimage = $this->fileRepository->findByUid($file);

        $processingInstructions = array(
            'width' => 400,
            'height' => '',
            'minWidth' => '',
            'minHeight' => '',
            'maxWidth' => '',
            'maxHeight' => '',
            'crop' => '',
        );
        $processedImage = $this->imageService->applyProcessingInstructions($falimage, $processingInstructions);
        $imageUri = $this->imageService->getImageUri($processedImage, true);
        return $imageUri;
    }

    /**
     * @param array $configuration
     */
    public function saveAction($configuration)
    {
        if ($configuration['action'] == 'prev') {
            $this->redirect('step1', null, null, array('configuration' => $configuration));
        } else {
            $imageStorage = array();
            foreach (explode(",", $configuration['images']) as $imageUid) {
                $imageStorage[] = $this->fileRepository->findByUid($imageUid);
            }

            /** @var File $firstImage */
            $firstImage = $imageStorage[0];
            /** @var Slider $slider */
            $slider = $this->objectManager->get(Slider::class);
            $slider->setUsefal(true);
            $slider->setVersion(6);
            /** @var array $sliderDefaultOptions */
            $sliderDefaultOptions = $slider->getOptions();

            switch ($configuration['controls']) {
                case 'dark':
                    $sliderDefaultOptions['skin'] = 'fullwidthdark';
                    break;

                case 'light':
                    $sliderDefaultOptions['skin'] = 'fullwidth';
                    break;

                case 'no':
                    $sliderDefaultOptions['skin'] = 'fullwidth';
                    $sliderDefaultOptions['navButtons'] = '0';
                    $sliderDefaultOptions['navPrevNext'] = '0';
                    $sliderDefaultOptions['navStartStop'] = '0';
                    $sliderDefaultOptions['hoverPrevNext'] = '0';
                    $sliderDefaultOptions['hoverBottomNav'] = '0';
                    $sliderDefaultOptions['thumbnailNavigation'] = 'disabled';
                    break;

                default:
                    $sliderDefaultOptions['skin'] = 'fullwidth';
                    break;
            }

            switch ($configuration['thumbs']) {
                case 'always':
                    $sliderDefaultOptions['thumbnailNavigation'] = 'always';
                    break;

                case 'hover':
                    $sliderDefaultOptions['thumbnailNavigation'] = 'hover';
                    break;

                case 'hide':
                    $sliderDefaultOptions['thumbnailNavigation'] = 'disabled';
                    break;

                default:
                    $sliderDefaultOptions['thumbnailNavigation'] = 'disabled';
                    break;
            }

            switch ($configuration['sliderType']) {
                case 'normal':

                    $sliderDefaultOptions['width'] = $firstImage->getProperty('width') . 'px';
                    $sliderDefaultOptions['height'] = $firstImage->getProperty('height') . 'px';
                    $sliderDefaultOptions['type'] = 'responsive';
                    break;

                case 'fullwidth':
                    $sliderDefaultOptions['width'] = $firstImage->getProperty('width') . 'px';
                    $sliderDefaultOptions['height'] = $firstImage->getProperty('height') . 'px';
                    $sliderDefaultOptions['type'] = 'fullWidth';
                    $sliderDefaultOptions['fitScreenWidth'] = '1';
                    $sliderDefaultOptions['responsiveUnder'] = $configuration['pagewidth'];
                    $sliderDefaultOptions['slideBgSize'] = 'cover';
                    break;

                case 'fullsize':
                    $sliderDefaultOptions['width'] = $firstImage->getProperty('width') . 'px';
                    $sliderDefaultOptions['height'] = $firstImage->getProperty('height') . 'px';
                    $sliderDefaultOptions['type'] = 'fullsize';
                    $sliderDefaultOptions['fullSizeMode'] = 'hero';
                    $sliderDefaultOptions['fitScreenWidth'] = '1';
                    $sliderDefaultOptions['responsiveUnder'] = $firstImage->getProperty('width');
                    $sliderDefaultOptions['slideBgSize'] = 'cover';

                    break;
                default:

                    break;
            }

            $slider->setOptions(json_encode($sliderDefaultOptions));
            $slider->setTitle('Slider Wizard: New Slider');
            /** @var PersistenceManager $persistenceManager */
            $persistenceManager = $this->objectManager->get(PersistenceManager::class);
            $persistenceManager->persistAll();


            $slideI = 0;
            /** @var File $imageForSlide */
            foreach ($imageStorage as $imageForSlide) {
                /** @var Slide $slide */
                $slide = $this->objectManager->get(Slide::class);
                /** @var array $slideConfiguration */
                $slideConfiguration = array();
                $slideConfiguration['duration'] = $configuration['duration'] * 1000;
                $slideConfiguration['2dtransition'] = $configuration['transition'];
                $slideConfiguration['use2d3dtransition'] = '1';
                $slide->setConfiguration($slideConfiguration);

                /** @var FileReference $fileReference */
                $fileReference = $this->objectManager->get(FileReference::class);
                $fileReference->setFile($imageForSlide);
                $slide->setFalimage($fileReference);
                $slide->setSorting($slideI);
                $slide->setTitle('Slide #' . ($slideI + 1));
                $slide->setSlider($slider);
                $this->slideRepository->add($slide);
                $persistenceManager->persistAll();
                $slideI++;
            }

            $this->redirect('edit', 'Slider', null, array('slider' => $slider));
        }
    }
}
