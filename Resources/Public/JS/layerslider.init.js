$(document).ready(function(){
    $('div[data-lsoptions-uid]').each(function(){
        var layerslider, configurationArray;
        layerslider = $(this);
        configurationArray = layerslider.data();
        delete configurationArray['lsoptionsUid'];
        $(layerslider).layerSlider(configurationArray);
    });
});
