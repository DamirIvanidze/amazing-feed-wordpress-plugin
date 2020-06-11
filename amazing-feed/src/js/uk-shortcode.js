jQuery(document).ready(function($) {
	var containerEl = $('.mixer');
	var mixer;

	var minSizeRangeInput = document.querySelector('[name="minSize"]');
	var maxSizeRangeInput = document.querySelector('[name="maxSize"]');

	if (containerEl.length) {

		containerEl.find('.mix:odd').addClass('js-stripped-color');

		mixer = mixitup( containerEl, {
			selectors: {
				control: '[data-mixitup-control]'
			},
			
			multifilter: {
				enable: true
			},
			
			pagination: {
				limit: 10
			},
			
			callbacks: {
				onMixFail: function(){
					$('.mixer__failmessage').show();
				},
				onMixStart: function(){
					containerEl.find('.mix').removeClass('js-stripped-color').removeClass('js-not-hide');
					$('.mixer__failmessage').hide();
				},
				onMixEnd: function(){
					containerEl.find(".mix").each(function(){
						if($(this).css('display') !== 'none'){
							$(this).addClass('js-not-hide');
						}
					});

					containerEl.find('.mix.js-not-hide:odd').addClass('js-stripped-color');
				},
			},
			templates: {
				pager: '<button type="button" class="${classNames}" data-page="${pageNumber}" data-mixitup-control>${pageNumber}</button>',
				pagerPrev: '<button type="button" class="${classNames}" data-page="prev" data-mixitup-control>&laquo;</button>',
				pagerNext: '<button type="button" class="${classNames}" data-page="next" data-mixitup-control>&raquo;</button>',

				pageStats: 'от ${startPageAt} до ${endPageAt} из ${totalTargets}',
				pageStatsSingle: '${startPageAt} из ${endPageAt}',
				pageStatsFail: 'Ничего не найдено'
			}
		});


		function getRange() {
			var min = Number(minSizeRangeInput.value);
			var max = Number(maxSizeRangeInput.value);

			return {
				min: min,
				max: max
			};
		}


		function handleRangeInputChange(){
			mixer.filter(mixer.getState().activeFilter);
		}


		function filterTestResult(testResult, target){
			var size = Number(target.dom.el.getAttribute('data-area'));
			var range = getRange();

			if (size <= range.min || size >= range.max) {
				testResult = false;
			}

			return testResult;
		}

		mixitup.Mixer.registerFilter('testResultEvaluateHideShow', 'range', filterTestResult);

		minSizeRangeInput.addEventListener('change', handleRangeInputChange);
		maxSizeRangeInput.addEventListener('change', handleRangeInputChange);
	}


	/**
	 * RANGE
	 */
	var $range = $('.js-range-slider');
	var $from = $('.js-from');
	var $to = $('.js-to');
	var min = 0;
	var max = $to.val();
	var range;
	var from;
	var to;
			
	$range.ionRangeSlider({
		type: "double",
		min: min,
		max: max,
		step: 5,
		prettify_enabled: false,
		onChange: function (data) {
			from = data.from;
			to = data.to;
			$from.prop("value", from);
			$to.prop("value", to);
			handleRangeInputChange(true, document.querySelector('.mixer'));
		}
	});

	var slider = $(".js-range-slider").data("ionRangeSlider");

	$('button[type=reset]').on('click', function(){
		minSizeRangeInput.value = 0;
		maxSizeRangeInput.value = max;

		slider.update({
			from: 0,
			to: max
		});
	});


	/**
	 * SORT
	 */
	$('.mixer__sort a').on( 'click', function(e) {
		e.preventDefault();

		$('.mixer__sort a').not( $(this) ).removeClass('active');
		
		$(this).toggleClass("active");
		var id = $(this).attr('id');

		$(this).attr('data-sort', function( index, attr ) {
			return attr == id+':desc' ? id+':asc' : id+':desc';
		});
	});


	/**
	 * TOOLTIP
	 */
	if ( $(window).width() > 960 ) {
		$('.js-tooltip-parent').mousemove(function(e) {
			var pos = $(this).offset();
			var elem_left = pos.left;
			var elem_top = pos.top;
			// положение курсора внутри элемента
			var Xinner = e.pageX - elem_left;
			var Yinner = e.pageY - elem_top;


			$('.js-mix-tooltip').show();
			$('.js-mix-tooltip').css({
				'left': Xinner + 'px',
				'top': Yinner + 'px',
			});
		});

		$('.js-tooltip-parent').mouseleave(function(){
			$('.js-mix-tooltip').hide();
			return false;
		});

		$('.js-tooltip-parent .mix__price').mousemove(function(e) {
			$('.js-mix-tooltip').hide();
			return false;
		});
	}




	/**
	 * MODAL
	 */

	var breakPoint = {
		s: 640,
		m: 960,
		l: 1200,
		xl: 1600
	};


	var $modal_selector = '#modal';
		$modal = UIkit.modal($modal_selector);

	UIkit.util.on($modal_selector, 'hidden', function () {
		$($modal_selector).find('img').attr('src', '');
	});

	$('.js-modal').on('click', function(e){
		if ( window.innerWidth < breakPoint.m ) {
			var current_row = $(e.target);

			if ( !current_row.hasClass('mix') )
				current_row = current_row.parents('.mix');

			if ( current_row.hasClass('mix__open') ) {
				current_row.removeClass('mix__open');
			} else {
				$('.mix__open').removeClass('mix__open');
				current_row.addClass('mix__open');
			}

		} else {
			if ( ! $(e.target).eq(0).hasClass('btn') ) {
				$('#modal .modal__data').empty();

				var meta_flat_number = $(this).data( 'flat_number' );
				if( meta_flat_number ) {
					$('<div class="uk-grid-small" uk-grid><div class="uk-width-expand" uk-leader>Квартира:</div><div class="rooms">' + meta_flat_number + '</div></div>').appendTo('#modal .modal__data');
				}

				var meta_data = $(this).data();

				delete meta_data['image'];
				delete meta_data['flat_number'];
				delete meta_data['filters_name'];
				
				// Transform JS object to an array
				var meta_array = $.map( meta_data, function( value, index ) {
					return [[value, index]]
				});

				meta_array.reverse();

				var filters_name = $(this).data( 'filters_name' ).split(';');

				$.each( meta_array, function( key, value ) {
					if( value[1] == 'rooms' && value[0] == 0 ) {
						filters_name[ key ] = 'Студия';
						value[0] = '';
					}
					else if( value[1] == 'area' ) {
						value[0] = value[0] + ' м<sup>2</sup></span>';
						filters_name[ key ] = filters_name[ key ] + ': ';
					}
					else if( value[1] == 'renovation' ) {
						switch ( value[0] ) {
							case 0:
							value[0] = 'без отделки';
							break;

							case 1:
							value[0] = 'черновая отделка';
							break;

							case 2:
							value[0] = 'c отделкой';
							break;
						}
						filters_name[ key ] = filters_name[ key ] + ': ';
					}
					else{
						filters_name[ key ] = filters_name[ key ] + ': ';
					}

					$('<div class="uk-grid-small" uk-grid><div class="uk-width-expand" uk-leader>' + filters_name[ key ] +'</div><div class="' + value[1] + '">' + value[0] + '</div></div>').appendTo('#modal .modal__data');

				});


				var meta_image = $(this).data( 'image' );
				if( meta_image ) {
					$('#modal .modal__svg svg').hide();
					$('#modal img.modal__plan').attr( 'src', meta_image ).show();
				}
				else {
					$('#modal img.modal__plan').hide();
					$('#modal .modal__svg svg').show();
				}

				$modal.show();
			}
		}
	});



	/**
	 * If the transition from the genplan
	 */
	if(window.location.pathname === '/flats/' && window.location.hash !== '') {
		var num = window.location.hash.substr(1);
		jQuery('html, body').animate({scrollTop: jQuery('.mixer').offset().top}, 800);
		mixer.filter('.building_section-'+num)
	}
});		