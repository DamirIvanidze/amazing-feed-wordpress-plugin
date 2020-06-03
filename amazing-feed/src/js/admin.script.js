// @prepros-prepend ./form_check.js
// @prepros-prepend ./ajax.js

jQuery(document).ready(function($) {

	/**
	 * jQury UI Drag and Drop
	 */
	var droppable_options = {
		drop: function ( event, ui ) {
			$(this).val( ui.draggable[0].dataset.xpath );
		}
	}

	function add_new_field( el ) {
		el.before('<div class="row mt-2"><div class="col-xs"><input type="text" name="custom_name[]" value="" class="w-100 js-inspect-text" placeholder="Название поля"><small></small></div><div class="col-xs"><input type="text" name="custom_value[]" value="" class="w-100 drop-input js-inspect-text" placeholder="Значение поля"><small></small></div><div class="col-xs-1"><a href="#" class="js-remove-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M296 432h16a8 8 0 0 0 8-8V152a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v272a8 8 0 0 0 8 8zm-160 0h16a8 8 0 0 0 8-8V152a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v272a8 8 0 0 0 8 8zM440 64H336l-33.6-44.8A48 48 0 0 0 264 0h-80a48 48 0 0 0-38.4 19.2L112 64H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h24v368a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V96h24a8 8 0 0 0 8-8V72a8 8 0 0 0-8-8zM171.2 38.4A16.1 16.1 0 0 1 184 32h80a16.1 16.1 0 0 1 12.8 6.4L296 64H152zM384 464a16 16 0 0 1-16 16H80a16 16 0 0 1-16-16V96h320zm-168-32h16a8 8 0 0 0 8-8V152a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v272a8 8 0 0 0 8 8z"/></svg></a></div></div>');

		$('.drop-input').droppable( droppable_options );
	}


	if( $('.xml__tagname').length || $('.drop-input').length) {
		$('.xml__tagname').draggable( {
			cursor: 'grabbing',
			helper:'clone',
			appendTo: 'body',
		});

		$('.drop-input').droppable( droppable_options );

		
		$('.js-add-new-field').click( function( e ) {
			e.preventDefault();

			add_new_field($(this));
		});


		$(document).on('click', 'a.js-remove-field', function(e) {
			e.preventDefault();

			$(this).parents('.row.mt-2').remove();
		});
	}



	/**
	 * Swiper Slider
	 */
	if( $('.swiper-container').length ) {
		var swiper = new Swiper('.swiper-container', {
			allowTouchMove: false,
			
			navigation: {
				nextEl: '.swiper-next',
				prevEl: '.swiper-prev',
			},
			
			keyboard: {
			 	enabled: true,
			 	onlyInViewport: true,
			},
			
			runCallbacksOnInit: true,

			on: {
				slideChange: function () {
					$('#js-current-slide').val( swiper.activeIndex +  1 );
				},
			},
			
		});

		$('#js-total-slides').text( swiper.slides.length );

		$('#js-current-slide').on('change', function(event) {
			event.preventDefault();
			
			swiper.slideTo( $(this).val() - 1 );
		});
	}


	
	/**
	 * jQury UI Sort in Shortcode Generation
	 */
    $('.js-sortable').sortable({
        start: function ( event, ui ) {
            $(this).data("elPos", ui.item.index());
        },
        update: function (event, ui) {
            var origPos = $(this).data("elPos");
            $('.js-sortable').not($(this)).each(function (i, e) {
                if (origPos > ui.item.index()) {
                    $(this).children("li:eq(" + origPos + ")").insertBefore($(this).children("li:eq(" + ui.item.index() + ")"));
                } else {
                    $(this).children("li:eq(" + origPos + ")").insertAfter($(this).children("li:eq(" + ui.item.index() + ")"));
                }
            })
        }
    }).disableSelection();

    $('.js-sortable input').each( function( index, el ) {
		$(this).keyup( function() {
			$(this).parent().attr( 'data-name', $(this).val() );
		});
	});




    /**
	 * Copy shortcode to buffer
	 */
	$('.js-copy-to-buffer').click(function(e) {
		e.preventDefault();
		var target = $(this).data('target');
		copytext(target);

		if( $(this).find('span').length ) $(this).find('span').removeClass('dashicons-admin-page').addClass('dashicons-yes');
		else $(this).text('Скопировано');
	});


	function copytext( el ) {
		var $tmp = $("<input>");
		$("body").append($tmp);
		$tmp.val( $(el).text() ).select();
		document.execCommand("copy");
		$tmp.remove();
	}
	
});