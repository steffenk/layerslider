var transitionSetElement = "";


// console.log(window.GreenSockGlobals);
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    setCopySlideButtons();
    setCopyLayerButtons();
    initDatePicker();
    $(document.body).tooltip({ selector: ".panel-footer a" });
    $('select.item-content-type').each(function(){
        toggleLayerContentType(this);
    });
    setWizardOption();

    $('.timelineInstanceCreator').viewportChecker({
        callbackFunction: function(elem){
            // console.log("ja");
            createTimelineInstance($(elem).data('slider'), $(elem).data('slide'));
            $('#time-line-slide-'+$(elem).data('slide')).show();
        }
    });

    $('input').on('propertychange change click keyup input paste', function(){
        $(this).addClass('changed');
        $('.changedStage').addClass('btn-danger');
    });
    $('#sliderform').submit(function(){
        disableEmptyInputs();
    });
});

function disableEmptyInputs(){
    $('input').each(function(){
        if(($(this).val() == "") && !($(this).hasClass('changed')) && !($(this).hasClass('exclude-disabled'))){
            $(this).prop("disabled", true)
        }
    });

    $('input[type="checkbox"]').each(function(){
        if(($(this).prop('checked') == false) && !($(this).hasClass('changed')) && !($(this).hasClass('exclude-disabled')) ){
            $(this).prop('disabled', true);
        }
    });
    //
    $('select').each(function(){
        if(($(this).val() == '') && !($(this).hasClass('changed')) && !($(this).hasClass('exclude-disabled'))){
            $(this).prop('disabled', true);
        }
    });
    return true;
}

function initDatePicker(){
    $('.input-group.date').datetimepicker({
        format: 'D.M.YYYY HH:mm',
        sideBySide: true,
        allowInputToggle: true,
        showClear: true,
        showClose: true,
        showTodayButton: true,
        toolbarPlacement: 'bottom'
    });
}



function copySlide(e){
    var slideUid = $(e).data('slideuidulement');
    $('a.copyStop').hide();
    $('a.copyStart').show();
    if( parseInt($.cookie('copySlide')) == parseInt(slideUid)){
        $.removeCookie('copySlide', { path: '/' });
        $('*[data-copyslide-uid="'+slideUid+'"]').show();
        $('*[data-stopcopyslide-uid="'+slideUid+'"]').hide();
        setCopySlideButtons();
    } else {
        $.cookie('copySlide', slideUid,  { expires: 1, path: '/' });
        $('*[data-copyslide-uid="'+slideUid+'"]').hide();
        $('*[data-stopcopyslide-uid="'+slideUid+'"]').show();
        setCopySlideButtons();
    }
}

function setCopySlideButtons(){
    var copySlide = $.cookie('copySlide');
    if(copySlide !== undefined){
        $('.pasteSlide').show();
        $('*[data-copyslide-uid="'+copySlide+'"]').hide();
        $('*[data-stopcopyslide-uid="'+copySlide+'"]').show();
    } else {
        $('.pasteSlide').hide();
    }
}
function pasteSlide(e){
    var url = $(e).attr('href');
    url = url+'&tx_layerslider_web_layersliderm1[slide]='+$.cookie('copySlide');
    $.ajax({
        type: "GET",
        url: url
    }).done(function() {
        $(e).closest('form').submit();
    });
    return false;
}


function copyLayer(e){
    var layerUid = $(e).data('layeruidelement');
    $('a.copyLayerStop').hide();
    $('a.copyLayerStart').show();
    if( parseInt($.cookie('copyLayer')) == parseInt(layerUid)){
        $.removeCookie('copyLayer', { path: '/' });
        $('*[data-copylayer-uid="'+layerUid+'"]').show();
        $('*[data-stopcopylayer-uid="'+layerUid+'"]').hide();
        setCopyLayerButtons();
    } else {
        $.cookie('copyLayer', layerUid,  { expires: 1, path: '/' });
        $('*[data-copylayer-uid="'+layerUid+'"]').hide();
        $('*[data-stopcopylayer-uid="'+layerUid+'"]').show();
        setCopyLayerButtons();
    }
}

function setCopyLayerButtons(){
    var copyLayer = $.cookie('copyLayer');
    if(copyLayer !== undefined){
        $('.pasteLayer').show();
        $('*[data-copylayer-uid="'+copyLayer+'"]').hide();
        $('*[data-stopcopylayer-uid="'+copyLayer+'"]').show();
    } else {
        $('.pasteLayer').hide();
    }
}
function pasteLayer(e){
    var url = $(e).attr('href');
    url = url+'&tx_layerslider_web_layersliderm1[item]='+$.cookie('copyLayer');
    //console.log(url);
    $.ajax({
        type: "GET",
        url: url
    }).done(function() {
        $(e).closest('form').submit();
    });
    return false;
}


function newSlide(e){
	$.ajax({
		type: "GET",
		url: $(e).prop("href")
	}).done(function( data ) {
		$(".layerslider-item-slides-area .sortable").append(data);
        initDatePicker();
	});
	return false;
}

function newItem(e, target){
    $.ajax({
        type: "GET",
        url: $(e).prop("href"),
        dataType: 'html'
    }).done(function( data ) {
            $(target).append(data);
            initDatePicker();
            $(data).find("script").each(function(i) {
                // eval($(this).text());
            });
        });

    return false;
}

function storeCollapseCookie(id){
    if($.cookie(id) ){
        $.removeCookie(id);
    } else {
        $.cookie(id, true);
    }
}

function storeTabsCookie(id, tab){
    $.cookie(id, tab);
}

function toggleLayerContentType(select){
    if($('option:selected', select).val() == 'image'){
        $('tr[data-itemimage="'+$(select).data('item')+'"]').show();
        $('tr[data-itemcontenttext="'+$(select).data('item')+'"]').hide();
    } else {
        $('tr[data-itemimage="'+$(select).data('item')+'"]').hide();
        $('tr[data-itemcontenttext="'+$(select).data('item')+'"]').show();
    }
}

function deleteSlide(e){
    $('#delete-slide-'+$(e).data('uid')).modal('hide');

	$.ajax({
		type: "GET",
		url: $(e).prop("href")
	}).done(function( data ) {
		$(e).closest(".layerslider-slideitem").fadeOut(function(){
			$(this).remove();
            if( parseInt($.cookie('copySlide')) == $(e).data('uid')){
                $.removeCookie('copySlide', { path: '/' });
                $('*[data-copyslide-uid="'+$(e).data('uid')+'"]').show();
                $('*[data-stopcopyslide-uid="'+$(e).data('uid')+'"]').hide();
                setCopySlideButtons();
            }

		});
	});

	return false;
}
function deleteItem(e){
    $('#delete-item-'+$(e).data('uid')).modal('hide');

    $.ajax({
        type: "GET",
        url: $(e).prop("href")
    }).done(function( data ) {
            $(e).closest(".layerslider-itemitem").fadeOut(function(){
                $(this).remove();
                if( parseInt($.cookie('copyLayer')) == $(e).data('uid')){
                    $.removeCookie('copyLayer', { path: '/' });
                    $('*[data-copylayer-uid="'+$(e).data('uid')+'"]').show();
                    $('*[data-stopcopylayer-uid="'+$(e).data('uid')+'"]').hide();
                    setCopyLayerButtons();
                }

            });
        });

    return false;
}

function handleTransitions(e){
    $('#transitionPanel').modal('show');
	transitionSetElement = e;
	var tr2dList = $(e).next().val();
	var tr2dListArray = tr2dList.split(",");

	var tr3dList = $(e).next().next().val();
	var tr3dListArray = tr3dList.split(",");

	$("#ls-transition-gallery #slide-transitions-2d a").each(function(){
		$("i", this).hide();
		var eProp = $(this).prop("rel");
		eProp = eProp.replace("tr", "");
		if( $.inArray(eProp, tr2dListArray) > -1 ){
			$("i", this).show();
		}
	});

	$("#ls-transition-gallery #slide-transitions-3d a").each(function(){
		$("i", this).hide();
		var eProp = $(this).prop("rel");
		eProp = eProp.replace("tr", "");
		if( $.inArray(eProp, tr3dListArray) > -1 ){
			$("i", this).show();
		}
	});

}

function setTransition(tElement){
	if( $("i", tElement).is(":visible") ){
		$("i", tElement).hide();
	} else {
		$("i", tElement).show();
	}
	var tr2dString = "";
	var tr3dString = "";
	var i = 0;
	$("#ls-transition-gallery #slide-transitions-2d i:visible").each(function(){
		var thisRel = $(this).parent().prop("rel") ;
		thisRel = thisRel.replace("tr", "");
		tr2dString = tr2dString + thisRel+",";
		i = i+1;
	});

	$(transitionSetElement).next().val( tr2dString.slice(0, tr2dString.length-1) );

	$("#ls-transition-gallery #slide-transitions-3d i:visible").each(function(){
		var thisRel = $(this).parent().prop("rel") ;
		thisRel = thisRel.replace("tr", "");
		tr3dString = tr3dString + thisRel+",";
		i = i+1;
	});

	$(transitionSetElement).next().next().val( tr3dString.slice(0, tr3dString.length-1) );

	$("span", transitionSetElement).html( i );

}

function hideTimeLineObject(slide, layer, el){
    if($(el).hasClass('tlhidden')){
        $(el).removeClass('tlhidden');
        $('.layer-item-position-stage #layer-'+slide+'-'+layer).css({visibility: 'visible'});
    } else {
        $(el).addClass('tlhidden');

        $('.layer-item-position-stage #layer-'+slide+'-'+layer).css({visibility: 'hidden'});
    }
}

function setWizardOption(){
    $('.wizard-option').click(function(){
        $('.wizard-option-check', this).prop("checked", true);
        $('.wizard-option', $(this).closest('.wizard-option-wrapper')).removeClass('wizard-option-active');
        $(this).addClass('wizard-option-active');

    })
}


function showEffectSettings(layer, el){

    if($(el).hasClass('eseditActive')){
        $.removeCookie('showEffectSettings-'+layer);
        $(el).removeClass('eseditActive');
        $('#effect-settings-'+layer).hide();
    } else {
        $.cookie('showEffectSettings-'+layer, true);
        $('.effect-settings-general').hide();
        $('.fa-pencil.esedit').removeClass('eseditActive');
        $(el).addClass('eseditActive');
        $('#effect-settings-'+layer).show();
    }
}

function makeSlideImagesSortable() {
    $('.image-wrapper-sortable').sortable({
        handle: '.fa-arrows',
        items: ' > .wizard-image-wrapper',
        stop: function () {
            setImageUids();
        }
    });
    setImageUids();
}

function removeWizardImage(e) {
    $(e).closest('.wizard-image-wrapper').fadeOut('fast', function () {
        $(this).remove();
        setImageUids();
    })
}

function setImageUids() {
    var uidList = "";
    $('.wizard-image-wrapper > img').each(function () {
        uidList = uidList + $(this).data('uid') + ",";
    });
    $('#uidImageList').val(uidList);
}

function makeSlideItemListSortable(slideUid){
    $( ".slide-item-list-"+slideUid )
        .sortable({
            handle: ".sort-handle",
            stop: function(){
                $('.sortable-value', $( "#time-line-slide-"+slideUid )).each(function(i,e){
                    $(this).val(i);
                });
            }
        });

    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };
}

(function ($) {
    $.fn.getHiddenDimensions = function (includeMargin) {
        var $item = this,
            props = { position: 'absolute', visibility: 'hidden', display: 'block' },
            dim = { width: 0, height: 0, innerWidth: 0, innerHeight: 0, outerWidth: 0, outerHeight: 0 },
            $hiddenParents = $item.parents().andSelf().not(':visible'),
            includeMargin = (includeMargin == null) ? false : includeMargin;

        var oldProps = [];
        $hiddenParents.each(function () {
            var old = {};

            for (var name in props) {
                old[name] = this.style[name];
                this.style[name] = props[name];
            }

            oldProps.push(old);
        });

        dim.width = $item.width();
        dim.outerWidth = $item.outerWidth(includeMargin);
        dim.innerWidth = $item.innerWidth();
        dim.height = $item.height();
        dim.innerHeight = $item.innerHeight();
        dim.outerHeight = $item.outerHeight(includeMargin);

        $hiddenParents.each(function (i) {
            var old = oldProps[i];
            for (var name in props) {
                this.style[name] = old[name];
            }
        });

        return dim;
    }
}(jQuery));
