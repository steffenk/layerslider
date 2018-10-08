.. _start:


=============
Documentation
=============


Extension Manual
=================

Installation
============

Installation normal mode
------------------------
- Read this first!
- Install the extension (layerslider.zip) with the extension manager or extract the zip and upload the content in typo3conf/ext/layerslider
- Include the static typoscript template "layerslider" in your root template!
- Check the constant editor "PLUGIN.TX_LAYERSLIDER (6)" for some setting about the include from jquery and other needed libraries. Use always the latest jquery library!
- CLEAR THE CACHE!!!!

Installation composer mode
--------------------------
You can install this extension via composer from a remote repository, like private github or gitlab. I host a gitlab
server with the actual version of this extension, and as a reqular customer you can get access to this repository. If
you dont have access yet, please write me manfred@rutschmann.biz.

Add the needed information to your composer.json
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Over HTTPS
''''''''''
In the ``repositories``section of your projects ```composer.json`` add the repository entry:

``{ "type": "vcs", "url": "https://gitlab.rutschmann.biz/rbiz/layerslider.git" }``

In the ``require`` section of your ``composer.json`` add the extension requirement like this:

``"rbiz/layerslider" : "dev-master"``

Now you can execute the ``composer uodate`` in your project root directory. If you use my gitlab as installation source,
composer asks you for your auth credentials. Type in your username and hit enter. Type in your password. If the credentials
are accepted, the extension gets installed.

Over SSH
''''''''
You can get access to the gitlab repository via ssh to clone and pull this extensions. After you have access to
gitlab.rutschmann.biz, click on your user icon on top left, and choose "Settings". On the left navigation click on
"SSH Keys". Enter your public key in the field. Give them a title or let decide gitlab the title. Click "Add Key".

Now you can access the repository over ssh without need enter your auth info.

In the ``repositories``section of your projects ```composer.json`` add the repository entry:

``{ "type": "vcs", "url": "git@gitlab.rutschmann.biz:rbiz/layerslider.git" }``

In the ``require`` section of your ``composer.json`` add the extension requirement like this:

``"rbiz/layerslider" : "dev-master"``

Now you can execute the ``composer uodate`` in your project root directory.


Generate a key pair
'''''''''''''''''''
If you don't have a key pair, you can generate it very easy. Just log in over ssh on the target server where you want
install the extension. Type in ``ssh-keygen``. Follow the steps and enter a passphrase, or leave blank. After this is
finished, you cann grab the public key with ``cat ~/.ssh/id_rsa.pub``. This is the key that you can paste in the SSH Key
section of gitlab.




Update from version 5 to version 6 (or TER version from 5.4.9 to 5.6.1)
=======================================================================
- Install the new extension with the extension manager, set replace existing one
- Go to the LS6 backend module
- Start the JS migration wizard and drag the layerslider folder to the marked area
- - make sure you have the latest sources from codecanyon for the layerslider. Don't use the jQuery Layerslider Version 5 anymore, download the jQuery LayerSlider Version 6!
- Go in the LS backend module to the list. Each slider shows you a incompatibility warning. Click on it, the slider will be converted
- Open the converted slider and check your settings
- Check if your slide duration ist set correctly
- Check if Transition in is activated
- Check if Transition out is activated, if needed


Create a new slider
===================
- Under the "layerslider" Webmodule you can start create new sliders
- For each slider you can create slides. A slide is at least one image an can have layers. Each layer can be a text, header, paragraph, image or pure html code.
- Check out the Slider options, there are some preinstalled skins!
- Responsive: the slider works responsive out of the box. You can set the width/height of the slider in the slider options.
    Recommend is that you use the width/height from your slider images! By example: Images are 1280x720, set the width/height at
    this values! If you have a div in frontend with 960px, the slider goes down to this 960px by self, and all sublayers would find their new position automatic!
- Place the plugin "Layerslider" on a page. If you dont have changed the "storagePid" your sliders are located on the first page (id 0) in your TYPO3 installation. Select from this page a slider and save the content element.
- Enjoy it :-)

Notes about multipage websites
==============================
- If you have a TYPO3 installation with multiple websites, you can set different pages to save the slider.
    Just include on every website starting page the static extension template as described above. Insert in your template constants on each starting page this line:
    plugin.tx_layerslider.persistence.storagePid = X
    X is the page where the sliders would be saved. The layerslider Backend Module ist listen to this value too. Now you have only the sliders in the backend list from the page X. You can set a new value on each page in the tree.

Using own CSS files to setup the style of Layer Content
=======================================================
You can include a own css file to style your layer content. You can style h1,h2,h3,h4,h5,h6,p and span with a default style. To address the css correct to the elements by default, and separate the css for each slider, use this css code:
.layerslider-1 h1 {}

Only h1 elements on the slider with the uid 1 is now styled. h1 in each other slider ore not affected. You can style all h1 in all sliders, on all slides too, use this code by example:
.ls-slide h1 {}

You can address elements in a sliders by a single slide too. Address the correct slide with a mix of the slider uid and the slide uid:
.ls-slider-1-slide-1 h1 {}

Each number in each class came from the uid of an element. To get the sliders uid jus mouseover in the Backend on the list of all sliders the slider name. And to get the uid of an slide, make an mouseover in the slide list of an slider.

You can set your own CSS file by set the constants in the constant editor. Here comes a list of the default constant settings in the extension template:

# Set 0 to 1 to include a specific css file in the backend module
plugin.tx_layerslider.settings.useAdditionalBackendCSS.useInBE = 0

# Set 0 to 1 to include a specific css file in the frontend
plugin.tx_layerslider.settings.useAdditionalBackendCSS.useInFE = 0

# Set the full path to the css file from your document root with a starting slash
plugin.tx_layerslider.settings.useAdditionalBackendCSS.path = /typo3conf/ext/layerslider/Resources/Public/css/additionalStyles.css

FAQ
===
- On my slides, the layer are visible for the first time and disappears before the layer animation starts
- - This can be a result from some CSS frameworks or normalizer css. Just set in you css style .ls-l {visibility: hidden}. This solves the problem in most cases



Known problems:
===============
- If you save a slider with many slides or layers, not all slides are updated correctly. Check your php configuration "max_input_vars". Increase this value in your php.ini or by htaccess, if it's possible for your server:
- - php_value max_input_vars 10000
- If you use the bootstrap package (TYPO3 Distribution) check that you include the static layerslider extension TypoScript template AFTER the bootstrap extension template in your root template. The Bootstrap Package overwriter the page.includeJSFooterlibs. Because of that the layerslider JS Files are not included!
- Since version 5.4.3 you need php5.5 or php5.6

Release Notes
=============

Release notes for public version: This release notes are valid for the public version too. Just the version numbers are different. The latest pro version has the same release notes as the public version (Pro 6.1.0 = Light 5.6.1, Pro 5.6.6 = Light 5.4.9)

Release 6.1.3
-------------
- [TASK]: added composer installation documentation
- [TASK]: Added composer
- [TASK]: removed old unnecessary hooks


Release 6.1.2
-------------
- [BUGFIX]: Autostart was resettet on second save
- [BUGFIX]: Copy hidden fields for slides and items
- [TASK]: Set version to 6.1.2

Release 6.1.1
-------------
- [FEATURE]: Render TYPO3 v8.6 typolinks
- [BUGFIX]: Error resolved for linked layers
- [TASK]: f:form.checkboxes not work in BE partial in 8.5.1
- [BUGFIX]: Changed LSGSAP for LS 6.1.6
- [BUGFIX]: Slide duration from wizard not saved
- [BUGFIX]: Removed unnecessary pi2 FlexForm configuration
- [BUGFIX]: Animation on linked layers not worked properly
- [BUGFIX]: savestate for layer panels not worked
- [BUGFIX]: links for layers not worked
- [BUGFIX]: skin not loaded if a custom path is provided
- [BUGFIX]: created sliders has an invalid default value in property slideBGPosition in slider options
- [BUGFIX]: responsiveUnder gives wrong position. BE Slide Tabs and Layers not open after reload
- [BUGFIX]: slideBGPosition default value is wrong

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

