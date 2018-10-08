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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class MigrationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;


    /**
     * indexAction
     */
    public function indexAction()
    {
        $this->view->assign('filesToCheck', $this->buildFileCheckingConfigurationArray());
    }


    public function uploadAction()
    {
        $uploadError = false;
        GeneralUtility::mkdir_deep(GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/overlays/'));
        GeneralUtility::mkdir_deep(GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/plugins/debug/'));
        GeneralUtility::mkdir_deep(GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/plugins/origami/'));
        GeneralUtility::mkdir_deep(GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/plugins/timeline/'));

        if (!$this->request->hasArgument('filesize')) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 417 Expectation Failed', true, 417);
            echo LocalizationUtility::translate('controller.migration.upload.error.filesize', 'layerslider');
            $uploadError = true;
        }
        if (!$this->request->hasArgument('filepath')) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 417 Expectation Failed', true, 417);
            echo LocalizationUtility::translate('controller.migration.upload.error.filepath', 'layerslider');
            $uploadError = true;
        }
        if (!$this->request->hasArgument('expectedFile')) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 417 Expectation Failed', true, 417);
            echo 'ExpectedFile not permitted';
            $uploadError = true;
        }

        if ($_FILES['file']['name'] != $this->request->getArgument('expectedFile')) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 417 Expectation Failed', true, 417);
            echo LocalizationUtility::translate('controller.migration.upload.error.expectedfile', 'layerslider');
            $uploadError = true;
        }
        if (!$this->isFileNameAllowed($_FILES['file']['name'])) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 417 Expectation Failed', true, 417);
            echo LocalizationUtility::translate('controller.migration.upload.error.notallowed', 'layerslider');
            $uploadError = true;
        }

        if ($uploadError === true) {
            return;
        }

        if (
            $_FILES['file']['name'] === 'jquery.js' ||
            $_FILES['file']['name'] === 'layerslider.kreaturamedia.jquery.js' ||
            $_FILES['file']['name'] === 'layerslider.transitions.js' ||
            $_FILES['file']['name'] === 'greensock.js'
        ) {
            GeneralUtility::upload_copy_move($_FILES['file']['tmp_name'],
                GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/JS/' . $_FILES['file']['name']));
        }

        if (
            $_FILES['file']['name'] === 'layerslider.css' ||
            $_FILES['file']['name'] === 'blank.gif'
        ) {
            GeneralUtility::upload_copy_move($_FILES['file']['tmp_name'],
                GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/css/' . $_FILES['file']['name']));
        }
        if (
            $_FILES['file']['name'] === 'layerslider.debug.css' ||
            $_FILES['file']['name'] === 'layerslider.debug.js'
        ) {
            GeneralUtility::upload_copy_move($_FILES['file']['tmp_name'],
                GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/plugins/debug/' . $_FILES['file']['name']));
        }
        if (
            $_FILES['file']['name'] === 'layerslider.origami.css' ||
            $_FILES['file']['name'] === 'layerslider.origami.js'
        ) {
            GeneralUtility::upload_copy_move($_FILES['file']['tmp_name'],
                GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/plugins/origami/' . $_FILES['file']['name']));
        }
        if (
            $_FILES['file']['name'] === 'layerslider.timeline.css' ||
            $_FILES['file']['name'] === 'layerslider.timeline.js'
        ) {
            GeneralUtility::upload_copy_move($_FILES['file']['tmp_name'],
                GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/plugins/timeline/' . $_FILES['file']['name']));
        }
        if (
            $_FILES['file']['name'] === 'gradient-1.png' ||
            $_FILES['file']['name'] === 'gradient-2.png' ||
            $_FILES['file']['name'] === 'gradient-3.png' ||
            $_FILES['file']['name'] === 'gradient-4.png' ||
            $_FILES['file']['name'] === 'gradient-circle-1.png' ||
            $_FILES['file']['name'] === 'grid_hard.png' ||
            $_FILES['file']['name'] === 'grid_medium.png' ||
            $_FILES['file']['name'] === 'grid_small.png' ||
            $_FILES['file']['name'] === 'grid_stripes_left.png' ||
            $_FILES['file']['name'] === 'grid_stripes_right.png'
        ) {
            GeneralUtility::upload_copy_move($_FILES['file']['tmp_name'],
                GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/overlays/' . $_FILES['file']['name']));
        }

        if (
            $_FILES['file']['name'] === 'loading.gif' ||
            $_FILES['file']['name'] === 'nothumb.png' ||
            $_FILES['file']['name'] === 'shadow.png' ||
            $_FILES['file']['name'] === 'skin.css' ||
            $_FILES['file']['name'] === 'skin.png'
        ) {
            if ($this->request->getArgument('filepath') === '/') {
                header($_SERVER['SERVER_PROTOCOL'] . ' 417 Expectation Failed', true, 417);
                echo LocalizationUtility::translate('controller.migration.upload.error.skinfilewofolder', 'layerslider');
                return;
            }

            $search = array('layerslider/', 'skins/', 'overlays/', 'plugins/', 'debug/', 'origami/', 'timeline/');
            $skinAndFilename = str_replace($search, '', $this->request->getArgument('filepath'));
            $filePathInfo = pathinfo($skinAndFilename);
            GeneralUtility::mkdir_deep(GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/skins/' . $filePathInfo['dirname']));
            GeneralUtility::upload_copy_move($_FILES['file']['tmp_name'],
                GeneralUtility::getFileAbsFileName('EXT:layerslider/Resources/Public/skins/' . $skinAndFilename));
        }
    }


    /**
     * @param $filename
     * @return bool
     */
    private function isFileNameAllowed($filename)
    {
        $allowedFiles = array(
            'layerslider.kreaturamedia.jquery.js',
            'layerslider.transitions.js',
            'greensock.js',
            'layerslider.css',
            'loading.gif',
            'nothumb.png',
            'shadow.png',
            'skin.css',
            'skin.png',
            'blank.gif',
            'jquery.js',
            'layerslider.debug.css',
            'layerslider.debug.js',
            'layerslider.origami.css',
            'layerslider.origami.js',
            'layerslider.timeline.css',
            'layerslider.timeline.js',
            'gradient-1.png',
            'gradient-2.png',
            'gradient-3.png',
            'gradient-4.png',
            'gradient-circle-1.png',
            'grid_hard.png',
            'grid_medium.png',
            'grid_small.png',
            'grid_stripes_left.png',
            'grid_stripes_right.png'
        );

        if (in_array($filename, $allowedFiles, true)) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    private function buildFileCheckingConfigurationArray()
    {
        /** @var  $filesToCheck */
        $filesToCheck = array(
            array(
                'jQuery Library', // Label
                'Resources/Public/JS/jquery.js', // Path
                null, // File basename
                null, // File exist
                '.js', // allowed upload endings
                1, // allowed number of upload files
                'ma-1.png', // helping image
                1, // Node Type = 1 = File, 2 folder
                array() // Subfiles
            ),
            array(
                'Layerslider Main Library', // Label
                'Resources/Public/JS/layerslider.kreaturamedia.jquery.js', // Path
                null, // File basename
                null, // File exist
                '.js', // allowed upload endings
                1, // allowed number of upload files
                'ma-1.png', // helping image
                1, // Node Type = 1 = File, 2 folder
                array() // Subfiles
            ),
            array(
                'Layerslider Transition Library',
                'Resources/Public/JS/layerslider.transitions.js',
                null,
                null,
                '.js',
                1,
                'ma-2.png',
                1,
                array()
            ),
            array(
                'Layerslider Greensock Engine',
                'Resources/Public/JS/greensock.js',
                null,
                null,
                '.js',
                1,
                'ma-3.png',
                1,
                array()
            ),
            array(
                'Layerslider Main CSS',
                'Resources/Public/css/layerslider.css',
                null,
                null,
                '.css',
                1,
                'ma-4.png',
                1,
                array()
            ),
            array(
                'Layerslider Blank image',
                'Resources/Public/css/blank.gif',
                null,
                null,
                '.css',
                1,
                'ma-4.png',
                1,
                array()
            ),
            array(
                'Skins',
                'Resources/Public/skins/',
                'skins',
                true,
                '.gif,.png,.css',
                1,
                'ma-5.png',
                2,
                array(
                    $this->buildSkinConfigurationArray('Borderless dark', 'borderlessdark', 1, 1, 1, 1, 1),
                    $this->buildSkinConfigurationArray('Borderless dark 3D', 'borderlessdark3d', 1, 1, 1, 1, 1),
                    $this->buildSkinConfigurationArray('Borderless Light', 'borderlesslight', 1, 1, 1, 1, 1),
                    $this->buildSkinConfigurationArray('Borderless Light 3D', 'borderlesslight3d', 1, 1, 1, 1, 1),
                    $this->buildSkinConfigurationArray('Carousel', 'carousel', 1, 1, 0, 1, 1),
                    $this->buildSkinConfigurationArray('Dark skin', 'darkskin', 1, 1, 0, 1, 1),
                    $this->buildSkinConfigurationArray('Default Skin', 'defaultskin', 1, 1, 0, 1, 1),
                    $this->buildSkinConfigurationArray('Full width skin', 'fullwidth', 1, 1, 0, 1, 1),
                    $this->buildSkinConfigurationArray('Full width dark skin', 'fullwidthdark', 1, 1, 0, 1, 1),
                    $this->buildSkinConfigurationArray('Glass', 'glass', 1, 1, 1, 1, 1),
                    $this->buildSkinConfigurationArray('Light skin', 'lightskin', 1, 1, 0, 1, 1),
                    $this->buildSkinConfigurationArray('Minimal skin', 'minimal', 1, 1, 0, 1, 1),
                    $this->buildSkinConfigurationArray('No skin', 'noskin', 1, 1, 0, 1, 1),
                    $this->buildSkinConfigurationArray('V5 skin', 'v5', 1, 1, 0, 1, 1),
                    $this->buildSkinConfigurationArray('V6 skin', 'v6', 1, 1, 0, 1, 0),
                )
            ),
        );
        /** @var array $file */
        foreach ($filesToCheck as &$file) {
            if ($file[7] == 1) {
                $file[2] = basename($file[1]);
                $file[3] = file_exists(GeneralUtility::getFileAbsFileName('EXT:layerslider/' . $file[1]));
            }
            if ($file[7] == 2) {
                /** @var array $subfolder */
                foreach ($file[8] as &$subfolder) {
                    foreach ($subfolder[2] as &$subfolderFiles) {
                        $subfolderFiles[2] = basename($subfolderFiles[1]);
                        $subfolderFiles[3] = file_exists(GeneralUtility::getFileAbsFileName('EXT:layerslider/' . $subfolderFiles[1]));
                    }
                }
            }
        }

        return $filesToCheck;
    }

    /**
     * @param string $skinName
     * @param string $skinPath
     * @param int $loaderImage
     * @param int $noThumbImage
     * @param int $shadowImage
     * @param int $skinCss
     * @param int $skinPng
     * @return array
     */
    private function buildSkinConfigurationArray(
        $skinName,
        $skinPath,
        $loaderImage = 0,
        $noThumbImage = 0,
        $shadowImage = 0,
        $skinCss = 0,
        $skinPng = 0
    ) {
        $skinArray = array(
            $skinName,
            $skinPath,
            array()
        );

        $loaderImageArray = array(
            'Loader image', // Label
            'Resources/Public/skins/' . $skinPath . '/loading.gif', // Path
            null, // File basename
            null // File exist
        );
        if ($loaderImage) {
            array_push($skinArray[2], $loaderImageArray);
        }

        $noThumbArray = array(
            'No thumb image',
            'Resources/Public/skins/' . $skinPath . '/nothumb.png',
            null,
            null
        );
        if ($noThumbImage) {
            array_push($skinArray[2], $noThumbArray);
        }

        $shadowImageArray = array(
            'Shadow image',
            'Resources/Public/skins/' . $skinPath . '/shadow.png',
            null,
            null
        );
        if ($shadowImage) {
            array_push($skinArray[2], $shadowImageArray);
        }


        $skinCssFileArray = array(
            'Skin css file',
            'Resources/Public/skins/' . $skinPath . '/skin.css',
            null,
            null
        );
        if ($skinCss) {
            array_push($skinArray[2], $skinCssFileArray);
        }

        $skinPngFileArray = array(
            'Skin png file',
            'Resources/Public/skins/' . $skinPath . '/skin.png',
            null,
            null
        );
        if ($skinPng) {
            array_push($skinArray[2], $skinPngFileArray);
        }

        return $skinArray;
    }

}
