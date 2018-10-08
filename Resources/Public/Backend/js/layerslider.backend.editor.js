function updatePositionArea(targetStage, sourceSettings, sliderUid, slideUid){
    // console.log('ja');
    $(sourceSettings).each(function(){
        var itemUid = $(this).data('uid');
        var contentType = $(".item-content-type option:selected", this).val();
        var content = $('*[data-element="content"]', this);
        $(targetStage + " #" + $(content).data("layerid") ).parent().remove();

        if(contentType == 'h1'){
            placeElement( $("<h1 />"), content, this, targetStage, false );
        }
        if(contentType == 'h2'){
            placeElement( $("<h2 />"), content, this, targetStage, false );
        }
        if(contentType == 'h3'){
            placeElement( $("<h3 />"), content, this, targetStage, false );
        }
        if(contentType == 'h4'){
            placeElement( $("<h4 />"), content, this, targetStage, false );
        }
        if(contentType == 'h5'){
            placeElement( $("<h5 />"), content, this, targetStage, false );
        }
        if(contentType == 'h6'){
            placeElement( $("<h6 />"), content, this, targetStage, false );
        }
        if(contentType == 'paragraph'){
            placeElement( $("<p />"), content, this, targetStage, false );
        }
        if(contentType == 'span'){
            placeElement( $("<span />"), content, this, targetStage, false );
        }
        if(contentType == 'html'){
            placeElement( $("<div />").addClass('resizeable'), content, this, targetStage, false );
        }

        if(contentType == 'image'){
            placeElement($("<img />"), content, this, targetStage , true);
        }



    });

    function placeElement(newElement, content, e, targetStage, img){
        //console.log(e);
        var wrapper = $('<div />').addClass('ls-wrapper').addClass('ls-in-out').addClass("candrag");

        if(img === true){
            $(newElement).attr("src", $('*[data-element="image-content"]', e).data('itemurl')).css({
                width: function(){
                    if( $('*[data-element="width"]', e).val().length > 0 ){
                        return $('*[data-element="width"]', e).val()+"px";
                    }
                },
                height: function(){
                    if( $('*[data-element="height"]', e).val().length > 0 ){
                        return $('*[data-element="height"]', e).val()+"px";
                    }
                },
            });
            wrapper.html(newElement).css({
                left: $('*[data-element="left"]', e).val()+"px",
                top: $('*[data-element="top"]', e).val()+"px",
                width: function(){
                    if( $('*[data-element="width"]', e).val().length > 0 ){
                        return $('*[data-element="width"]', e).val()+"px";
                    }
                },
                height: function(){
                    if( $('*[data-element="height"]', e).val().length > 0 ){
                        return $('*[data-element="height"]', e).val()+"px";
                    }
                },
                display: 'block'
            }).addClass('resizeable').addClass('img-resize');

        } else {
            newElement.html( $('*[data-element="content"]', e).val()).css({
                width: function(){
                    if( $('*[data-element="width"]', e).val().length > 0 ){
                        return $('*[data-element="width"]', e).val()+"px";
                    }
                },
                height: function(){
                    if( $('*[data-element="height"]', e).val().length > 0 ){
                        return $('*[data-element="height"]', e).val()+"px";
                    }
                }
            });
            wrapper.html(newElement).css({
                left: $('*[data-element="left"]', e).val()+"px",
                top: $('*[data-element="top"]', e).val()+"px",
                width: function(){
                    if( $('*[data-element="width"]', e).val().length > 0 ){
                        return $('*[data-element="width"]', e).val()+"px";
                    }
                },
                height: function(){
                    if( $('*[data-element="height"]', e).val().length > 0 ){
                        return $('*[data-element="height"]', e).val()+"px";
                    }
                },
                display: 'block'
            });
        }
        newElement.css({
            position: "static",
            left: $('*[data-element="left"]', e).val()+"px",
            top: $('*[data-element="top"]', e).val()+"px",
            textAlign: function(){
                if( $('*[data-element="textalign"] option:selected', e).val().length > 0 ){
                    return $('*[data-element="textalign"] option:selected', e).val();
                }
            },
            fontSize: function(){
                if( $('*[data-element="fontsize"]', e).val().length > 0 ){
                    return $('*[data-element="fontsize"]', e).val()+"px";
                }
            },
            color: function(){
                if( $('*[data-element="fontcolor"]', e).val().length > 0 ){
                    return $('*[data-element="fontcolor"]', e).val();
                }
            },
            background: function(){
                if( $('*[data-element="backgroundcolor"]', e).val().length > 0 ){
                    return $('*[data-element="backgroundcolor"]', e).val();
                }
            },
            paddingRight: function(){
                if( $('*[data-element="paddingright"]', e).val().length > 0 ){
                    return $('*[data-element="paddingright"]', e).val()+"px";
                }
            },
            paddingTop: function(){
                if( $('*[data-element="paddingtop"]', e).val().length > 0 ){
                    return $('*[data-element="paddingtop"]', e).val()+"px";
                }
            },
            paddingBottom: function(){
                if( $('*[data-element="paddingbottom"]', e).val().length > 0 ){
                    return $('*[data-element="paddingbottom"]', e).val()+"px";
                }
            },
            paddingLeft: function(){
                if( $('*[data-element="paddingleft"]', e).val().length > 0 ){
                    return $('*[data-element="paddingleft"]', e).val()+"px";
                }
            },
            borderTop: function(){
                if( $('*[data-element="bordertop"]', e).val().length > 0 ){
                    return $('*[data-element="bordertop"]', e).val();
                }
            },
            borderRight: function(){
                if( $('*[data-element="borderright"]', e).val().length > 0 ){
                    return $('*[data-element="borderright"]', e).val();
                }
            },
            borderBottom: function(){
                if( $('*[data-element="borderbottom"]', e).val().length > 0 ){
                    return $('*[data-element="borderbottom"]', e).val();
                }
            },
            borderLeft: function(){
                if( $('*[data-element="borderleft"]', e).val().length > 0 ){
                    return $('*[data-element="borderleft"]', e).val();
                }
            }

        }).prop("id", $(content).data("layerid")).addClass("ls-s3").addClass('ls-layer');

        var dataLs = "";

        var effectSettings = $('#effect-settings-'+$(e).data('uid'));

        var propertyList = {
            transitionin: 'checked',
            fadein: 'checked',
            offsetxin: 'number',
            offsetyin: 'number',
            durationin: 'length',
            easingin: 'length',
            startatin: 'length',
            scalexin: 'length',
            scaleyin: 'length',
            skewxin: 'length',
            skewyin: 'length',
            rotatein: 'length',
            rotatexin: 'length',
            rotateyin: 'length',
            transformoriginin: 'length',
            bgcolorin: 'length',
            colorin: 'length',
            radiusin: 'length',
            widthin: 'length',
            heightin: 'length',
            transformperspectivein: 'length',
            clipin: 'length',
            filterin: 'length',

            texttransitionin: 'checked',
            textstartatin: 'length',
            texttypein: 'length',
            textshiftin: 'length',
            textoffsetxin: 'length',
            textoffsetyin: 'length',
            textdurationin: 'length',
            texteasingin: 'length',
            textfadein: 'checked',
            textrotatein: 'length',
            textrotatexin: 'length',
            textrotateyin: 'length',
            textscalexin: 'length',
            textscaleyin: 'length',
            textskewxin: 'length',
            textskewyin: 'length',
            texttransformoriginin: 'length',
            texttransformperspectivein: 'length',

            texttransitionout: 'checked',
            textstartatout: 'length',
            texttypeout: 'length',
            textshiftout: 'length',
            textoffsetxout: 'length',
            textoffsetyout: 'length',
            textdurationout: 'length',
            texteasingout: 'length',
            textfadeout: 'checked',
            textrotateout: 'length',
            textrotatexout: 'length',
            textrotateyout: 'length',
            textscalexout: 'length',
            textscaleyout: 'length',
            textskewxout: 'length',
            textskewyout: 'length',
            texttransformoriginout: 'length',
            texttransformperspectiveout: 'length',

            loop: 'checked',
            loopstartat: 'length',
            loopoffsetx: 'length',
            loopoffsety: 'length',
            loopduration: 'length',
            loopeasing: 'length',
            loopopacity: 'length',
            looprotate: 'length',
            looprotatex: 'length',
            looprotatey: 'length',
            loopskewx: 'length',
            loopskewy: 'length',
            loopscalex: 'length',
            loopscaley: 'length',
            looptransformorigin: 'length',
            loopclip: 'length',
            loopcount: 'length',
            looprepeatdelay: 'length',
            loopyoyo: 'checked',
            looptransformperspective: 'length',
            loopfilter: 'length',

            transitionout: 'checked',
            fadeout: 'checked',
            offsetxout: 'number',
            offsetyout: 'number',
            durationout: 'length',
            easingout: 'length',
            startatout: 'length',
            scalexout: 'length',
            scaleyout: 'length',
            skewxout: 'length',
            skewyout: 'length',
            rotateout: 'length',
            rotatexout: 'length',
            rotateyout: 'length',
            transformoriginout: 'length',
            bgcolorout: 'length',
            colorout: 'length',
            radiusout: 'length',
            widthout: 'length',
            heightout: 'length',
            transformperspectiveout: 'length',
            clipout: 'length',
            filterout: 'length'

        };

        dataLs = '';
        $.each(propertyList, function(key, value){
            // console.log(value);
            if(value == 'checked'){
                if($('*[data-element="' + key + '"]', effectSettings).is(':checked')){
                    dataLs = dataLs + key + ':true;';
                }
            }
            if( (value == 'number') && ($('*[data-element="' + key + '"]', effectSettings).val().length > 0) ){
                if( ($('*[data-element="' + key + '"]', effectSettings).val() == 'number') ){
                    dataLs = dataLs + key + ':' + $('*[data-element="' + key + 'number"]', effectSettings).val() + ";";
                } else {
                    dataLs = dataLs + key + ':' + $('*[data-element="' + key + '"]', effectSettings).val() + ";";
                }
            }
            if( (value == 'length') && ($('*[data-element="' + key + '"]', effectSettings).val().length > 0)){
                dataLs = dataLs + key + ':'+$('*[data-element="' + key + '"]', effectSettings).val() + ";";
            }
        });

        newElement.data('ls', dataLs);

        if( $('*[data-element="cssstyle"]', e).val().length > 0 ){
            $( newElement.attr("style", newElement.attr("style") + $('*[data-element="cssstyle"]', e).val() ) );
        }

        if( $('*[data-element="cssclass"]', e).val().length > 0 ){
            $( newElement.addClass( $('*[data-element="cssclass"]', e).val() ));
        }

        $(targetStage + " .ls-slide").append(wrapper);
    }

    connectDragableElementsToArea(slideUid);

}


function connectDragableElementsToArea(slideUid){
    $( ".candrag" ).draggable({
        start: function(event, ui){
            if($(this).hasClass('transition-running')){
                // $('#notDragable').modal('show');
                // return false;
            }
            buildHelperBoxes(this, slideUid);
        },
        drag: function(event, ui){
            var position = $(this).position();
            $(topHelper).height((position.top-1));
            $(bottomHelper).height( ($('div[data-slidePoitioningLayer="'+slideUid+'"]').height()- position.top) - $(this).outerHeight()-1);
            $(leftHelper).width((position.left-1));
            $(rightHelper).width( $('div[data-slidePoitioningLayer="'+slideUid+'"]').width() - position.left - $(this).outerWidth() -1 );
        },
        stop: function(event, ui){
            var theId = $(this).children().prop("id");
            $("#"+theId+"-left").val(ui.position.left);
            $("#"+theId+"-top").val(ui.position.top);
            $(topHelper).remove();
            $(bottomHelper).remove();
            $(leftHelper).remove();
            $(rightHelper).remove();
        },
        containment: "parent"
    });


    $('.stage-'+slideUid+' .candrag.resizeable').each(function(){
        // console.log($(this).hasClass('img-resize'));
        if($(this).hasClass('img-resize')){
            aspectRatio = true;
        } else {
            aspectRatio = false;
        }
        $(this).resizable({
            aspectRatio: aspectRatio,
            containment: "parent",
            stop:function(){
                var theId = $(this).children().prop("id");
                $("#"+theId+"-width").val($(this).width());
                $("#"+theId+"-height").val($(this).height());
                $(topHelper).remove();
                $(bottomHelper).remove();
                $(leftHelper).remove();
                $(rightHelper).remove();
            },
            start: function(){
                if($(this).hasClass('transition-running')){
                    $('#notDragable').modal('show');
                    return false;
                }

                buildHelperBoxes($(this), slideUid);
            },
            resize: function(){
                if($(this).hasClass('transition-running')){
                    return false;
                }
                var position = $(this).position();
                $(this).children('.ls-layer').width($(this).width());
                $(this).children('.ls-layer').height($(this).height());
                $(topHelper).height((position.top-1));
                $(bottomHelper).height( ($('div[data-slidePoitioningLayer="'+slideUid+'"]').height()- position.top) - $(this).height()-1);
                $(leftHelper).width((position.left-1));
                $(rightHelper).width( $('div[data-slidePoitioningLayer="'+slideUid+'"]').width() - position.left - $(this).width() -1 );
            }
        });

    });

    function buildHelperBoxes(target, slideUid){
        topHelper = $('<div />').css({
            position: 'absolute',
            width: '100%',
            zIndex: 500,
            height: '0',
            background: 'rgba(0,0,0,0.3)',
            borderBottom: '1px solid green'
        }).addClass('positionbox');
        var topHelperMeasure = $('<span />').css({
            position: 'absolute',

        });
        bottomHelper = $('<div />').css({
            position: 'absolute',
            width: '100%',
            zIndex: 500,
            height: '0',
            bottom: 0,
            top: 'auto',
            background: 'rgba(0,0,0,0.3)',
            borderTop: '1px solid green',

        }).addClass('positionbox');
        leftHelper = $('<div />').css({
            position: 'absolute',
            width: '0',
            zIndex: 500,
            height: $('img[data-imageforslide="'+slideUid+'"]').height(),
            top: '0',
            background: 'rgba(0,0,0,0.3)',
            borderRight: '1px solid green'
        }).addClass('positionbox');
        rightHelper = $('<div />').css({
            position: 'absolute',
            width: '0',
            zIndex: 500,
            height: $('img[data-imageforslide="'+slideUid+'"]').height(),
            top: '0',
            right: '0',
            left: 'auto',
            background: 'rgba(0,0,0,0.3)',
            borderLeft: '1px solid green'
        }).addClass('positionbox');
        $(target).before(topHelper);
        $(target).before(bottomHelper);
        $(target).before(leftHelper);
        $(target).before(rightHelper);
    }
}