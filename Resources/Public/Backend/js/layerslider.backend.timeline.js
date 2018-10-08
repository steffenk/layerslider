
/**
 *
 */
function createTimelineInstance(sliderUid, slideUid){

    var slide, sliderHandle, timerButton, timelineOverlay, layers, timelineProgress, timeline, slideData, layerDataDefaults, layershasinfiniteloop;

    layershasinfiniteloop = false;
    slide = $('.stage-' + slideUid + ' .ls-slider-' + sliderUid + '-slide-' + slideUid);
    sliderHandle = $("#slider-" + slideUid);
    timerButton = $('.timer-' + slideUid);
    timelineOverlay = $('#time-line-slide-' + slideUid + ' .timeline-td-overlay');
    layers = $(' > *', slide);
    timelineProgress = 0;
    timeline = new LS_GSAP.TimelineMax();
    slideData = extractDataLsData(slide);
    layerDataDefaults = {
        transitionin: null,
        offsetxin: null,
        offsetyin: null,
        durationin: 1000,
        startatin: 0,
        easingin: 'easeInOutQuint',
        fadein: false,
        rotatein: 0,
        rotatexin: 0,
        rotateyin: 0,
        skewxin: 0,
        skewyin: 0,
        scalexin:1,
        scaleyin: 1,
        transformoriginin: '50% 50% 0',
        clipin: null,
        bgcolorin: null,
        colorin: null,
        radiusin: null,
        widthin: null,
        heightin: null,
        filterin: null,
        transformperspectivein: 500,

        texttransitionin: false,
        textstartatin: 'transitioninend',
        texttypein: 'chars_asc',
        textshiftin: 50,
        textoffsetxin: null,
        textoffsetyin: null,
        textdurationin: 1000,
        texteasingin: 'easeInOutQuint',
        textfadein: false,
        textrotatein: 0,
        textrotatexin: 0,
        textrotateyin: 0,
        textscalexin: 1,
        textscaleyin: 1,
        textskewxin: 0,
        textskewyin: 0,
        texttransformoriginin: '50% 50% 0',
        texttransformperspectivein: 500,

        loop: false,
        loopstartat: 'allinend',
        loopoffsetx: null,
        loopoffsety: null,
        loopduration: 1000,
        loopeasing: 'linear',
        loopopacity: 1,
        looprotate: 0,
        looprotatex: 0,
        looprotatey: 0,
        loopskewx: 0,
        loopskewy: 0,
        loopscalex: 1,
        loopscaley: 1,
        looptransformorigin: '50% 50% 0',
        loopclip: null,
        loopcount: 1,
        looprepeatdelay: 0,
        loopyoyo: false,
        looptransformperspective: 500,
        loopfilter: null,

        texttransitionout: false,
        textstartatout: 'allinandloopend',
        texttypeout: 'chars_asc',
        textshiftout: 50,
        textoffsetxout: null,
        textoffsetyout: null,
        textdurationout: 1000,
        texteasingout: 'easeInOutQuint',
        textfadeout: false,
        textrotateout: 0,
        textrotatexout: 0,
        textrotateyout: 0,
        textscalexout: 1,
        textscaleyout: 1,
        textskewxout: 0,
        textskewyout: 0,
        texttransformoriginout: '50% 50% 0',
        texttransformperspectiveout: 500,

        transitionout: null,
        startatout: 'slidechangeonly',
        offsetxout: null,
        offsetyout: null,
        durationout: 1000,
        easingout: 'easeInOutQuint',
        fadeout: false,
        rotateout: 0,
        rotatexout: 0,
        rotateyout: 0,
        skewxout: 0,
        skewyout: 0,
        scalexout: 1,
        scaleyout: 1,
        transformoriginout: '50% 50% 0',
        clipout: null,
        filterout: null,
        transformperspectiveout: 500,
        bgcolorout: null,
        colorout: null,
        radiusout: null,
        widthout: null,
        heightout: null
    };

    reset();

    layers.each(function (i,p) {

        var parent, layerData, layerTimebar, layerLoopTimebar, lsWrapper,
            lsClip, lsSlide, clipLayerDimensions, tweenInWrapperOptions, tweenInLayerOptions,
            tweenLoopWrapperOptions, tweenOutWrapperOptions, tweenOutLayerOptions,
            tweenInWrapperTransformPerspective, tweenOutWrapperTransformPerspective,
            tweenLoopWrapperTransformPerspective, tweenLoopLayerOptions,
            tweenInTextLayerOptions, tweenOutTextLayerOptions, splitText, splitTextElementsin,
            splitTextElementsout, layerTextTimebar, layerElement;


        parent = $(p);
        layerElement = $('.ls-layer', p);
        layerData = mergeDefaults(extractDataLsData(layerElement), layerDataDefaults);
        layerTimebar = $('.duration-' + layerElement.prop('id'));
        layerLoopTimebar = $('.durationloop-' + layerElement.prop('id'));
        layerTextTimebar = $('.durationtext-' + layerElement.prop('id'));
        lsWrapper = layerElement.closest('.ls-in-out');
        lsClip = layerElement.closest('.ls-clip');
        lsSlide = layerElement.closest('.ls-slide');
        clipLayerDimensions = '0 ' + layerElement.getHiddenDimensions().outerWidth + 'px ' + layerElement.getHiddenDimensions().outerHeight + 'px ' + '0';
        tweenInWrapperOptions = {
            opacity: layerData.fadein ? 0 : 1,
            ease: layerData.easingin,
            x: parsePosition(layerData.offsetxin),
            y: parsePosition(layerData.offsetyin),
            rotation: parsePosition(layerData.rotatein),
            rotationX: parsePosition(layerData.rotatexin),
            rotationY: parsePosition(layerData.rotateyin),
            skewX: parsePosition(layerData.skewxin),
            skewY: parsePosition(layerData.skewyin),
            scaleX: parsePosition(layerData.scalexin),
            scaleY: parsePosition(layerData.scaleyin),
            transformOrigin: layerData.transformoriginin,
            width: layerData.widthin,
            height: layerData.heightin,
            onStart: function(){
                parent.addClass('layer-visible');
            },
            onUpdate: function () {
                parent.addClass('transition-running');
                parent.addClass('layer-visible');
            },
            onComplete: function () {
                parent.removeClass('transition-running');
            },
            onReverseComplete: function () {
                parent.removeClass('transition-running');
                parent.removeClass('layer-visible');
            }
        };
        tweenInWrapperTransformPerspective = {
            transformPerspective: layerData.transformperspectivein
        };
        tweenInLayerOptions = {
            ease: layerData.easingin ? layerData.easingin : null,
            backgroundColor: layerData.bgcolorin,
            color: layerData.colorin,
            borderRadius: layerData.radiusin,
            width: layerData.widthin,
            height: layerData.heightin,
            onUpdate: function(){
                applyFilters(this, layerData.filterin, 'in');
            }

        };
        tweenLoopWrapperOptions = {
            x: parsePosition(layerData.loopoffsetx),
            y: parsePosition(layerData.loopoffsety),
            opacity: layerData.loopopacity,
            rotation: parsePosition(layerData.looprotate),
            rotationX: parsePosition(layerData.looprotatex),
            rotationY: parsePosition(layerData.looprotatey),
            skewX: parsePosition(layerData.loopskewx),
            skewY: parsePosition(layerData.loopskewy),
            scaleX: parsePosition(layerData.loopscalex),
            scaleY: parsePosition(layerData.loopscaley),
            transformOrigin: layerData.looptransformorigin,
            repeat: getRepeat(),
            repeatDelay: layerData.looprepeatdelay.toseconds(),
            yoyo: layerData.loopyoyo,
            ease: layerData.loopeasing,
            onUpdate: function(){
                if(layerData.loopcount === -1){
                    parent.addClass('layer-visible');
                }
                applyFilters(this, layerData.loopfilter, 'out');
            }

        };
        tweenLoopWrapperTransformPerspective = {
            transformPerspective: layerData.looptransformperspective
        };
        tweenLoopLayerOptions = {
            repeat: getRepeat(),
            repeatDelay: layerData.looprepeatdelay.toseconds(),
            yoyo: layerData.loopyoyo,
            ease: layerData.loopeasing,
            onUpdate: function(){
                // parent.addClass('layer-visible');
                applyFilters(this, layerData.loopfilter, 'out');
            }
        };
        tweenOutWrapperOptions = {
            opacity: layerData.fadeout ? 0 : 1,
            ease: layerData.easingout ? layerData.easingout : null,
            x: parsePosition(layerData.offsetxout),
            y: parsePosition(layerData.offsetyout),
            rotation: parsePosition(layerData.rotateout),
            rotationX: parsePosition(layerData.rotatexout),
            rotationY: parsePosition(layerData.rotateyout),
            skewX: parsePosition(layerData.skewxout),
            skewY: parsePosition(layerData.skewyout),
            transformOrigin: layerData.transformoriginout,
            width: layerData.widthout,
            height: layerData.heightout,
            onStart: function(){
                parent.addClass('layer-visible');
            },
            onUpdate: function () {
                parent.addClass('transition-running');
                parent.addClass('layer-visible');
            },
            onComplete: function () {
                parent.removeClass('transition-running');
                parent.removeClass('layer-visible');
            },
            onReverseComplete: function () {
                parent.removeClass('transition-running');
                parent.addClass('layer-visible');
            }
        };
        tweenOutWrapperTransformPerspective = {
            transformPerspective: layerData.transformperspectiveout
        };
        tweenOutLayerOptions = {
            ease: layerData.easingout ? layerData.easingout : null,
            backgroundColor: layerData.bgcolorout,
            color: layerData.colorout,
            borderRadius: layerData.radiusout,
            width: layerData.widthout,
            height: layerData.heightout,
            onUpdate: function(){
                applyFilters(this, layerData.filterout, 'out');
            }
        };


        if(layerData.transitionin){
            timeline
                .add(LS_GSAP.TweenMax.from(parent, layerData.durationin.toseconds(), cleanUpOptions(tweenInWrapperOptions)), layerData.startatin.toseconds())
                .add(LS_GSAP.TweenMax.from(layerElement, layerData.durationin.toseconds(), cleanUpOptions(tweenInLayerOptions)), layerData.startatin.toseconds())
                .add(LS_GSAP.TweenMax.from(parent, layerData.durationin.toseconds(), cleanUpOptions(tweenInWrapperTransformPerspective)), layerData.startatin.toseconds())
        }

        if(layerData.texttransitionin || layerData.texttransitionout){
            if(layerData.texttypein.match(/(.*)_/)){
                splitTextElementsin = doSplitText(layerData.texttypein);
            }

            if(layerData.texttypeout.match(/(.*)_/)){
                splitTextElementsout = doSplitText(layerData.texttypeout);
            }
        }
        if(layerData.texttransitionin === true){
            tweenInTextLayerOptions = {
                ease: layerData.texteasingin ? layerData.texteasingin : null,
                opacity: layerData.textfadein ? 0 : 1,
                transformOrigin: layerData.texttransformoriginin,
                transformPerspective: layerData.texttransformperspectivein,
                cycle: {
                    x: parseCyclePosition(layerData.textoffsetxin, splitTextElementsin).toArray(),
                    y: parseCyclePosition(layerData.textoffsetyin, splitTextElementsin).toArray(),
                    rotation: parseCyclePosition(layerData.textrotatein, splitTextElementsin).toArray(),
                    rotationX: parseCyclePosition(layerData.textrotatexin, splitTextElementsin).toArray(),
                    rotationY: parseCyclePosition(layerData.textrotateyin, splitTextElementsin).toArray(),
                    skewX: parseCyclePosition(layerData.textskewxin, splitTextElementsin).toArray(),
                    skewY: parseCyclePosition(layerData.textskewyin, splitTextElementsin).toArray(),
                    scaleX: parseCyclePosition(layerData.textscalexin, splitTextElementsin).toArray(),
                    scaleY: parseCyclePosition(layerData.textscaleyin, splitTextElementsin).toArray()
                },
                onStart: function(){
                    parent.addClass('layer-visible');
                },
                onUpdate: function () {
                    parent.addClass('transition-running');
                    parent.addClass('layer-visible');
                },
                onComplete: function () {
                    parent.removeClass('transition-running');
                },
                onReverseComplete: function () {
                    parent.removeClass('transition-running');
                }

            };
            timeline
                .add(LS_GSAP.TweenMax.staggerFrom(splitTextElementsin, layerData.textdurationin.toseconds(), cleanUpOptions(tweenInTextLayerOptions), layerData.textshiftin.toseconds()), layerData.textstartatin.toseconds())
        }
        if(layerData.texttransitionout === true){
            tweenOutTextLayerOptions = {
                ease: layerData.texteasingout ? layerData.texteasingout : null,
                opacity: layerData.textfadeout ? 0 : 1,
                transformOrigin: layerData.texttransformoriginout,
                transformPerspective: layerData.texttransformperspectiveout,
                cycle: {
                    x: parseCyclePosition(layerData.textoffsetxout, splitTextElementsout).toArray(),
                    y: parseCyclePosition(layerData.textoffsetyout, splitTextElementsout).toArray(),
                    rotation: parseCyclePosition(layerData.textrotateout, splitTextElementsout).toArray(),
                    rotationX: parseCyclePosition(layerData.textrotatexout, splitTextElementsout).toArray(),
                    rotationY: parseCyclePosition(layerData.textrotateyout, splitTextElementsout).toArray(),
                    skewX: parseCyclePosition(layerData.textskewxout, splitTextElementsout).toArray(),
                    skewY: parseCyclePosition(layerData.textskewyout, splitTextElementsout).toArray(),
                    scaleX: parseCyclePosition(layerData.textscalexout, splitTextElementsout).toArray(),
                    scaleY: parseCyclePosition(layerData.textscaleyout, splitTextElementsout).toArray()
                },
                onStart: function(){
                    parent.addClass('layer-visible');
                },
                onUpdate: function () {
                    parent.addClass('transition-running');
                    parent.addClass('layer-visible');
                },
                onComplete: function () {
                    parent.removeClass('transition-running');
                },
                onReverseComplete: function () {
                    parent.removeClass('transition-running');
                }

            };
            timeline
                .add(LS_GSAP.TweenMax.staggerTo(splitTextElementsout, layerData.textdurationout.toseconds(), cleanUpOptions(tweenOutTextLayerOptions), layerData.textshiftout.toseconds()), layerData.textstartatout.toseconds())
        }

        if(layerData.transitionout){
            timeline
                .add(LS_GSAP.TweenMax.to(parent, layerData.durationout.toseconds(), cleanUpOptions(tweenOutWrapperOptions)), layerData.startatout.toseconds())
                .add(LS_GSAP.TweenMax.to(layerElement, layerData.durationout.toseconds(), cleanUpOptions(tweenOutLayerOptions)), layerData.startatout.toseconds())
                .add(LS_GSAP.TweenMax.to(parent, layerData.durationout.toseconds(), cleanUpOptions(tweenOutWrapperTransformPerspective)), layerData.startatout.toseconds());
        }

        if(layerData.clipin){
            timeline.add(LS_GSAP.TweenMax.fromTo(lsClip, layerData.durationin.toseconds(), {
                ease: layerData.easingin ? layerData.easingin : null,
                clip: clipParams(layerData.clipin)
            }, {
                ease: layerData.easingin ? layerData.easingin : null,
                clip: 'rect(' + clipLayerDimensions + ')'
            }).startTime(0), layerData.startatin.toseconds())
        }

        if(layerData.loopclip){
            timeline.add(LS_GSAP.TweenMax.fromTo(lsClip, layerData.loopduration.toseconds(), {
                ease: layerData.loopeasing ? layerData.loopeasing : null,
                clip: clipParams(layerData.loopclip),
                overwrite: 'none'
            }, {
                ease: layerData.loopeasing ? layerData.loopeasing : null,
                clip: 'rect(' + clipLayerDimensions + ')'
            }).startTime(0), layerData.loopstartat.toseconds())
        }

        if((layerData.loop) && (typeof getRepeat() !== 'undefined')){
            timeline
                .add(LS_GSAP.TweenMax.to(parent, layerData.loopduration.toseconds(), cleanUpOptions(tweenLoopWrapperOptions)).startTime(0), layerData.loopstartat.toseconds())
                .add(LS_GSAP.TweenMax.to(parent, layerData.loopduration.toseconds(), cleanUpOptions(tweenLoopWrapperTransformPerspective)).startTime(0), layerData.loopstartat.toseconds())
                .add(LS_GSAP.TweenMax.to(layerElement, layerData.loopduration.toseconds(), cleanUpOptions(tweenLoopLayerOptions)).startTime(0), layerData.loopstartat.toseconds())
            ;
        }

        timeline.eventCallback("onUpdate", updateSlider).progress(0).pause();

        /**
         *
         * @param texttype
         */
        function doSplitText(texttype){
            var splitTextElements, mode, ordering;
            if(typeof splitText == 'undefined'){
                splitText = new SplitType(layerElement);
            }
            mode = texttype.match(/(.*)_/)[1];
            ordering = texttype.match(/_(.*)/)[1];

            switch (mode){
                case 'lines':
                    splitTextElements = orderTextSplit(splitText.lines, ordering);
                    break;
                case 'words':
                    splitTextElements = orderTextSplit(splitText.words, ordering);
                    break;
                case 'chars':
                    splitTextElements = orderTextSplit(splitText.chars, ordering);
                    break;
            }

            return splitTextElements;
        }

        /**
         *
         * @param splitType
         * @param orderType
         * @returns {*}
         */
        function orderTextSplit(splitType, orderType) {
            var i, halfLength, tmpSplit;

            tmpSplit = splitType;

            if (orderType == 'desc') {
                tmpSplit = splitType.slice(0).reverse();
            } else if (orderType == 'rand') {
                tmpSplit = splitType.slice(0).sort(function () {
                    return.5 - Math.random()
                });
            } else if (orderType == 'center') {
                halfLength = Math.floor(splitType.length / 2);
                for (tmpSplit = [splitType[halfLength]], i = 1; i <= halfLength; i++) {
                    tmpSplit.push(splitType[halfLength - i], splitType[halfLength + i]);
                }
                tmpSplit.length = splitType.length
            } else if (orderType == 'edge') {
                halfLength = Math.floor(splitType.length / 2);
                for (tmpSplit = [splitType[0]], i = 1; i <= halfLength; i++) {
                    tmpSplit.push(splitType[splitType.length - i], splitType[i]);
                }
                tmpSplit.length = splitType.length
            }
            return tmpSplit;
        }

        /**
         *
         * @param tween
         * @param string
         * @param direction
         */
        function applyFilters(tween, string, direction){
            if(string){
                var search, results, filter, filterdefaults;
                search = /(blur|brightness|contrast|grayscale|hue-rotate|invert|saturate|sepia)/gi;
                results = string.match(search);
                filter = '';
                filterdefaults = {
                    blur: 0,
                    brightness: 100,
                    contrast: 100,
                    grayscale: 0,
                    "hue-rotate": 0,
                    invert: 0,
                    saturate: 100,
                    sepia: 0
                };
                for(var i = 0; i < results.length; i++){
                    var regex, start, end, value, key, tp, inc;
                    key = results[i];
                    regex = new RegExp( key + "\\((.*?)\\)", 'i' );
                    if( string.match(regex).length > 0 ){
                        value = parseInt(string.match(regex)[1]);

                        if(direction === 'in'){
                            start = value;
                            end = filterdefaults[key]
                        } else {
                            start = filterdefaults[key];
                            end = value;
                        }

                        tp = (tween.progress()*100) >> 0;

                        if (start < end){
                            inc = start + Math.abs(start - end)/100 * tp;
                        }else {
                            inc = start - Math.abs(start - end)/100 * tp;
                        }

                        switch(results[i]){
                            case 'blur':
                                filter += key + '(' + inc + 'px) ';
                                break;

                            case 'hue-rotate':
                                filter += key + '(' + inc + 'deg) ';
                                break;

                            default:
                                filter += key + '(' + inc + '%) ';

                        }
                        LS_GSAP.TweenMax.set(layerElement,{
                            '-webkit-filter':filter,
                            'filter':filter
                        });
                    }
                }
            }
        }

        createTimeBars();
        /**
         *
         */
        function createTimeBars(){

            layerData.totalduration = (slideData.duration  - (slideData.duration - layerData.startatout - layerData.durationout ));
            layerData.texttotalduration = (slideData.duration  - (slideData.duration - layerData.textstartatout - layerData.textdurationout ));
            layerTimebar.css({width: getWidth()+"%", marginLeft: getMarginLeft() + "%", background:'linear-gradient(135deg, #efcb92 ' + getBackgroundIn() + '%, #5fbe65 0px ,#5fbe65 ' + getBackgroundOut() + '%, #efcb92 0px)'});
            if(layerData.loop === true){
                layerLoopTimebar.css({width: getWidthLoop()+"%", marginLeft: getMarginLeftLoop()+"%"});
                layerLoopTimebar.show();
            }
            if(layerData.texttransitionin || layerData.texttranistionout){
                layerTextTimebar.css({width: getTextWidth()+"%", marginLeft: getTextMarginLeft() + "%", background:'linear-gradient(135deg, #8a87d7 ' + getTextBackgroundIn() + '%, #fbb5de 0px ,#fbb5de ' + getTextBackgroundOut() + '%, #8a87d7 0px)'});
                layerTextTimebar.show()
            } else {
                layerTextTimebar.hide()
            }

            function getWidthLoop(){
                var loopcount, looprepeatdelay = 0;
                if(layerData.loop){
                    if(typeof getRepeat() === 'undefined'){
                       return 0;
                    } else if(getRepeat() === 0){
                        loopcount = 1;
                    } else if (getRepeat() > 0){
                        loopcount = getRepeat() + 1;
                    } else {
                        return 100 - getMarginLeftLoop();
                    }

                    if((layerData.loopyoyo === true) || (getRepeat() >= 1 || (getRepeat() === -1))){
                        looprepeatdelay = layerData.looprepeatdelay;
                    }
                    var width = 100 / (slideData.duration  / (((layerData.loopduration + looprepeatdelay) * loopcount) - looprepeatdelay));
                    if((width + getMarginLeftLoop()) > 100){
                        return 100 - getMarginLeftLoop();
                    }
                    return width;
                }
                return 0;
            }
            function getMarginLeftLoop(){
                return (100 / (slideData.duration / layerData.loopstartat));
            }
            function getWidth(){
                var width = ((100 / (slideData.duration / (layerData.durationin + layerData.durationout + ( layerData.startatout - layerData.durationin)) )) - (100 / (slideData.duration / layerData.startatin)));
                if(width > (100 - getMarginLeft())){
                    return 100 - getMarginLeft()
                }
                return width;
            }
            function getMarginLeft(){
                return (100 / (slideData.duration / layerData.startatin));
            }
            function getBackgroundIn(){
                var maxDuration;
                maxDuration = slideData.duration <= layerData.totalduration ? slideData.duration : layerData.totalduration;
                return (layerData.durationin / (maxDuration - (layerData.startatin))) * 100;
            }
            function getBackgroundOut(){
                if(layerData.transitionout){
                    var position;
                    if( layerData.startatout >= slideData.duration){
                        position = 100;
                    } else if( (slideData.duration - layerData.startatout) < layerData.durationout ) {
                        position =  (100 - (((slideData.duration - layerData.startatout) / (slideData.duration - (slideData.duration - ((layerData.startatout + (slideData.duration - layerData.startatout)) - layerData.startatin)))) * 100));
                    } else {
                        position = (100 - ((layerData.durationout / (slideData.duration - (slideData.duration - ((layerData.startatout + layerData.durationout) - layerData.startatin)))) * 100));
                    }
                    return position;
                }

                return 100;
            }

            function getTextWidth(){
                var durationin = 0, durationout = 0, width = 100;

                durationin = (layerData.textdurationin + ((splitTextElementsin.length - 2) * layerData.textshiftin));
                if(layerData.texttransitionout){
                    durationout = (layerData.textdurationout + ((splitTextElementsout.length - 2) * layerData.textshiftout));
                    width = ((100 / (slideData.duration / (durationin + durationout + ( layerData.textstartatout - durationin)) )) - (100 / (slideData.duration / layerData.textstartatin)));
                } else {
                    width = 100 - getTextMarginLeft();
                }

                if(width > (100 - getMarginLeft())){
                    return 100 - getMarginLeft()
                }
                return width;
            }
            function getTextMarginLeft(){
                return (100 / (slideData.duration / layerData.textstartatin));

            }
            function getTextBackgroundIn(){
                var durationin, durationout = 0, totalduration;

                durationin = (layerData.textdurationin + ((splitTextElementsin.length - 2) * layerData.textshiftin));
                if(layerData.texttransitionout) {
                    durationout = (layerData.textdurationout + ((splitTextElementsout.length - 2) * layerData.textshiftout));
                    totalduration = slideData.duration - layerData.textstartatin - (slideData.duration - (layerData.textstartatout + durationout) );
                } else {
                    totalduration = slideData.duration - layerData.textstartatin;
                }
                return ((durationin / totalduration) * 100);
            }
            function getTextBackgroundOut(){
                var durationout = 0, totalduration;
                if(layerData.texttransitionout){
                    durationout = (layerData.textdurationout + ((splitTextElementsout.length - 2) * layerData.textshiftout));
                    totalduration = slideData.duration - layerData.textstartatin - (slideData.duration - (layerData.textstartatout + durationout) );
                    return (100 - ((durationout / totalduration) * 100));
                } else {
                    return 100;
                }
            }

            // function getTextWidth(){
            //     var width, textDurationInComplete, textDurationOutComplete = 0;
            //
            //     textDurationInComplete = (layerData.textdurationin + ((splitTextElementsin.length * layerData.textshiftin) - layerData.textshiftin));
            //     if(layerData.texttransitionout){
            //         textDurationOutComplete = (layerData.textdurationout + ((splitTextElementsout.length * layerData.textshiftout) - layerData.textshiftout));
            //         width = ((100 / (slideData.duration / (textDurationInComplete + textDurationOutComplete + ( layerData.textstartatout - textDurationInComplete)) )) - (100 / (slideData.duration / layerData.textstartatin)));
            //     } else {
            //         width = 100 / (slideData.duration / (slideData.duration - textDurationInComplete + layerData.textstartatin))
            //     }
            //     if(width > (100 - getTextMarginLeft())){
            //         return 100 - getTextMarginLeft()
            //     }
            //     return width;
            // }
            // function getTextMarginLeft(){
            //     return (100 / (slideData.duration / layerData.textstartatin));
            // }
            // function getTextBackgroundIn(){
            //     var maxDuration, textDurationInComplete, start;
            //     textDurationInComplete = (layerData.textdurationin + ((splitTextElementsin.length - 2) * layerData.textshiftin));
            //
            //     maxDuration = slideData.duration <= layerData.texttotalduration ? slideData.duration : layerData.texttotalduration;
            //     console.log(maxDuration);
            //     start = (textDurationInComplete / (maxDuration - layerData.textstartatin)) * 100;
            //     return start;
            // }
            // function getTextBackgroundOut(){
            //     var position = 100, textDurationOutComplete;
            //
            //     if(layerData.texttransitionout){
            //
            //     }
            //     return position;
            // }
        }


        /**
         *
         * @param value
         * @returns {string}
         */
        function clipParams(value){
            var values, calculatedValues;
            values = value.split(" ");
            calculatedValues = '';
            $.each(values, function(k, v){
                if(v.indexOf('px') >= 0){
                    switch (k){
                        case 0:
                            calculatedValues = parseInt(v) + 'px ';
                            break;
                        case 1:
                            calculatedValues += layerElement.getHiddenDimensions().outerWidth - parseInt(v) + 'px ';
                            break;
                        case 2:
                            calculatedValues += layerElement.getHiddenDimensions().outerHeight - parseInt(v) + 'px ';
                            break;
                        case 3:
                            calculatedValues += parseInt(v) + 'px ';
                            break;
                    }
                }
                if(v.indexOf('%') >= 0){
                }
            });
            return 'rect(' + calculatedValues + ')';
        }

        /**
         *
         * @param options
         * @returns {*}
         */
        function cleanUpOptions(options){
            $.each(options, function(key, value){
               if( (typeof value === 'undefined') || (value === null)){
                   delete options[key];
               }
            });
            return options;
        }

        /**
         *
         */
        function getRepeat(){
            var loopyoyo = 1;
            if(layerData.loopyoyo){
                loopyoyo = 2;
            }
            if(layerData.loopcount === -1){
                layershasinfiniteloop = true;
                return layerData.loopcount;
            }
            if(layerData.loopcount === 0){
                return 0;
            }
            if(layerData.loopcount >= 1){
                return ((layerData.loopcount) * loopyoyo) - 1;
            }
        }

        /**
         *
         * @param type
         * @param elements
         * @returns {*}
         */
        function parseCyclePosition(type, elements){
            var random = [];
            if (String(type).split("|").length > 1){
                return String(type).split("|");
            } else if (String(type).match(/random/)){
                if(elements && elements.length > 0){
                    for(i = 0; i < elements.length; i++){
                        random.push(getRandom());
                    }
                    function getRandom(){
                        return (Math.random() * (parseInt(type.match(/\((.*)\)/)[1].split(',')[1]) - parseInt(type.match(/\((.*)\)/)[1].split(',')[0])) + parseInt(type.match(/\((.*)\)/)[1].split(',')[0])).toFixed(0);
                    }
                }
                return random;
            }
            return  parsePosition(type);
        }
        /**
         *
         * @param type
         * @returns {*}
         */
        function parsePosition(type){

            if(type == null){
                return "";
            }
            if(typeof type !== 'undefined'){
                if (String(type).match(/lw/)){
                    return lsWrapper.outerWidth() * (parseInt(type) / 100);
                }
                if (String(type).match(/lh/)){
                    return lsWrapper * (parseInt(type) / 100);
                }
                if (String(type).match(/sw/)){
                    return lsSlide.outerWidth() * (parseInt(type) / 100);
                }
                if (String(type).match(/sh/)){
                    return lsSlide.outerHeight() * (parseInt(type) / 100);
                }
                if (String(type).match(/random/)){
                    return (Math.random() * (parseInt(type.match(/\((.*)\)/)[1].split(',')[1]) - parseInt(type.match(/\((.*)\)/)[1].split(',')[0])) + parseInt(type.match(/\((.*)\)/)[1].split(',')[0])).toFixed(0);
                }
                switch (type){
                    case 'left':
                        return -( (lsWrapper.outerWidth() + lsWrapper.position().left ));
                    case 'right':
                        return ( lsSlide.width() - layerElement.position().left  );
                    case 'top':
                        return -(lsWrapper.outerHeight() + layerElement.position().top);
                    case 'bottom':
                        return (lsSlide.height() - layerElement.position().top);
                    default:
                        return type;
                }
            }
        }

        function mergeDefaults(data, defaults){
            var tmpArray = [];
            $.each(defaults, function(k, v){
                if(typeof data[k] == 'undefined'){
                    data[k] = v;
                }
            });
            for(var key in data){
                if(data.hasOwnProperty(key)){
                    tmpArray[key] = parseTiming(data[key], data);
                }
            }
            return tmpArray;
        }


        /**
         *
         * @param time
         * @param data
         * @returns {*}
         */
        function parseTiming(time, data){
            var plus, minus, timestring, timecopy, textsplitelements;

            plus = 0;
            minus = 0;
            timestring = '';
            timecopy = time;
            timecopy = $.trim(timecopy);

            if(timecopy.indexOf('+') > 1){
                plus = timecopy.match(/(\d*[0-9])/)[1] > 0 ? parseInt(timecopy.match(/(\d*[0-9])/)[1]) : 0;
            }
            if(timecopy.indexOf('-') > 1){
                minus = timecopy.match(/(\d*[0-9])/)[1] > 0 ? parseInt(timecopy.match(/(\d*[0-9])/)[1]) : 0;
            }
            if(timecopy.match(/(\w*[a-zA-Z])/) !== null){
                timestring = timecopy.match(/(\w*[a-zA-Z])/)[1];
            } else {
                timestring = timecopy;
            }
            switch (timestring){
                case 'slidechangeonly':
                    return parseTiming(slideData.duration, data) + plus - minus;
                    break;

                case 'transitioninstart':
                    return parseTiming(data.startatin, data) + plus - minus;
                    break;

                case 'transitioninend':
                    return parseTiming(data.startatin, data) + parseInt(data.durationin) + plus - minus;
                    break;

                case 'textinstart':
                    return parseInt(data.textstartatin)  + plus - minus;
                    break;

                case 'textinend':
                    return getTextinEnd() + plus - minus;
                    break;

                case 'allinend':
                    return Math.max(getTransitioninEnd(), getTextinEnd()) + plus - minus;
                    break;

                case 'loopstart':
                    return parseTiming(data.loopstartat, data) + plus - minus;
                    break;

                case 'loopend':
                    return getLoopend() + plus - minus;
                    break;

                case 'transitioninandloopend':
                    return Math.max(getTransitioninEnd(), getLoopend()) + plus - minus;
                    break;

                case 'textinandloopend':
                    return Math.max(getTextinEnd(), getLoopend()) + plus - minus;
                    break;

                case 'allinandloopend':
                    return Math.max(getTransitioninEnd(), getTextinEnd(), getLoopend()) + plus - minus;
                    break;

                case 'textoutstart':
                    return parseTiming(data.textstartatout, data) + plus - minus;
                    break;

                case 'textoutend':
                    return getTextoutEnd() + plus - minus;
                    break;

                case 'textoutandloopend':
                    return Math.max(getLoopend(), getTextoutEnd()) + plus - minus;
                    break;

                default:
                    return time;
            }

            /**
             *
             * @returns {*}
             */
            function getTransitioninEnd(){
                return parseTiming(data.startatin, data) + data.durationin;
            }

            /**
             *
             * @returns {*}
             */
            function getTextinEnd(){
                if(data.texttransitionin){
                    textsplitelements = doSplitText(data.texttypein);
                    return (parseTiming(data.textstartatin, data) + data.textdurationin +((textsplitelements.length) * data.textshiftin));
                }
                return 0;
            }

            /**
             *
             * @returns {*}
             */
            function getTextoutEnd(){
                if(data.texttransitionout){
                    textsplitelements = doSplitText(data.texttypeout);
                    return (parseTiming(data.textstartatout, data) + data.textdurationout +((textsplitelements.length) * data.textshiftout));
                }
                return 0;
            }

            /**
             *
             * @returns {number}
             */
            function getLoopend(){

                var loopcount, looprepeatdelay = 0, repeat, loopyoyo = 1, time = 0;

                if(data.loopyoyo){
                    loopyoyo = 2;
                }
                if(data.loopcount === -1){
                    layershasinfiniteloop = true;
                    repeat = data.loopcount;
                }
                if(data.loopcount === 0){
                    repeat = 0;
                }
                if(data.loopcount >= 1){
                    repeat = ((data.loopcount) * loopyoyo) - 1;
                }
                if(data.loop){
                    if(typeof repeat === 'undefined'){
                        return 0;
                    } else if(repeat === 0){
                        loopcount = 1;
                    } else if (repeat > 0){
                        loopcount = repeat + 1;
                    } else {
                        return slideData.duration;
                    }

                    if((data.loopyoyo === true) || (repeat >= 1 || (repeat === -1))){
                        looprepeatdelay = data.looprepeatdelay;
                    }
                    time = (((data.loopduration + looprepeatdelay) * loopcount) - looprepeatdelay) + parseTiming(data.loopstartat, data);
                }
                return time;
            }
        }

        return null;
    });

    if(timeline.totalDuration() < slideData.duration.toseconds()){
        timeline.from($('<div />'), slideData.duration.toseconds(), {}, 0).startTime(0);
    }

    instantiateControllButtons(timeline);
    createTimelineTimes();
    createSlider();

    /**
     *
     */
    function updateSlider() {
        timelineProgress = slideData.duration.toseconds() < this.totalDuration() ? (this.progress() * (this.totalDuration() / slideData.duration.toseconds())) : this.progress();
        if( (timelineProgress >= 1) && (layershasinfiniteloop === false)){
            this.pause();
            if(this.progress() < 1){
                this.progress( this.progress() / timelineProgress );
            }
        } else {
            if(timelineProgress == 0){
                layers.removeClass('layer-visible');
            }
            if( layershasinfiniteloop || (timelineProgress <= 1)){
                sliderHandle.slider('value', (timelineProgress * 100));
                timelineOverlay.width(sliderHandle.slider("value") +'%');
            }
            timerButton.html((this.time().toFixed(2)))
        }
    }

    /**
     *
     */
    function createSlider(){
        var sliderOptions = {
                value: 0,
                range: false,
                min: 0,
                max: 100,
                step: .1,
                slide: function (event, ui) {
                    var timelineProgress;
                    timeline.pause();
                    if(slideData.duration.toseconds() < timeline.totalDuration()){
                        timelineProgress = ((slideData.duration.toseconds() / timeline.totalDuration()) * ui.value) / 100;
                    } else {
                        timelineProgress = ui.value / 100;
                    }
                    timeline.progress(timelineProgress);
                    timerButton.html((timeline.time().toFixed(2)))
                }
            };
        sliderHandle.slider(sliderOptions);
    }

    /**
     *
     */
    function reset(){
        timerButton.html('0.00');
        timelineOverlay.width(0);
    }

    /**
     *
     * @param el
     * @returns {Array}
     */
    function extractDataLsData(el){
        var optionsArray = [];

        $.each(el.data('ls').split(';'), function (i, e) {

            var valueArray = $.trim(e).split(':');
            if(valueArray[0] != ''){
                if($.trim(valueArray[1]).length == 0){
                    optionsArray[$.trim(valueArray[0])] = null;
                } else if(valueArray[1] == "true"){
                    optionsArray[$.trim(valueArray[0])] = true;
                } else if(valueArray[1] == 'false'){
                    optionsArray[$.trim(valueArray[0])] = false;
                } else if(isNumeric(valueArray[1])){
                    optionsArray[$.trim(valueArray[0])] = parseFloat(valueArray[1]);
                } else {
                    optionsArray[$.trim(valueArray[0])] = $.trim(valueArray[1]);
                }
            }
        });
        return optionsArray;
        function isNumeric(num){
            return !isNaN(num);
        }
    }

    /**
     *
     */
    function instantiateControllButtons(){
        $("#play-"+slideUid).off().on('click', function () {
            timeline.play();
        });
        $("#pause-"+slideUid).off().on('click', function () {
            timeline.pause();
        });
        $("#reverse-"+slideUid).off().on('click', function () {
            timeline.reverse();
        });
        $("#resume-"+slideUid).off().on('click', function () {
            timeline.resume();
        });
        $("#stagger-"+slideUid).off().on('click', function () {
            timeline.play("stagger");
        });
        $("#restart-"+slideUid).off().on('click', function () {
            timeline.progress(0).play();
        });
        $("#recreate-"+slideUid).off().on('click', function () {
            timeline.pause().progress(0).kill();
            createTimelineInstance($(this).data('slider'), $(this).data('slide'));
        });
    }

    /**
     *
     */
    function createTimelineTimes(){
        var sliderTimesElement = $('#time-line-slide-' + slideUid + ' #sliderWrapper .slider-times');
        sliderTimesElement.html("");
        for(var i = 0; i <= slideData.duration.toseconds(); i++){
            sliderTimesElement.append ( $("<div />").html( i + 's' ).css('left', (( i / slideData.duration.toseconds() ) * 100 ) + "%") );
        }
    }
}

Array.prototype.toArray = function () {
    return this;
};
Number.prototype.toArray = function () {
    return [parseInt(this)];
};
String.prototype.toArray = function () {
    return [parseInt(this)];
};

Number.prototype.toseconds = function () {
    return parseFloat(this / 1000);
};

String.prototype.toseconds = function () {
    return parseFloat(this / 1000);
};