<?php

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

defined('TYPO3_MODE') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Pi1',
    'TYPO3 Layerslider'
);


if (TYPO3_MODE === 'BE') {

    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'MINAV.' . $_EXTKEY,
        'web',     // Make module a submodule of 'web'
        'm1',    // Submodule key
        '',                        // Position
        array(
            'Slider'    => 'list, show, new, create, edit, update, delete, copy, filebrowser,updatefal, doupdatefal, getNewsStream, updatev6',
            'Slide'     => 'list, show, new, create, edit, update, delete, upload, paste, linkFile',
            'Item'      => 'list, show, new, create, edit, update, delete, upload, paste, linkFile',
            'Wizard'    => 'index, step1, step2, save, getimage',
            'Migration' => 'index,upload'
        ),
        array(
            'access' => 'user,group',
            'icon' => 'EXT:' . $_EXTKEY . (\TYPO3\CMS\Core\Utility\GeneralUtility::compat_version('7.0') ? '/ext_icon-7.png' : '/ext_icon.gif'),
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_m1.xlf',
        )
    );
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Layerslider');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_layerslider_domain_model_slider',
    'EXT:layerslider/Resources/Private/Language/locallang_csh_tx_layerslider_domain_model_slider.xlf');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_layerslider_domain_model_slide',
    'EXT:layerslider/Resources/Private/Language/locallang_csh_tx_layerslider_domain_model_slide.xlf');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_layerslider_domain_model_item',
    'EXT:layerslider/Resources/Private/Language/locallang_csh_tx_layerslider_domain_model_item.xlf');

$pluginSignature = str_replace('_', '', $_EXTKEY) . '_pi1';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature,
    'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_pi1.xml');
