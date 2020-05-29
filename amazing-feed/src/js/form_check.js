jQuery(document).ready(function($) {
	var adminform_ajax = jQuery('.adminform_ajax');

	adminform_ajax.each(function(){
		var form = $( this );
		var btn_submit = form.find('input[type="submit"]');

		var validate = {
			required: 'Поле обязательно для заполнения!',
			min: 'Количество символов должно быть не меньше 2!',
			url: 'Неверный формат. Ипользуйте http или https перед адресом сайта. Пример: http://google.com',
		}

		function isUrlValid(url){
			return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
		}

		function check_field(){
			form.find('.js-inspect-text').each( function() {
				if( $( this ).val() == '' ) {
					$( this ).removeClass( 'is-valid' );
					$( this ).addClass( 'is-invalid' );
					$( this ).siblings( 'small' ).text( validate.required );
				}
				else if(jQuery(this).val().length < 2){
					$( this ).removeClass( 'is-valid' );
					$( this ).addClass( 'is-invalid' );
					$( this ).siblings( 'small' ).text( validate.min );
				}
				else{
					$( this ).removeClass( 'is-invalid' );
					$( this ).addClass( 'is-valid' );
					$( this ).siblings( 'small' ).text( '' );
				}
			});

			form.find('.js-inspect-url').each(function(){
				var isUrlValid_result = isUrlValid( $( this ).val() );

				if($( this ).val() == ''){
					$( this ).removeClass( 'is-valid' );
					$( this ).addClass( 'is-invalid' );
					$( this ).siblings( 'small' ).text( validate.required );
				}
				else if(isUrlValid_result == false){
					$( this ).removeClass( 'is-valid' );
					$( this ).addClass( 'is-invalid' );
					$( this ).siblings( 'small' ).text( validate.url );
				}
				else{
					$( this ).removeClass( 'is-invalid' );
					$( this ).addClass( 'is-valid' );
					$( this ).siblings( 'small' ).text( '' );
				}
			});
		}


		btn_submit.click(function(){
			check_field();
			var sizeEmpty = form.find('.is-invalid').size();
			if(sizeEmpty !== 0){
				return false;
			}
		});
	});
	
});