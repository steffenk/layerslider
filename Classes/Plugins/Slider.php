<?php
namespace MINAV\Layerslider\Plugins;

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
use MINAV\Layerslider\Domain\Repository\SliderRepository;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

class Slider
{

    /**
     * @param $PA
     * @return string
     */
    public function plugin($PA)
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var StandaloneView $pluginView */
        $pluginView = $objectManager->get(StandaloneView::class);

        /** @var string $templateRootPath */
        $templateRootPath = GeneralUtility::getFileAbsFileName('typo3conf/ext/layerslider/Resources/Private/Templates/');

        /** @var string $templatePathAndFilename */
        $templatePathAndFilename = $templateRootPath . 'Plugin/Slider.html';

        $pluginView->setTemplatePathAndFilename($templatePathAndFilename);

        /** @var string $table */
        $table = 'tx_layerslider_domain_model_slider';

        /** @var array|bool $rows */
        $rows = BackendUtility::getRecordsByField($table, 'deleted', '0');

        /** @var array $list_rows */
        $list_rows = array();

        if (count($rows) > 0)
        {

            /** @var SliderRepository $sliderRepository */
            $sliderRepository = $objectManager->get(SliderRepository::class);

            /** @var array $list_rows */
            $list_rows = array();

            /** @var int $i */
            $i = 0;

            foreach ($rows as $row) {
                /* Show it only, if the beuser have access credentials! */
                if ($row['pid'] == 0 || BackendUtility::readPageAccess($row['pid'],
                        $GLOBALS['BE_USER']->getPagePermsClause(1))
                ) {
                    $list_rows[$i] = $row;
                    $list_rows[$i]['fullPath'] = BackendUtility::getRecordPath($row['pid'], '', 40);
                    $list_rows[$i]['slider'] = $sliderRepository->findByUid($row['uid']);
                    if ($PA['itemFormElValue'] == 'tx_layerslider_domain_model_slider_' . $row['uid'] || $PA['itemFormElValue'] == $row['uid'])
                    {
                        $list_rows[$i]['checked'] = 'checked="checked"';
                    }
                    $i++;
                }
            }
        }

        $pluginView->assignMultiple(array('rows' => $list_rows, 'PA' => $PA));
        $pluginView = $pluginView->render();

        return $pluginView;
    }
}
