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

$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['layerslider']);

if ($extConf['deactivateCF'] == 1) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MINAV.' . $_EXTKEY,
        'Pi1',
        array(
            'Slider' => 'show',
        ),
        // non-cacheable actions
        array()
    );
} else {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'MINAV.' . $_EXTKEY,
        'Pi1',
        array(
            'Slider' => 'show',
        ),
        // non-cacheable actions
        array(
            'Slider' => 'show',
        )
    );
}


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('MINAV\\Layerslider\\Property\\TypeConverter\\ArrayConverter');

if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 7000000) {

    /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'tx-layerslider-plugin-pi1',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => 'EXT:layerslider/ext_icon-7.png']
    );


    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '
		mod.wizards.newContentElement.wizardItems {
			plugins {
				elements {
					layerslider_pi1 {
						title = TYPO3 Layerslider
						description = Insert the layerslider plugin to show a selected slider
						iconIdentifier = tx-layerslider-plugin-pi1
						tt_content_defValues {
							CType = list
							list_type = layerslider_pi1
						}
					}
				}
			}
		}

	');
} else {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '
		mod.wizards.newContentElement.wizardItems {
			plugins {
				elements {
					layerslider_pi1 {
						title = TYPO3 Layerslider
						description = Insert the layerslider plugin to show a selected slider
						icon = '.\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY).'ext_icon.gif
						tt_content_defValues {
							CType = list
							list_type = layerslider_pi1
						}
					}
				}
			}
		}

	');

}

/** Showview Cache */
if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tx_layerslider_pi1_show_cache'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tx_layerslider_pi1_show_cache'] = array();
}
