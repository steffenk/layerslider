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
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 *
 *
 * @package layerslider
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Item extends AbstractEntity
{

    /**
     * title
     *
     * @var \string
     */
    protected $title;

    /**
     * content
     *
     * @var \string
     */
    protected $content;

    /**
     * configuration
     *
     * @var \string
     */
    protected $configuration = '{"textalign":"left","transitionin":"1","texttypein":"lines_asc","texttypeout":"lines_asc","static":"none","position":"relative"}';

    /**
     * link
     *
     * @var string
     */
    protected $link = "";

    /**
     * slide
     *
     * @var \MINAV\Layerslider\Domain\Model\Slide $slide
     */
    protected $slide;

    /**
     * contenttype
     *
     * @var \string $contenttype
     */
    protected $contenttype;


    /**
     *  The Sorting
     *
     * @var \int
     */
    protected $sorting;

    /**
     * The starttime
     *
     * @var integer
     */
    protected $starttime = 0;

    /**
     * The endtime
     *
     * @var integer
     */
    protected $endtime = 0;

    /**
     * The hidden
     *
     * @var integer
     */
    protected $hidden = 0;

    /**
     * image
     *
     * @var \MINAV\Layerslider\Domain\Model\FileReference
     */
    protected $falimage = null;

    /**
     * Returns the title
     *
     * @return \string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param \string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the content
     *
     * @return \string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the content
     *
     * @param \string $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


    /**
     * Returns the Configuration
     *
     * @return \array $configuration
     */
    public function getConfiguration()
    {
        return json_decode($this->configuration, true);
    }

    /**
     * Sets the Configuration
     *
     * @param \string $configuration
     * @return void
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = json_encode($configuration);
    }

    /**
     * Returns the link
     *
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the link
     *
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }


    /**
     * Returns the slide
     *
     * @return \MINAV\Layerslider\Domain\Model\Slide
     *
     */
    public function getSlide()
    {
        return $this->slide;
    }

    /**
     * Sets the slide
     *
     * @param \MINAV\Layerslider\Domain\Model\Slide $slide
     * @return void
     */
    public function setSlide($slide)
    {
        $this->slide = $slide;
    }

    /**
     * Returns the contenttype
     *
     * @return \string
     *
     */
    public function getContenttype()
    {
        return $this->contenttype;
    }

    /**
     * Sets the contenttype
     *
     * @param \string $contenttype
     * @return void
     */
    public function setContenttype($contenttype)
    {
        $this->contenttype = $contenttype;
    }


    /**
     * Returns the Sorting
     *
     * @return \int $sorting
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Sets the Sorting
     *
     * @param \int $sorting
     * @return void
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    }

    /**
     * Returns the starttime
     *
     * @return integer $starttime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Sets the starttime
     *
     * @param integer $starttime
     * @return void
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    }

    /**
     * Returns the endtime
     *
     * @return integer $endtime
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Sets the endtime
     *
     * @param integer $endtime
     * @return void
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    }

    /**
     * Returns the hidden
     *
     * @return integer $hidden
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets the hidden
     *
     * @param integer $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns the image
     *
     * @return \MINAV\Layerslider\Domain\Model\FileReference $falimage
     */
    public function getFalimage()
    {
        return $this->falimage;
    }

    /**
     * Sets the image
     *
     * @param \MINAV\Layerslider\Domain\Model\FileReference $falimage
     * @return void
     */
    public function setFalimage(FileReference $falimage)
    {
        $this->falimage = $falimage;
    }

}
