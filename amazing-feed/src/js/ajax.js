var ajaxgo = false;

jQuery(document).ready(function($) {

	var adminform_ajax = jQuery('.adminform_ajax');

	/**
	 * Ajax with button
	 */

	function req_go(data, form, options){
		if (ajaxgo){
			form.find('.response').html('<p class="error">Необходимо дождаться ответа от предыдущего запроса.</p>');
			return false;
		}

		form.find( 'input[type=submit]' ).prop( 'disabled', true ).val( 'Подождите..' );

		form.find( '.response' ).html('');
		ajaxgo = true;


		if( form.find( 'input[type=submit]' ).hasClass('js-remove-all-posts') ) {
			$( '.js-remove-all-posts-progress-bar span' ).css( 'width', '0' );
			$( '.js-remove-all-posts-progress-bar' ).fadeIn('slow');
			check_progress();
		}
	}

	function req_come(data, statusText, xhr, form){
		form.find('input').removeClass('is-invalid');

		if( form.find( 'input[type=submit]' ).hasClass('js-remove-all-posts') ) {
			$( '.js-remove-all-posts-progress-bar' ).fadeOut('slow');
		}

		if( data.success ) {
			var response = '<p class="alert alert-success">'+data.data.message+'</p>';
			form.find('.response').html(response);

			form.find('input[type=submit]').prop('disabled', true).val('Готово');
		}
		else {
			if( data.data.message ) {
				var response = '<p class="alert alert-danger">'+data.data.message+'</p>';
				form.find('.response').html(response);
			}

			form.find('input[type=submit]').prop('disabled', false).val('Попробовать снова');
		}
		
		if ( data.data.redirect ) window.location.href = data.data.redirect;
		ajaxgo = false;
	}

	var args = {
		dataType: 'json',
		beforeSubmit: req_go,
		success: req_come,
		error: function( data ) { console.log( arguments ); },
		url: ajax_var
	};

	adminform_ajax.ajaxForm(args);




	/**
	 * Check AJAX progress
	 */
	function check_progress() {
		var check_progress = setInterval( function() {

			$.ajax({
				type: 'POST',
				url: ajax_var,
				dataType: 'json',
				data: 'action=check_progress',
				
				success: function( data ) {
					if( data.success ) {
						if( data.data.check_progress ) {
							$( '.js-remove-all-posts-progress-bar span' ).css( 'width', data.data.check_progress+'%' );
						}

						if( data.data.next_cron_time ) {
							$( '.js-next-cron-time' ).text( data.data.next_cron_time );
						}


						if( data.data.cron_func_run > 0 && data.data.cron_func_run < 100 ) {
							$( '.js-cron-status span' ).removeClass().addClass('is-active').text( 'Функция запущена' );
							$( '.js-cron' ).prop( 'disabled', true );
							$( '.js-remove-all-posts' ).prop( 'disabled', true );
						}
						else{
							$( '.js-cron-status span' ).removeClass().addClass('is-not-active').text( 'Функция не запущена' );
							$( '.js-cron' ).prop( 'disabled', false );
							$( '.js-remove-all-posts' ).prop( 'disabled', false );
						}

						if( data.data.published_posts ) {
							$( '.js-count-posts' ).text( data.data.published_posts );
						}						
					}
				},
			});

		}, 1000);
	}


	if( $( '#cron-table' ).length ) {
		check_progress();
	}

});