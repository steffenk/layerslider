<?php
namespace MINAV\Layerslider\Domain\Model;

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
use TYPO3\CMS\Core\Resource\File;

class FileReference extends \TYPO3\CMS\Extbase\Domain\Model\FileReference
{

    /**
     * We need this property so that the Extbase persistence can properly persist the object
     *
     * @var integer
     */
    protected $uidLocal;

    /**
     * uid of a sys_file
     *
     * @var integer
     */
    protected $originalFileIdentifier;

    /**
     * @var string title
     */
    protected $title = null;

    /**
     * @var string alternative
     */
    protected $alternative = null;

    /**
     * setFile
     *
     * @param \TYPO3\CMS\Core\Resource\File $falFile
     * @return void
     */
    public function setFile(File $falFile)
    {
        $this->originalFileIdentifier = (int)$falFile->getUid();
        $this->uidLocal = (int)$falFile->getUid();
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $alternative
     */
    public function setAlternative($alternative)
    {
        $this->alternative = $alternative;
    }

}
