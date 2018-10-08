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

class Slider extends AbstractEntity
{

    /**
     * Title of this slider
     *
     * @var \string
     * @validate NotEmpty
     */
    protected $title;


    /**
     *  The Options
     *
     * @var \string
     */
    protected $options = '{"width":"1280px","height":"720px","type":"responsive","fullSizeMode":"normal","insertMethod":"prependTo","clipSlideTransition":"disabled","slideOnSwipe":"true","autoStart":"1","pauseOnHover":"1","keybNav":"1","touchNav":"1","skin":"v6","globalBGColor":"transparent","globalBGImage":"false","globalBGRepeat":"no-repeat","globalBGAttachment":"scroll","globalBGPosition":"50% 50%","navPrevNext":"1","navStartStop":"1","navButtons":"1","hoverPrevNext":"1","showCircleTimer":"1","thumbnailNavigation":"hover","tnContainerWidth":"60%","tnWidth":"100","tnHeight":"60","tnActiveOpacity":"35","tnInactiveOpacity":"100","autoPlayVideos":"1","autoPauseSlideshow":"auto","youtubePreview":"maxresdefault.jpg","yourLogoTarget":"self","slideBGSize":"cover","slideBGPosition":"50% 50%","parallaxSensitivity":"","parallaxCenterLayers":"center"}';


    /**
     * slides
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MINAV\Layerslider\Domain\Model\Slide>
     * @cascade remove
     */
    protected $slides;


    /**
     *  The formslides
     *
     * @var \array
     */
    protected $formslides;

    /**
     *  The formitems
     *
     * @var \array
     */
    protected $formitems;

    /**
     * The usefal
     *
     * @var boolean
     */
    protected $usefal = false;

    /**
     * The version
     *
     * @var int
     */
    protected $version = 0;

    /**
     * __construct
     *
     * @return Slider
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
     * Returns the Options
     *
     * @return \array $options
     */
    public function getOptions()
    {
        return json_decode($this->options, true);
    }

    /**
     * Sets the Options
     *
     * @param \string $options
     * @return void
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }


    /**
     * Adds a Slide
     *
     * @param \MINAV\Layerslider\Domain\Model\Slide $slide
     * @return void
     */
    public function addSlide(Slide $slide)
    {
        $this->slides->attach($slide);
    }

    /**
     * Removes a Slide
     *
     * @param \MINAV\Layerslider\Domain\Model\Slide $slideToRemove The Slide to be removed
     * @return void
     */
    public function removeSlide(Slide $slideToRemove)
    {
        $this->slides->detach($slideToRemove);
    }

    /**
     * Returns the slides
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MINAV\Layerslider\Domain\Model\Slide> $slides
     */
    public function getSlides()
    {
        return $this->slides;
    }

    /**
     * Sets the Slides
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MINAV\Layerslider\Domain\Model\Slides> $slides
     * @return void
     */
    public function setSlides(ObjectStorage $slides)
    {
        $this->slides = $slides;
    }

    /**
     * Returns the Formslides
     *
     * @return \array $formslides
     */
    public function getFormslides()
    {
        return $this->formslides;
    }

    /**
     * Sets the Formslides
     *
     * @param \array $formslides
     * @return void
     */
    public function setFormslides($formslides)
    {
        $this->formslides = $formslides;
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
     * Returns the usefal
     *
     * @return boolean $usefal
     */
    public function getUsefal()
    {
        return $this->usefal;
    }

    /**
     * Sets the usefal
     *
     * @param boolean $usefal
     * @return void
     */
    public function setUsefal($usefal)
    {
        $this->usefal = $usefal;
    }

    /**
     * Returns the version
     *
     * @return int $version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Sets the version
     *
     * @param int $version
     * @return void
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

}
