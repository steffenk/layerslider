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

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Layerslider',
    'description' => 'Manage Sliders with layers and show the Sliders on your website',
    'category' => 'plugin',
    'author' => 'Manfred Rutschmann',
    'author_email' => 'manfred@rutschmann.biz',
    'author_company' => 'Rutschmann.BIZ',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '1',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 1,
    'lockType' => '',
    'version' => '6.1.3',
    'constraints' => array(
        'depends' => array(
            'extbase' => '6.2.0-8.7.99',
            'fluid' => '6.2.0-8.7.99',
            'typo3' => '6.2.0-8.7.99',
            'php' => '5.3.7-5.6.99,7.0.0-7.0.99,7.1.0-7.1.99'
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);
