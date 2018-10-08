(function($) {

	window.lsTransitionWindowIsOpen = false;
	window.lsTransitionGalleryTimeout = null;

	window.lsStartTransitionPreview = function( el, options ){

		// Parse settings
		var settings = $.extend( true, {}, {
			width: 300,
			height: 150,
			delay: 400,
			imgPath: pluginPath+'Img/',
			skinPath: pluginPath+'skins/',
			transitionType: '2d',
			transitionObject: null,
			showCircleTimer: false,
			pauseOnHover: false,
			skin: 'noskin',
			slidedelay: 400,
			startInViewport: false,
		}, options );

		settings.slideTransition = {
			type: settings.transitionType,
			obj: settings.transitionObject
		};

		// Add slider HTML markup
		$('<div class="transitionpreview" style="width: '+settings.width+'px; height: '+settings.height+'px;"> \
				<div class="ls-slide" data-ls="slidedelay: '+settings.delay+';"> \
					<img src="'+settings.imgPath+'sample_slide_1.png" class="ls-bg"> \
				</div> \
				<div class="ls-slide" data-ls="slidedelay: '+settings.delay+';"> \
					<img src="'+settings.imgPath+'sample_slide_2.png" class="ls-bg"> \
				</div> \
			</div>').appendTo(el);



		// Initialize the slider
		$(el).find('.transitionpreview').layerSlider(settings);
	};

	window.lsShowTransition = function( el ) {

		var $el = $( el ),

		// Create popup
			popup = $('<div class="ls-popup"> \
			<div class="inner ls-transition-preview"></div> \
		</div>').prependTo('body'),

		// Get transition index
			index = parseInt( $el.data('key') ) - 1,

		// Get viewport dimensions
			v_w = $(window).width(),

		// Get element dimensions
			e_w = $el.width(),

		// Get element position
			e_l = $el.offset().left,
			e_t = $el.offset().top,

		// Get toolip dimensions
			t_w = popup.outerWidth(),
			t_h = popup.outerHeight();

		// Position tooltip
		popup.css({ top: e_t - t_h - 14, left: e_l - (t_w - e_w) / 2  });

		// Fix top
		if(popup.offset().top - $(window).scrollTop() < 20) { // !!! slide preview position fix
			popup.css('top', e_t + 26);
		}

		// Fix left
		if(popup.offset().left < 20) {
			popup.css('left', 20);
		}

		// Get transition class
		var trclass = $el.closest('tbody').data('tr-type'),
			trtype, trObj;

		// Built-in 3D
		if(trclass == '3d_transitions') {
			trtype = '3d';
			trObj = layerSliderTransitions['t'+trtype+''][index];

			// Built-in 2D
		} else if(trclass == '2d_transitions') {
			trtype = '2d';
			trObj = layerSliderTransitions['t'+trtype+''][index];

			// Custom 3D
		} else if(trclass == 'custom_3d_transitions') {
			trtype = '3d';
			trObj = layerSliderCustomTransitions['t'+trtype+''][index];

			// Custom 3D
		} else if(trclass == 'custom_2d_transitions') {
			trtype = '2d';
			trObj = layerSliderCustomTransitions['t'+trtype+''][index];
		}

		// Init transition
		lsStartTransitionPreview( popup.find('.inner'), {
			transitionType: trtype,
			transitionObject: trObj,
			imgPath: lsTrImgPath,
			skinsPath: pluginPath+'skins/',
			delay: 100
		});
	};


	window.lsHideTransition = function( $parent ) {

		if( ! $parent || ! $parent.length ) {
			$parent = $('.ls-popup');
		}

		// Stop transition
		var $target = $('.ls-transition-preview', $parent);
		if( $target.length ) {
			$target.find('.transitionpreview').layerSlider( 'destroy', true );
			$target.parent().remove();
		}
	};

})(jQuery);


var transitionGallery = {

	init : function() {

		var self =  this;

		// Add transition list
		self.appendTransitions(layerSliderTransitions['t2d'], $('#slide-transitions-2d tbody'));
		self.appendTransitions(layerSliderTransitions['t3d'], $('#slide-transitions-3d tbody'));

		// Prevent click events on transitions
		jQuery(document).on('click', '#ls-transition-gallery a', function(e) {
			e.preventDefault();
		});

		// Show transitions
		jQuery('.ls-transition-list').on('mouseenter', 'a', function() {
			lsShowTransition( this );
		});

		// Hide transitions
		jQuery('.ls-transition-list').on('mouseleave', 'a', function() {
			lsHideTransition( this );
		});
	},

	appendTransitions : function(transitions, target) {

		for(c = 0; c < transitions.length; c+=2) {

			// Append new table row
			var tr = jQuery('<tr>').appendTo(target).append('<td class="c light"></td><td></td><td class="c"></td><td></td>');
			// Append transition col 1 & 2
			tr.children().eq(0).text((c+1));
			tr.children().eq(1).append( jQuery('<a>', { 'href' : '#', 'onclick' : 'setTransition(this);', 'data-key' : (c+1), 'rel' : 'tr'+(c+1)+'', 'html' : '<i class="fa fa-check-square-o"></i> '+(c+1)+'. '+transitions[c]['name'] }))
			// tr.children().eq(1).append( jQuery('<a>', { 'href' : '#', 'html' : transitions[c]['name'], 'data-key' : (c+1) } ) )
			if(transitions.length > (c+1)) {
				tr.children().eq(2).text((c+2));
				// tr.children().eq(3).append( jQuery('<a>', { 'href' : '#', 'html' : transitions[(c+1)]['name'], 'data-key' : (c+2) } ) )
				tr.children().eq(3).append( jQuery('<a>', { 'href' : '#', 'onclick' : 'setTransition(this);', 'data-key' : (c+2), 'rel' : 'tr'+(c+2)+'', 'html' : '<i class="fa fa-check-square-o"></i> '+(c+2)+'. '+ transitions[(c+1)]['name'] }))
			}
		}
	}
};


// Init transition gallery
if( typeof layerSliderTransitions !== 'undefined' ){
	// window.lsTrImgPath = 'assets/img/';
	window.pluginPath = '/typo3conf/ext/layerslider/Resources/Public/';
	transitionGallery.init();
}

