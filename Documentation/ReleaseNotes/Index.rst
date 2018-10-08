.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _release-notes:

Release notes for public version: This release notes are valid for the public version too. Just the version numbers are different. The latest pro version has the same release notes as the public version (Pro 6.1.0 = Light 5.6.1, Pro 5.6.6 = Light 5.4.9)


Release 6.1.0
-------------
- [FEATURE]: Added php 7.1 compatibility
- [FEATURE]: Added TYPO3 8.5 compatibilitiy
- [FEATURE]: Addes SrcSet Attribute to ls-bg slide backgrounds. Active and deactivate the srcset in the general Slider Options
- [FEATURE]: Set skins path standard value now within tzhe typoscript constants (plugin.tx_layerslider.settings.skinsPath)
- [FEATURE]: Added text transition in options and timeline for text transitions in
- [FEATURE]: Added text transition out options and timeline for text transitions out
- [FEATURE]: Added loop/middle transitions options and timeline for loop/middle transitions
- [FEATURE]: Added hover transitions options
- [FEATURE]: Added version tagging for slides for further updates
- [FEATURE]: Added version converter for LS5 to LS6 sliders
- [FEATURE]: Rewrite Timeline, added Text/Loop timelines, reordered layer settings
- [TASK]: Removed ID attribute from fe containers
- [TASK]: Removed frontend inline JS, added data attributes on layerslider container, rewrite initial js starter script
- [TASK]: Changed TypeConverter for Array to priority 35
- [TASK]: Changed Frontend Templates and removed the complete JavaScript code in source code. The slider becomes a new data markup to initialize it. The layerslinit.init.js files is rewritten to handle this.
- [TASK]: Added slider options: type, fullSizeMode, fitScreenWidth, allowFullscreen, maxRatio, insertMethod, insertSelector, clipSlideTransition, preventSliderClip, hideOnMobile, hideUnder, hideOver, slideOnSwipe, optimizeForMobile, startInViewport, pauseLayers, playByScroll, playByScrollSpeed, cycles, forceCycles, shuffleSlideshow, sliderFadeInDuration, globalBGRepeat, globalBGAttachment, globalBGPosition, globalBGSize, showSlideBarTimer, yourLogo, yourLogoStyle, yourLogoLink, yourLogoTarget, slideBGSize, slideBGPosition, parallaxSensitivity, parallaxCenterLayers, parallaxCenterDegree, parallaxScrollReverse, forceLayersOutDuration, useSrcset
- [TASK]: Removed slider options: randomSlideShow (replaced by new option shuffleSlideshow), imgPreload, loops, forceLoopNum, slideDelay, slideDirection, durationIn, durationOut, delayIn, delayOut, easingIn, easingOut, responsive, layersContainer, animateFirstSlide, lazyLoad
- [TASK]: Added slide options: bgsize, bgposition, duration, transitionduration, kenburnszoom, kenburnsscale, kenburnsrotate, parallaxtype, parallaxevent, parallaxaxis, parallaxtransformorigin, parallaxdurationmove, parallaxdurationleave, parallaxdistance, parallaxrotate, parallaxtransformperspective
- [TASK]: Removed slide options: slideDelay, slideInEasing, delayIn, slideOut, slideOutEasing, delayOut
- [TASK]: Added layer options: transitionin, startatin, transformoriginin, clipin, bgcolorin, colorin, radiusin, widthin, heightin, filterin, transformperspectivein, texttransitionin, textstartatin,texttypein, textshiftin, textoffsetxin, textoffsetyin, textdurationin, texteasingin, textfadein, textrotatein, textrotatexin, textrotateyin, textscalexin, textscaleyin, textskewxin, textskewyin, texttransformoriginin, texttransformperspectivein, loop, loopstartat, loopoffsetx, loopoffsety, loopduration, loopeasing, loopopacity, looprotate, looprotatex, looprotatey, loopskewx, loopskewy, loopscalex, loopscaley, looptransformorigin, loopclip, loopcount, looprepeatdelay, loopyoyo, looptransformperspective, loopfilter, texttransitionout, textstartatout, texttypeout, textshiftout, textoffsetxout, textoffsetyout, textdurationout, texteasingout, textfadeout, textrotateout, textrotatexout, textrotateyout, textscalexout, textscaleyout, textskewxout, textskewyout, texttransformoriginout, texttransformperspectiveout, transitionout, startatout, transformoriginout, clipout, filterout, transformperspectiveout, bgcolorout, colorout, radiusout, widthout, heightout, hover, hoveroffsetx, hoveroffsety, hoverdurationin, hoverdurationout, hovereasingin, hovereasingout, hoveropacity, hoverrotate, hoverrotatex, hoverrotatey, hoverskewx, hoverskewy, hoverscalex, hoverscaley, hovertransformorigin, hoverbgcolor, hovercolor, hoverborderradius, hovertransformperspective, hoveralwaysontop, parallax, parallaxtype, parallaxevent, parallaxaxis, parallaxtransformorigin, parallaxdurationmove, parallaxdurationleave, parallaxrotate, parallaxdistance, parallaxtransformperspective, static, keyframe, minfontsize, minmobilefontsize, position
- [TASK]: Removed layer options: delayin, showuntil
- [TASK]: Set TYPO3 Version to 8.5.99
- [TASK]: Added LS6 Icon for Backend
- [TASK]: Updated documentation images
- [TASK]: Optimized BE Inline JS and compress HTML SourceCode in Backend Module
- [FIX]: Changed visibility settings fon layers in the positioning stage since LS6 changed it
- [FIX]: Fixed responsiveUnder behavior for LS 6 in positioning stage
- [FIX]: Changed {_all} to {_all:_all} because a crash in T3 8.5
- [FIX]: Changed f:translate in combination with f:format.raw for translated CDATA text in BE



Release 5.6.6
-------------
- [TASK]: Set extension/composer version to 5.6.6
- [FEATURE]: Added max_input_vars check
- [BUGFIX]: Delete slide fixed

Release 5.6.5
-------------
- Feature: Included composer.json
- Feature: Set extension compatibility to TYPO3 8.1.99 The Layerslider Extension Supports now TYPO3 6.2 LTS, 7 LTS and 8.1.x
- Feature: Provide a new Migration Wizard for integrate the kQuery Layerslider Plugin
- Task: Change TCA table to new style
- Task: Test jQuery Layerslider plugin 5.6.6 => o.k.
- Task: Included Layerslider news stream
- Task: php code refactoring
- Task: provide extension icon over IconFactory
- Bugfix: Corected Extension icon in 6.2 LTS
- Bugfix: Corected missing layers in slide copy function
- Bugfix: Corrceted some JS Inline ind FLuidtemplates
- Bugfix: Corrected JS cookies for Panel and Tabs (save state)
- Bugfix: Corrected scroll behavior in TBE File Browser

Release 5.6.4
-------------
- Feature: Easy Wizard to create new sliders with base settings
- Feature: Include german language in backend
- Bugfix: Layer sorting now saved correctly
- Bugfix: Typolink rendering corrected for slide links
- Bugfix: Wrong rendered Layers on positioning stage fixed
- Task: removed old non 2D/3D slide transitions. Not used anymore in LS5


Release 5.6.3
-------------
- Bugfix: Transition Button / Opening of the transition gallery


Release 5.6.2
-------------
- Feature: Timeline on positioning area added
- Feature: Complete new Plugin to insert Sliders (resolves problem with editors and not selectable slider with storagePid = 0)
- Feature: Configuration for Caching Frame Work. You can deactivate CF if you want use nc_staticfilecache!
- Bugfix: Corrected TypoLink Rendering for Layers
- Bugfix: Fixed double ID output on layers
- On Request: Make TypoLink Viewhelper php5.4 compatible

Release 5.6.1
-------------
- Bugfix: Text align of layers now correct
- Bugfix: Wrong style attribute fixed in preview panel
- Bugfix: Remove 500er excpetion when in plugin is no slider given
- Bugfix: Change rel="" to data-ls="" on slides

Release 5.6.0
-------------
- Bugfix: Correct helper lines in Layer positioning stage when they have a padding
- Feature: Add Suggest Wizard to Plugin


Release 5.4.3
-------------
- Feature: Complete integration with TYPO3 File Abstraction Layer and FileReferences
- Feature: Title and alternative tags for Slide images
- Feature: Title and alternative tags for Layer images
- Feature: Upgrade wizard for sliders to FAL: With this version, you can not edit a existing slider before you run the update wizard on each slider!
- Feature: Open or close Layer's edit area by click on panel header (and the edit icon in panel header too!). Just awesome :D
- Feature: Open or close Slide's edit area by click on panel header (and the edit icon in panel header too!). Just awesome :D
- Feature: Implement TYPO3 Caching framework
- Feature: Set start/stop Date/Time for each Slide
- Feature: Set start/stop Date/Time for each Layer
- Feature: Complete rewritten positioning stage:
- - Better control of layers with visual feedback of outline borders and active borders on drag
- - Resize images directly in the positioning stage, with visual borders too
- - Mutch better positioning results with full-width sliders and the option responsiveUnder: the container is now fixed and has on left/right a not editable area on the image
- Note: With the implementation of TYPO3 Caching Framework, each slider view would be cached in a special table, instead in the page cache with the whole page code. This gives you some nice features:
- - You don't need to clear the fe cache if you update your slider
- - You don't need to clear the fe cache if you use start/stop time in slides and layers, because the cache lifetime is calculated from the times that are set!
- Removed: Drag & Drop Upload. The FAL integration with the element browser is the better solution, trust me ;-)
- Warning: Install this Update ONLY over the Extension Manager! There are some new tables and field definitions in the database. If you only upload this version with FTP, your frontend gets broken!
- Install information: Install it only over the extension manager if you make a update! After that, clear all caches in install tool and double check the "Compare Database" in install tool!


Release 5.4.2
-------------
- Feature: Integrated TYPO3 Link Wizard for Slide and Layer link fields. At now, typolink are fully supported!
- - Please note: With this change, the old field "Link Target" in the Basic Section for a slide is removed! If you have links with new Window as target, you must set these option within the Link Wizard!
- Feature: The output code is sanitized now

- Bugfix: Textcolor and Background Color in Layersettings corrected
- Bugfix: Button "Update Positioning Stage" without function. Corrected in this version
- Bugfix: Layerlinks are on the wrong place in the DOM in Backend
- Bugfix: Set layersContainer option in relation to responsiveUnder option for full width sliders


Release 5.4.1
-------------
- Feature: Included TYPO3 Filewizard as alternative to the drag&drop Uploads for Slide Image
- Feature: Included TYPO3 Filewizard as alternative to the drag&drop Uploads for Item Image
- Bugfix: add jpeg as image format for drag&drop upload
- Bugfix: edit new created item without save the whole slider
- Set TYPO3 Version to 7.5.99



Release 5.4.0
-------------
- Bugfix on form buttons
- Bugfix an "new slider" view
- Bugfix user access in plugin
- Bugfix Font color & Background Color missing in Layer styles
- Test with the new 5.6 Release of the jQuery Layerslider Plugin
- Feature: Fullwidth Slider with responsive no and responsiveUnder value
- Recode plugin Flexform with problems on editors

Release 5.3.9
-------------
- Complete rewritten Backend with bootstrap
- Feature: Confirm for delete sliders
- Feature: Confirm for delete of slides
- Feature: Confirm for delete of layers
- Feature: Remember open Slides after save
- Feature: Remember open Tabs in Slides after save
- Feature: Remember open Layers in a Slide after save
- Feature: Remember open Tabs in a Layer after save
- Feature: Fancy TYPO3 V7 Icon in left Module bar
- Bug: Misspelling of some inline js code in relation of element id's
- Bug: include missing space in Layout for JS File inclusion (on type tag)
- Bug: Own CSS class of a layer is rendered in ID tag instead of css tag


Release 5.3.8
-------------
- Set TYPO3 compatibility to 7.4.99
- Set Extbase compatibility to 7.4.99
- Set Fluid compatibility to 7.4.99


Release 5.3.7
-------------
- Set TYPO3 compatibility to 7.3.99
- Set Extbase compatibility to 7.3.99
- Set Fluid compatibility to 7.3.99


Release 5.3.6
-------------
- Update some Templatefiles, remove old deprecated options

Release 5.3.5
-------------
- Change layer content to text instead of varchar
- Update layerslider Core to version 5.5

Release 5.3.4
-------------
- Attention: module.tx_layerslider.view is changed to templateRootPaths.10, partialRootPaths.10 and layoutRootPaths.10
- Sortable Layer items in the slide
- TYPO3 7.1 code adjustments
- Code refactoring
- Set highest TYPO3 version to 7.1.99
- ArrayConverter Bugfix
- Path adjustments in templates for instances of TYPO3 in subfolder instead of TYPO3 in servers document root


Release 5.3.3
-------------
- Copy Slider, Slides and Layers and paste them everywhere you want.
- You can now specify the preview panel width in the backend module
- Bugfix on layerattributes (rotate)
- Clear your cache over the install tool (Important actions -> clear all cache) on update to 5.3.3.


Release 5.3.2
-------------
- Include BE/FE additional CSS file
- List Plugin in "Plugins"-Tab for new content elements
- Adding field for parallaxlevel in layer attributes (section Misc in Animation & Timings). Use positve or negative values. The higher the value is, the higher is the effect.

