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
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Resource\DuplicationBehavior;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class SliderController extends ActionController
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


    /************************
     *
     *
     * FE Actions
     *
     *
     ************************/


    /**
     * action show
     *
     * @return string
     */
    public function showAction()
    {
        $extconf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['layerslider']);
        $this->settings['slider'] = str_replace('tx_layerslider_domain_model_slider_', "", $this->settings['slider']);

        if (strlen($this->settings['slider'] > 0)) {

            if ($extconf['deactivateCF'] == 1) {
                return $this->renderSliderView();
            } else {
                if (($view = $this->objectManager->get(CacheManager::class)->getCache('tx_layerslider_pi1_show_cache')->get('slider_' . $this->settings['slider'])) === false) {
                    $view = $this->renderSliderView();
                    /** @var Slider $slider */
                    $slider = $this->sliderRepository->findByUid((int)$this->settings['slider']);
                    if($slider !== NULL){
                        $this->objectManager->get(CacheManager::class)->getCache('tx_layerslider_pi1_show_cache')->set('slider_' . $this->settings['slider'],
                            $view, array(),
                            $this->calculateCacheLifetimeFromSlider($slider));
                    }
                }
                return $view;
            }
        } else {
            return '';
        }
    }


    /************************
     *
     *
     * BE Actions
     *
     *
     ************************/


    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        if ($this->settings['tsIncluded'] != 1) {
            echo '<p>You forgot to include the static extension template in the root template!</p>';
            return;
        } else {
            if(ini_get('max_input_vars') < 4000)
            {
                $this->addFlashMessage(LocalizationUtility::translate('slider.list.warning.maxInputVars.body', 'layerslider'), LocalizationUtility::translate('slider.list.warning.maxInputVars.header', 'layerslider'), AbstractMessage::WARNING);
            }

            $frameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
            /** @var QueryResult $sliders */
            $sliders = $this->sliderRepository->findAllBe($frameworkConfiguration['persistence']['storagePid']);
            $this->view->assign('sliders', $sliders);
        }


    }

    /**
     * action new
     *
     * @param Slider $newSlider
     * @dontvalidate $newSlider
     * @return void
     */
    public function newAction(Slider $newSlider = null)
    {
        $this->view->assign('newSlider', $newSlider);
    }

    /**
     * action create
     *
     * @param Slider $newSlider
     * @return void
     */
    public function createAction(Slider $newSlider)
    {
        $newSlider->setUsefal(true);
        $newSlider->setVersion(6);
        $this->sliderRepository->add($newSlider);
        /** @var PersistenceManager $persistenceManager */
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();

        $this->addFlashMessage(LocalizationUtility::translate('controller.slider.create.created', 'layerslider'),
            LocalizationUtility::translate('controller.success', 'layerslider'), AbstractMessage::OK);
        $this->redirect('edit', null, null, array('slider' => $newSlider));
    }

    /**
     * action edit
     *
     * @param Slider $slider
     * @return void
     */
    public function editAction(Slider $slider)
    {
        if ($slider->getUsefal() === false) {
            $this->redirect('updatefal', null, null, array('slider' => $slider));
        }
        /** @var array $options */
        $options = $slider->getOptions();
        if (strlen($options['skinsPath']) > 1) {
            $explodedPath = explode("/", $options['skinsPath']);
            $newSkin = $explodedPath[count($explodedPath) - 1];
            $lastPosition = strripos($options['skinsPath'], "/");
            $newSkinsPath = "/" . ltrim(substr($options['skinsPath'], 0, $lastPosition) . "/", "/");
            $options['skinsPath'] = $newSkinsPath;
            $options['skin'] = $newSkin;
        }
        $this->view->assign('fileWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'file', false, true)));
        $this->view->assign('linkWizardUrl',
            BackendUtility::getModuleUrl('wizard_element_browser', array('mode' => 'wizard', false, true)));
        $this->view->assign('slider', $slider)->assign('options', $options);

        $slidelist = [];
        if($slider->getSlides()->count() > 0){
            /** @var Slide $slide */
            foreach ($slider->getSlides() as $slide){
                $slidelist[] = $slide->getTitle();
            }
        }
        $html = $this->view->assign('slidelist', $slidelist)->render();
        return $this->sanitize_output($html);
    }


    /**
     * @param Slider $slider
     * @param array $updateformsettings
     */
    public function updatefalAction(Slider $slider = null, $updateformsettings = null)
    {
        /** @var array $storages */
        $storages = $this->storageRepository->findAll();
        if ($updateformsettings === null) {
            $updateformsettings['slider'] = $slider;
            $updateformsettings['storage'] = $storages[0];
            /** @var ResourceStorage $selectedResourceStorage */
            $selectedResourceStorage = $storages[0];
        } else {
            if ((int)$updateformsettings['storage'] > 0) {
                /** @var ResourceStorage $selectedResourceStorage */
                $selectedResourceStorage = $this->storageRepository->findByUid((int)$updateformsettings['storage']);
            }
            if ((int)$updateformsettings['slider'] > 0) {
                $slider = $this->sliderRepository->findByUid((int)$updateformsettings['slider']);
            }
        }
        if ($updateformsettings['process']) {
            $this->redirect('doupdatefal', null, null,
                array('slider' => $slider, 'updateformsettings' => $updateformsettings));
        }
        $foldersInResourceStorage = $selectedResourceStorage->getFoldersInFolder($selectedResourceStorage->getRootLevelFolder(),
            0, 999, true, true);
        asort($foldersInResourceStorage);
        $this->view
            ->assign('slider', $slider)
            ->assign('storages', $storages)
            ->assign('updateformsettings', $updateformsettings)
            ->assign('foldersInResourceStorage', $foldersInResourceStorage);
    }

    /**
     * @param Slider $slider
     * @param array $updateformsettings
     */
    public function doupdatefalAction(Slider $slider, $updateformsettings)
    {
        /** @var ResourceStorage $resourceStorage */
        $resourceStorage = $this->storageRepository->findByUid((int)$updateformsettings['storage']);
        /** @var Folder $folder */
        $folder = $resourceStorage->getFolder($updateformsettings['selectedFolder']);
        if ($slider->getSlides()->count() > 0) {
            /** @var Slide $slide */
            foreach ($slider->getSlides() as $slide) {

                /** @var File $fileObject */
                if (file_exists(GeneralUtility::getFileAbsFileName('uploads/tx_layerslider/' . $slide->getImage()))) {
                    if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 7003999) {
                        $fileObject = $folder->addFile(
                            GeneralUtility::getFileAbsFileName('uploads/tx_layerslider/' . $slide->getImage()), null,
                            DuplicationBehavior::RENAME
                        );
                    } else {
                        $fileObject = $folder->addFile(
                            GeneralUtility::getFileAbsFileName('uploads/tx_layerslider/' . $slide->getImage()), null,
                            'rename'
                        );
                    }


                    /** @var FileReference $fileReference */
                    $fileReference = $this->objectManager->get(FileReference::class);
                    $fileReference->setFile($fileObject);

                    $slide->setFalimage($fileReference);
                    $this->addFlashMessage('Image for Slide <strong>' . $slide->getUid() . ':' . $slide->getTitle() . '</strong> processed. Old storage: uploads/tx_layerslider/' . $slide->getImage() . ' => to new storage: ' . $fileObject->getPublicUrl(),
                        'Success', AbstractMessage::OK);
                } else {
                    $this->addFlashMessage('The given image for Slide <strong>' . $slide->getUid() . ':' . $slide->getTitle() . '</strong> was not found: uploads/tx_layerslider/' . $slide->getImage(),
                        'Error', AbstractMessage::ERROR);
                }
                /** proVCodeBlock **/
                if ($slide->getItems()->count() > 0) {
                    /** @var Item $item */
                    foreach ($slide->getItems() as $item) {
                        if ($item->getContenttype() == 'image') {
                            if (file_exists(GeneralUtility::getFileAbsFileName('uploads/tx_layerslider/' . $item->getContent()))) {
                                if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 7003999) {
                                    $fileObject = $folder->addFile(
                                        GeneralUtility::getFileAbsFileName('uploads/tx_layerslider/' . $item->getContent()),
                                        null, DuplicationBehavior::RENAME
                                    );
                                } else {
                                    $fileObject = $folder->addFile(
                                        GeneralUtility::getFileAbsFileName('uploads/tx_layerslider/' . $item->getContent()),
                                        null, 'rename'
                                    );
                                }

                                /** @var FileReference $fileReference */
                                $fileReference = $this->objectManager->get(FileReference::class);
                                $fileReference->setFile($fileObject);

                                $item->setFalimage($fileReference);
                                $this->addFlashMessage('Image for Layer <strong>' . $item->getUid() . ':' . $item->getTitle() . '</strong> in slider <strong>' . $slide->getUid() . ':' . $slide->getTitle() . '</strong> processed. Old storage: uploads/tx_layerslider/' . $item->getContent() . ' => to new storage: ' . $fileObject->getPublicUrl(),
                                    'Success', AbstractMessage::OK);
                            } else {
                                $this->addFlashMessage('The given image for Layer <strong>' . $item->getUid() . ':' . $item->getTitle() . '</strong> in slider <strong>' . $slide->getUid() . ':' . $slide->getTitle() . '</strong> was not found: uploads/tx_layerslider/' . $item->getContent(),
                                    'Error', AbstractMessage::ERROR);
                            }
                        }
                    }
                }
                /** proVCodeBlock **/
            }
            $slider->setUsefal(true);
            $this->sliderRepository->update($slider);
            $this->view->assign('slider', $slider);
        }
    }

    /**
     * @param Slider $slider
     * @return void
     */
    public function copyAction(Slider $slider)
    {

        /** @var Slider $sliderCopy */
        $sliderCopy = $this->objectManager->get(Slider::class);

        /** @var PersistenceManager $persistenceManager */
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $sliderCopy->setTitle('Copy from: ' . $slider->getTitle());
        $sliderCopy->setOptions(json_encode($slider->getOptions(), true));
        $sliderCopy->setVersion($slider->getVersion());
        $sliderCopy->setUsefal(true);
        $this->sliderRepository->add($sliderCopy);
        $persistenceManager->persistAll();

        if ($slider->getSlides()->count() > 0) {
            foreach ($slider->getSlides() as $slide) {
                /** @var Slide $slideCopy */
                $slideCopy = $this->objectManager->get(Slide::class);
                $slideCopy->setTitle($slide->getTitle());
                $slideCopy->setConfiguration($slide->getConfiguration());
                $slideCopy->setSorting($slide->getSorting());
                $slideCopy->setHidden($slide->getHidden());
                $slideCopy->setSlider($sliderCopy);
                if ($slide->getFalimage() !== null) {
                    /** @var FileReference $fileReference */
                    $fileReference = $this->objectManager->get(FileReference::class);
                    $fileReference->setFile($slide->getFalimage()->getOriginalResource()->getOriginalFile());
                    $slideCopy->setFalimage($fileReference);
                }

                $slideCopy->setTitle($slideCopy->getTitle());
                $this->slideRepository->add($slideCopy);
                $persistenceManager->persistAll();
                /** proVCodeBlock **/
                /** Check if there are Layers to copy */
                if ($slide->getItems()->count() > 0) {
                    /** @var ObjectStorage $itemObjectStorage */
                    $itemObjectStorage = $this->objectManager->get(ObjectStorage::class);
                    /** @var Item $item */
                    foreach ($slide->getItems() as $item) {
                        /** @var Item $itemCopy */
                        $itemCopy = $this->objectManager->get(Item::class);
                        $itemCopy->setTitle($item->getTitle());
                        $itemCopy->setContent($item->getContent());
                        $itemCopy->setConfiguration($item->getConfiguration());
                        $itemCopy->setLink($item->getLink());
                        $itemCopy->setSorting($item->getSorting());
                        $itemCopy->setHidden($item->getHidden());
                        $itemCopy->setContenttype($item->getContenttype());
                        if ($itemCopy->getContenttype() == 'image') {
                            if ($item->getFalimage() !== null) {
                                /** @var FileReference $fileReference */
                                $fileReference = $this->objectManager->get(FileReference::class);
                                $fileReference->setFile($item->getFalimage()->getOriginalResource()->getOriginalFile());
                                $itemCopy->setFalimage($fileReference);
                            }
                        }
                        $itemCopy->setSlide($slideCopy);
                        $this->itemRepository->add($itemCopy);
                        $persistenceManager->persistAll();
                        $itemObjectStorage->attach($itemCopy);
                    }
                    $slideCopy->setItems($itemObjectStorage);
                    $this->slideRepository->update($slideCopy);
                    $persistenceManager->persistAll();
                }
                /** proVCodeBlock **/
            }
        }
        $this->redirect('list', null, null);
    }

    /**
     * @param Slider $slider
     */
    public function updatev6Action(Slider $slider)
    {
        /** @var array $sliderOptions */
        $sliderOptions = $slider->getOptions();

        /** @var array $migrateSliderOptions */
        $migrateSliderOptions = [
            'randomSlideShow' => 'shuffleSlideshow',
            'responsive' => 'type',
            'loops' => 'cycles',
            'forceLoopNum' => 'forceCycles'
        ];
        foreach ($migrateSliderOptions as $oldOption => $newOption){
            if(array_key_exists($oldOption, $sliderOptions)){
                $sliderOptions[$newOption] = $sliderOptions[$oldOption];
                unset($sliderOptions[$oldOption]);
            }
        }
        $slider->setOptions(json_encode($sliderOptions));#
        $slider->setVersion(6);
        $this->sliderRepository->update($slider);

        if($slider->getSlides()->count() > 0){
            /** @var Slide $slide */
            foreach ($slider->getSlides() as $slide){
                /** @var array $slideConfiguration */
                $slideConfiguration = $slide->getConfiguration();

                /** @var array $migrateSlideOptions */
                $migrateSlideOptions = [
                    'slideDelay' => 'duration'
                ];
                foreach ($migrateSlideOptions as $oldOption => $newOption){
                    if(array_key_exists($oldOption, $slideConfiguration)){
                        $slideConfiguration[$newOption] = $slideConfiguration[$oldOption];
                        unset($slideConfiguration[$oldOption]);
                    }
                }
                $slide->setConfiguration($slideConfiguration);
                $this->slideRepository->update($slide);
                /** proVCodeBlock **/
                if($slide->getItems()->count() > 0){
                    /** @var Item $layer */
                    foreach($slide->getItems() as $layer){
                        /** @var array $layerConfiguration */
                        $layerConfiguration = $layer->getConfiguration();

                        /** @var array $migrateLayerOptions */
                        $migrateLayerOptions = [
                            'transitionindelay' => 'startatin',
                            'showuntil' => 'startatout',
                            'offsetxin' => 'offsetxin',
                            'offsetxout' => 'offsetxout',
                            'offsetyin' => 'offsetyin',
                            'offsetyout' => 'offsetyout',
                            'transitioninduration' => 'durationin',
                            'transitionoutduration' => 'durationout',
                            'transitionineasing' => 'easingin',
                            'transitionouteasing' => 'easingout',
                            'fade' => 'fadein',
                            'fadeout' => 'fadeout',
                            'transitioninrotation' => 'rotatein',
                            'transitioninrotationx' => 'rotatexin',
                            'transitioninrotationy' => 'rotateyin',
                            'transitionoutrotation' => 'rotateout',
                            'transitionoutrotationx' => 'rotatexout',
                            'transitionoutrotationy' => 'rotateyout',
                            'transitioninscalex' => 'scalexin',
                            'transitioninscaley' => 'scaleyin',
                            'transitionoutscalex' => 'scalexout',
                            'transitionoutscaley' => 'scaleyout',
                            'transitioninskewx' => 'skewxin',
                            'transitioninskewy' => 'skewyin',
                            'transitionoutskewx' => 'skewxout',
                            'transitionoutskewy' => 'skewyout',
                            'parallaxlevel' => 'parallaxlevel'
                        ];

                        /** @var array $optionsToRemove */
                        $optionsToRemove = ['offsetxinnumber', 'offsetyinnumber', 'transitioninduration', 'transitionineasing', 'transitionindelay', 'transitioninrotation', 'transitioninrotationx', 'transitioninrotationy', 'transitioninscalex', 'transitioninscaley', 'transitioninskewx', 'fade', 'offsetxoutnumber', 'offsetyoutnumber',
                                            'transitioninskewy', 'transitionoutduration', 'transitionouteasing', 'transitionoutrotation', 'transitionoutrotationx', 'transitionoutrotationy', 'transitionoutscalex', 'transitionoutscaley', 'transitionoutskewx', 'transitionoutskewy', 'distance', 'showuntil'];

                        foreach ($migrateLayerOptions as $oldOption => $newOption){
                            if(array_key_exists($oldOption, $layerConfiguration)){
                                switch ($oldOption){
                                    case 'showuntil':
                                        $layerConfiguration[$newOption] = ((int)$layerConfiguration['transitionindelay'] + (int)$layerConfiguration['transitioninduration'] + (int)$layerConfiguration['showuntil']);
                                        break;

                                    case 'offsetxin':
                                        if($layerConfiguration['offsetxin'] == 'number'){
                                            $layerConfiguration['offsetxin'] = $layerConfiguration['offsetxinnumber'];
                                        }
                                        break;

                                    case 'offsetxout':
                                        if($layerConfiguration['offsetxout'] == 'number'){
                                            $layerConfiguration['offsetxout'] = $layerConfiguration['offsetxoutnumber'];
                                        }
                                        break;

                                    case 'offsetyin':
                                        if($layerConfiguration['offsetyin'] == 'number'){
                                            $layerConfiguration['offsetyin'] = $layerConfiguration['offsetyinnumber'];
                                        }
                                        break;

                                    case 'offsetyout':
                                        if($layerConfiguration['offsetyout'] == 'number'){
                                            $layerConfiguration['offsetyout'] = $layerConfiguration['offsetyoutnumber'];
                                        }
                                        break;

                                    case 'parallaxlevel':
                                        if($layerConfiguration['parallaxlevel'] > 0){
                                            $layerConfiguration['parallax'] = 1;
                                        }
                                        break;

                                    default:
                                        $layerConfiguration[$newOption] = $layerConfiguration[$oldOption];
                                        break;
                                }
                            }
                        }

                        foreach ($optionsToRemove as $option){
                            if(array_key_exists($option, $layerConfiguration)){
                                unset($layerConfiguration[$option]);
                            }
                        }
                        $layerConfiguration['transitionin'] = 1;
                        $layer->setConfiguration($layerConfiguration);
                        $this->itemRepository->update($layer);
                    }
                }
                /** proVCodeBlock **/
            }
        }
        $this->addFlashMessage(LocalizationUtility::translate('slider.list.v6updatedone', 'layerslider'), '', AbstractMessage::OK);
        $this->redirect('list');
    }

    /**
     * Initializes the current action
     * @return void
     */
    public function initializeUpdateAction()
    {
        if (isset($this->arguments['slider'])) {
            $this->arguments['slider']->getPropertyMappingConfiguration()->allowProperties('formslides');
            $this->arguments['slider']->getPropertyMappingConfiguration()->allowProperties('formitems');
        }
    }

    /**
     * @param Slider $slider
     * @param Slide $newLayer
     * @param Item $deleteLayer
     * @param Slider $newSlide
     * @param Slide $deleteSlide
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function updateAction(
        Slider $slider,
        Slide $newLayer = null,
        Item $deleteLayer = null,
        Slider $newSlide = null,
        Slide $deleteSlide = null
    ) {
        $sliderFormData = $slider->getFormslides();
        if (is_array($sliderFormData)) {
            $i = 0;
            foreach ($sliderFormData as $fsKey => $fsVal) {
                // handle the slides
                /** @var Slide $existingSlide */
                $existingSlide = $this->slideRepository->findByUid($fsKey);
                if ($existingSlide instanceof Slide) {
                    $existingSlide->setTitle($fsVal['title']);
                    $existingSlide->setSorting($i);
                    $existingSlide->setConfiguration($fsVal['configuration']);
                    $existingSlide->setHidden($fsVal['hidden']);

                    if ($fsVal['starttime'] > 0) {
                        $existingSlide->setStarttime(strtotime($fsVal['starttime']));
                    } else {
                        $existingSlide->setStarttime(0);
                    }

                    if ($fsVal['endtime'] > 0) {
                        $existingSlide->setEndtime(strtotime($fsVal['endtime']));
                    } else {
                        $existingSlide->setEndtime(0);
                    }

                    if ($fsVal['fileReference']) {
                        $existingSlide->getFalimage()->setTitle($fsVal['fileReference']['title']);
                        $existingSlide->getFalimage()->setAlternative($fsVal['fileReference']['alternative']);
                    }

                    $this->slideRepository->update($existingSlide);
                }
                /** proVCodeBlock **/
                if (is_array($sliderFormData[$fsKey]['formitems'])) {
                    $ii = 0;
                    foreach ($sliderFormData[$fsKey]['formitems'] as $fiKey => $fiVal) {
                        $existingItem = $this->itemRepository->findByUid($fiKey);
                        /* @var Item $existingItem */
                        $existingItem->setTitle($fiVal['title']);
                        $existingItem->setContenttype($fiVal['contenttype']);
                        $existingItem->setContent($fiVal['content']);
                        $existingItem->setConfiguration($fiVal['configuration']);
                        $existingItem->setLink($fiVal['link']);
                        $existingItem->setSorting($fiVal['sorting']);
                        $existingItem->setHidden($fiVal['hidden']);

                        if ($fiVal['starttime'] > 0) {
                            $existingItem->setStarttime(strtotime($fiVal['starttime']));
                        } else {
                            $existingItem->setStarttime(0);
                        }

                        if ($fiVal['endtime'] > 0) {
                            $existingItem->setEndtime(strtotime($fiVal['endtime']));
                        } else {
                            $existingItem->setEndtime(0);
                        }

                        if ($fiVal['fileReference']) {
                            $existingItem->getFalimage()->setTitle($fiVal['fileReference']['title']);
                            $existingItem->getFalimage()->setAlternative($fiVal['fileReference']['alternative']);
                        }

                        $this->itemRepository->update($existingItem);
                        $ii++;
                    }
                }
                /** proVCodeBlock **/
                $i++;
            }
        }


        if( (count($_POST, COUNT_RECURSIVE) + count($_GET, COUNT_RECURSIVE)) > ini_get("max_input_vars") )
        {
            $this->addFlashMessage(LocalizationUtility::translate('slider.list.warning.maxInputVarsExceeded.body', 'layerslider'), LocalizationUtility::translate('slider.list.warning.maxInputVarsExceeded.header', 'layerslider'), AbstractMessage::WARNING);

        }
        $this->sliderRepository->update($slider);
        /** @var PersistenceManager $persistenceManager */
        $persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $persistenceManager->persistAll();
        $this->objectManager->get(CacheManager::class)->getCache('tx_layerslider_pi1_show_cache')->remove('slider_' . $slider->getUid());
        $this->addFlashMessage(LocalizationUtility::translate('controller.slider.update.updated', 'layerslider'));
//        $this->addFlashMessage(" ".(count($_POST, COUNT_RECURSIVE) + count($_GET, COUNT_RECURSIVE))." ", 'Postvars');

        if ($newLayer !== null) {
            $this->redirect('new', 'Item', null, array('slide' => $newLayer));
        }
        if ($deleteLayer !== null) {
            $this->redirect('delete', 'Item', null, array('item' => $deleteLayer));
        }
        if ($newSlide !== null) {
            $this->redirect('new', 'Slide', null, array('slider' => $newSlide));
        }
        if ($deleteSlide !== null) {
            $this->redirect('delete', 'Slide', null, array('slide' => $deleteSlide));
        }

        $this->redirect('edit', null, null, array('slider' => $slider));
    }

    /**
     * action delete
     *
     * @param Slider $slider
     * @return void
     */
    public function deleteAction(Slider $slider)
    {
        if ($slider->getSlides()->count() > 0) {
            /** @var Slide $slide */
            foreach ($slider->getSlides() as $slide) {
                $into_table = 'sys_file_reference';
                $where_clause = 'uid_foreign =' . $slide->getUid() . ' AND tablenames="tx_layerslider_domain_model_slide" AND fieldname="falimage" AND table_local="sys_file"';
                $field_values = array('deleted' => 1);
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery($into_table, $where_clause, $field_values);

                /** proVCodeBlock **/
                if ($slide->getItems()->count() > 0) {
                    /** @var Item $item */
                    foreach ($slide->getItems() as $item) {
                        $into_table = 'sys_file_reference';
                        $where_clause = 'uid_foreign =' . $item->getUid() . ' AND tablenames="tx_layerslider_domain_model_item" AND fieldname="falimage" AND table_local="sys_file"';
                        $field_values = array('deleted' => 1);
                        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($into_table, $where_clause, $field_values);
                    }
                }
                /** proVCodeBlock **/
            }
        }
        $this->sliderRepository->remove($slider);
        $this->addFlashMessage(LocalizationUtility::translate('controller.slider.delete.deleted', 'layerslider'),
            LocalizationUtility::translate('controller.success', 'layerslider'), AbstractMessage::OK);
        $this->redirect('list');
    }

    /**
     *
     */
    public function getNewsStreamAction()
    {
        $this->view->assign('news',
            (array)@simplexml_load_file(base64_decode('aHR0cHM6Ly93d3cucnV0c2NobWFubi5iaXovZmVlZC1sYXllcnNsaWRlci5yc3M/Y29tcHV0ZWROZXdzQ2xpZW50PQ==') . base64_encode(serialize(array(
                    $_SERVER['HTTP_HOST'],
                    '6.1.0',
                    'pro'
                )))));
    }


    /************************
     *
     *
     * Helpers
     *
     *
     ************************/



    /**
     * @return string
     */
    private function renderSliderView()
    {
        $slider = null;
        if ($this->settings['slider'] > 0) {
            /** @var Slider $slider */
            $slider = $this->sliderRepository->findByUid((int)$this->settings['slider']);
            if ($slider != null) {
                $this->view->assign('slider', $slider);
            } else {
                $this->addFlashMessage(LocalizationUtility::translate('controller.slider.renderSliderView.notFound',
                    'layerslider'), LocalizationUtility::translate('controller.error', 'layerslider'),
                    AbstractMessage::ERROR);
            }
        }
        $this->view->assign('slider', $slider)->assign('tsincluded', $this->settings['tsIncluded']);
        $output = $this->view->render();
        $view = $this->sanitize_output($output);

        return $view;
    }

    /**
     * @param Slider $slider
     * @return integer
     */
    private function calculateCacheLifetimeFromSlider(Slider $slider)
    {

        /** @var integer $lifetime */
        $lifetime = 0;

        /** @var QueryResult $slides */
        $slides = $this->slideRepository->findBySliderForCacheGeneration($slider);

        if ($slides->count() > 0) {
            /** @var Slide $slide */
            foreach ($slides as $slide) {
                if ($slide->getEndtime() > time()) {
                    if (($lifetime == 0) || ($lifetime > $slide->getEndtime())) {
                        $lifetime = $slide->getEndtime();
                    }
                }
                if ($slide->getStarttime() > time()) {
                    echo 1;
                    if (($lifetime == 0) || ($lifetime > $slide->getStarttime())) {

                        $lifetime = $slide->getStarttime();
                    }
                }

                /** proVCodeBlock **/
                /** @var QueryResult $items */
                $items = $this->itemRepository->findBySlideForCacheGeneration($slide);

                if ($items->count() > 0) {
                    foreach ($items as $item) {
                        if ($item->getEndtime() > time()) {
                            if (($lifetime == 0) || ($lifetime > $item->getEndtime())) {
                                $lifetime = $item->getEndtime();
                            }
                        }
                        if ($item->getStarttime() > time()) {
                            if (($lifetime == 0) || ($lifetime > $item->getStarttime())) {

                                $lifetime = $item->getStarttime();
                            }
                        }
                    }
                }
                /** proVCodeBlock **/

            }
            if ($lifetime > 0) {
                $lifetime = $lifetime - time();
            }
        }
        return $lifetime;
    }

    /**
     * @param $buffer
     * @return mixed
     */
    protected function sanitize_output($buffer)
    {
        $search = array(
            '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
            '/[^\S ]+\</s',  // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        );

        $replace = array(
            '>',
            '<',
            '\\1'
        );
        $buffer = preg_replace($search, $replace, $buffer);
        return str_replace(PHP_EOL, '', $buffer);
    }

}
