<div class="wrap">
	<header class="af-header">
		<h2>Укажите ссылку на фид и название ЖК</h2>
	</header>

	<?
		$output = get_option( 'amazing_feed_settings' );

		// AF\Api\SettingsApiPlugin::vardump( $output );
	?>

	<form action="" method="post" class="form adminform_ajax">
		<table class="form-table" role="presentation">
			<tbody>
				<tr class="form-group">
					<th scope="row">
						<div class="form__th">
							<label>Ссылка на фид</label>
						</div>
					</th>
					<td>
						<input type="text" name="parse_link" value="<?= ( isset( $output['parse_link'] ) ) ? $output['parse_link'] : ''?>" class="regular-text js-inspect-url">
						<small></small>
					</td>
				</tr>

				<tr class="form-group">
					<th scope="row">
						<div class="form__th">
							<label>Название ЖК</label>
						</div>
					</th>
					<td>
						<input type="text" name="complex_name" value="<?= ( isset( $output['complex_name'] ) ) ? $output['complex_name'] : ''?>" class="regular-text js-inspect-text">
						<small></small>
					</td>
				</tr>

				<tr class="form-group">
					<th scope="row"></th>
					<td>
						<input type="submit" value="Сохранить" class="form__btn">

						<input type="hidden" name="redirect_to" value="<?= $_SERVER['REQUEST_URI']; ?>">
						<input type="hidden" name="action" value="edit_settings">
						<input type="hidden" name="nonce" value="<?= wp_create_nonce('edit_settings_nonce'); ?>">
					</td>
				</tr>
			</tbody>
		</table>

		<div class="response"></div>
	</form>


	<?
		if( ! ini_get( 'allow_url_fopen' ) ) {
			die( '<div class="allow_url_fopen_disabled">Параметр allow_url_fopen выключен в php.ini. Дальнейшая работа невозможна. <br><small>Пропишите в настройках php.ini allow_url_fopen=On</small></div>' );
		}
	?>


	<? if( isset( $output[ 'parse_link' ] ) && ! empty( $output[ 'parse_link' ] ) && isset( $output[ 'complex_name' ] ) && ! empty( $output[ 'complex_name' ] ) ) { ?>
		<header class="af-header mt-3">
			<h2>Укажите произвольные поля для записей</h2>
		</header>

		<div class="container mt-3">
			<div class="row">
				<div class="col-lg-7 col-xs-12">
					<form action="" method="post" class="form adminform_ajax">
						<? if( ! isset( $output[ 'settings_for_import_array' ] ) ) { ?>
							<div class="row">
								<div class="col-xs">
									<input type="text" name="custom_name[]" value="internal-id" class="w-100" placeholder="Field name">
									<small></small>
								</div>

								<div class="col-xs">
									<input type="text" name="custom_value[]" value="@internal-id" class="w-100" placeholder="Field value">
									<small></small>
								</div>

								<div class="col-xs-1"></div>
							</div>
						<? } else { ?>

							<?
								$count = 0;
								foreach ($output[ 'settings_for_import_array' ] as $key => $value) {
							?>
								<div class="row mt-2">
									<div class="col-xs">
										<input type="text" name="custom_name[]" value="<?= sanitize_text_field( $key ) ?>" class="w-100 js-inspect-text" placeholder="Field name">
										<small></small>
									</div>

									<div class="col-xs">
										<input type="text" name="custom_value[]" value="<?= sanitize_text_field( str_replace( '//offer', '', $value) ) ?>" class="w-100 drop-input js-inspect-text" placeholder="Field value">
										<small></small>
									</div>

									<div class="col-xs-1">
										<? if( $count > 0 ) { ?>
											<a href="#" class="js-remove-field">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M296 432h16a8 8 0 0 0 8-8V152a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v272a8 8 0 0 0 8 8zm-160 0h16a8 8 0 0 0 8-8V152a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v272a8 8 0 0 0 8 8zM440 64H336l-33.6-44.8A48 48 0 0 0 264 0h-80a48 48 0 0 0-38.4 19.2L112 64H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h24v368a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V96h24a8 8 0 0 0 8-8V72a8 8 0 0 0-8-8zM171.2 38.4A16.1 16.1 0 0 1 184 32h80a16.1 16.1 0 0 1 12.8 6.4L296 64H152zM384 464a16 16 0 0 1-16 16H80a16 16 0 0 1-16-16V96h320zm-168-32h16a8 8 0 0 0 8-8V152a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v272a8 8 0 0 0 8 8z"/></svg>
											</a>
										<? } ?>
									</div>
								</div>

								<? $count++; ?>
							<? } ?>

						<? } ?>

						<a href="#" class="js-add-new-field mt-3 mb-3">Добавить поле</a>

						<input type="submit" value="Сохранить настройки" class="form__btn mb-3">

						<input type="hidden" name="redirect_to" value="<?= $_SERVER['REQUEST_URI']; ?>">
						<input type="hidden" name="action" value="edit_settings">
						<input type="hidden" name="nonce" value="<?= wp_create_nonce('edit_settings_nonce'); ?>">
						<div class="response"></div>
				</div>

				<div class="col-lg-5 col-xs-12">
					<?
						$xml_php_api_pligun = new AF\Api\XmlPhpApiPlugin;
						if( $xml_php_api_pligun->checkXml() && $xml_php_api_pligun->checkOffers() ) {
					?>
						<div class="row">
							<div class="col-xs-2">
								<div class="swiper-prev">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path d="M285.59 410.4a23.93 23.93 0 0 1 0 33.84l-22.7 22.65a24 24 0 0 1-33.94 0l-154.31-154L131.42 256z" class="fa-secondary"/><path d="M262.85 45.06l22.7 22.65a23.93 23.93 0 0 1 0 33.84L74.58 312.9l-40-40a23.94 23.94 0 0 1 0-33.84l194.33-194a24 24 0 0 1 33.94 0z" class="fa-primary"/></svg>
								</div>
							</div>

							<div class="col-xs-8 swiper-number-slides">
								<input type="text" name="" value="1" id="js-current-slide"> из <span id="js-total-slides"></span>
							</div>

							<div class="col-xs-2">
								<div class="swiper-next text-right">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path d="M188.74 256l56.78 56.89L91.21 466.9a24 24 0 0 1-33.94 0l-22.7-22.65a23.93 23.93 0 0 1 0-33.84z" class="fa-secondary"/><path d="M91.25 45.06l194.33 194a23.93 23.93 0 0 1 0 33.84l-40 40-211-211.34a23.92 23.92 0 0 1 0-33.84l22.7-22.65a24 24 0 0 1 33.97-.01z" class="fa-primary"/></svg>
								</div>
							</div>
						</div>

						<div class="swiper-container">
							<div class="swiper-wrapper">
								<? $xml_php_api_pligun->showXml(); ?>
							</div>
						</div>

					<? } else { ?>
						<div class="alert alert-danger mt-2">Не удалось получить данные по выбранным параметрам</div>
					<? } ?>
				</div>

			</div>
		</div>
	<? } ?>

</div>