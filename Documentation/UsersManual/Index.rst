.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _users-manual:


Extension installation notes
=============
Documentation
=============


Extension Manual
================

Installation
============
- Install the extension (layerslider.zip) with the extension manager or extract the zip and upload the content in typo3conf/ext/layerslider
- Include the static TypoScript template "layerslider" in your root template!
- Check the constant editor "PLUGIN.TX_LAYERSLIDER (6)" for some setting about the include from jquery and other needed libraries. Use always the latest jquery library!
- Open the Layerslider Backend Module and start the JS Migartion Assistant (right top corner). Here you can easy integrate the jQuery Layerslider Plugin from codecanyon (http://codecanyon.net/item/layerslider-responsive-jquery-slider-plugin/922100).
- If you like this extension, you can get the pro version under http://www.rutschmann.biz/en/extensions/typo3-layerslider/order/
- CLEAR THE CACHE!!!!

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


Known problems:
===============
- If you save a slider with many slides or layers, not all slides are updated correctly. Check your php configuration "max_input_vars". Increase this value in your php.ini or by htaccess, if it's possible for your server:

- - php_value max_input_vars 10000

- If you use the bootstrap package (TYPO3 Distribution) check that you include the static layerslider extension TypoScript template AFTER the bootstrap extension template in your root template. The Bootstrap Package overwriter the page.includeJSFooterlibs. Because of that the layerslider JS Files are not included!