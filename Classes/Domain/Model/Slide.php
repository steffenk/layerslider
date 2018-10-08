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
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Slide extends AbstractEntity
{

    /**
     * Title of this slide
     *
     * @var \string
     */
    protected $title;

    /**
     * items
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MINAV\Layerslider\Domain\Model\Item>
     * @cascade remove
     */
    protected $items;

    /**
     *  The formitems
     *
     * @var \array
     */
    protected $formitems;

    /**
     * slider
     *
     * @var \MINAV\Layerslider\Domain\Model\Slider
     */
    protected $slider;


    /**
     *  The Sorting
     *
     * @var \int
     */
    protected $sorting;


    /**
     *  The Configuration
     *
     * @var \string
     */
    protected $configuration = '{"slideDelay":"0","duration":"4000","use2d3dtransition":"1","2dtransition":"5","parallaxaxis":"none"}';

    /**
     * The image
     *
     * @var \string
     */
    protected $image;

    /**
     * image
     *
     * @var \MINAV\Layerslider\Domain\Model\FileReference
     */
    protected $falimage = null;

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
     * __construct
     *
     * @return Slide
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->items = new ObjectStorage();
    }

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
     * Adds a Item
     *
     * @param \MINAV\Layerslider\Domain\Model\Item $item
     * @return void
     */
    public function addItem(Item $item)
    {
        $this->items->attach($item);
    }

    /**
     * Removes a Item
     *
     * @param \MINAV\Layerslider\Domain\Model\Item $itemToRemove The Item to be removed
     * @return void
     */
    public function removeItem(Item $itemToRemove)
    {
        $this->items->detach($itemToRemove);
    }

    /**
     * Returns the items
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MINAV\Layerslider\Domain\Model\Item> $items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Sets the items
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MINAV\Layerslider\Domain\Model\Item> $items
     * @return void
     */
    public function setItems(ObjectStorage $items)
    {
        $this->items = $items;
    }

    /**
     * Returns the slider
     *
     * @return \MINAV\Layerslider\Domain\Model\Slider $slider
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * Sets the slides
     *
     * @param \MINAV\Layerslider\Domain\Model\Slider $slider
     * @return void
     */
    public function setSlider(Slider $slider)
    {
        $this->slider = $slider;
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
     * Returns the image
     *
     * @return \string $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the Image
     *
     * @param \string $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
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

    /**
     * Returns the Formitems
     *
     * @return \array $formitems
     */
    public function getFormitems()
    {
        return $this->formitems;
    }

    /**
     * Sets the Formitems
     *
     * @param \array $formitems
     * @return void
     */
    public function setFormitems($formitems)
    {
        $this->formitems = $formitems;
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

}
