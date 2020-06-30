<div class="wrap">
	<header class="af-header">
		<h2>Shortcodes</h2>
	</header>

	<?
		$output = get_option( 'amazing_feed_settings' );

		// AF\Api\SettingsApiPlugin::vardump( $output );

		if( isset( $output[ 'settings_for_import_array' ] ) && $output[ 'settings_for_import_array' ] ) {
			$settings_for_import_array = $output[ 'settings_for_import_array' ];

			unset( $settings_for_import_array[ 'internal-id' ] );
			unset( $settings_for_import_array[ 'image' ] );
			unset( $settings_for_import_array[ 'studio' ] );
			unset( $settings_for_import_array[ 'flat_number' ] );

			$filters = isset( $output[ 'shortcode' ][ 'filters' ] ) ? explode( ';', $output[ 'shortcode' ][ 'filters' ] ) : '';
			$filters_name = isset( $output[ 'shortcode' ][ 'filters_name' ] ) ? explode( ';', $output[ 'shortcode' ][ 'filters_name' ] ) : '';
			$main_color_scss = isset( $output[ 'shortcode' ][ 'main_color_scss' ] ) ? $output[ 'shortcode' ][ 'main_color_scss' ] : '';
			$main_color_hex = isset( $output[ 'shortcode' ][ 'main_color_hex' ] ) ? $output[ 'shortcode' ][ 'main_color_hex' ] : '';
			$active_color_hex = isset( $output[ 'shortcode' ][ 'active_color_hex' ] ) ? $output[ 'shortcode' ][ 'active_color_hex' ] : '';
			$ignore_url = isset( $output[ 'shortcode' ][ 'ignore_url' ] ) ? $output[ 'shortcode' ][ 'ignore_url' ] : '';
			$cf7 = isset( $output[ 'shortcode' ][ 'cf7' ] ) ? $output[ 'shortcode' ][ 'cf7' ] : '';
	?>

		<form action="" method="post" class="form adminform_ajax mt-2">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<h3>Пожалуйста, укажите порядок фильтров</h3>

						<div class="row">
							<div class="col-lg-6">
								<ul class="js-sortable js-sortable-filtres">
									<?
										if( $filters ){
											foreach ( $filters as $filter ) {
												echo '<li data-name="' . $filter . '">';
												echo '<input type="text" name="" value="' . $filter . '" disabled>';
												echo '</li>';
											}

											if( count( $filters ) !== count( $settings_for_import_array ) ) {
												$compare = [];
												foreach ( $settings_for_import_array as $key => $value ) {
													$compare[] = $key;
												}

												$result_compare = array_diff( $compare, $filters );

												foreach ( $result_compare as $result ) {
													echo '<li data-name="' . $result . '">';
													echo '<input type="text" name="" value="' . $result . '" disabled>';
													echo '</li>';
												}

											}
										}
										else {
											foreach ( $settings_for_import_array as $key => $value ) {
												echo '<li data-name="' . $key . '">';
												echo '<input type="text" name="" value="' . $value . '" disabled>';
												echo '</li>';
											}
										}
									?>
								</ul>
							</div>

							<div class="col-lg-6">
								<ul class="js-sortable js-sortable-filtres-name">
									<?
										if( $filters_name ){
											foreach ( $filters_name as $filter_name ) {
												echo '<li data-name="' . $filter_name . '">';
												echo '<input type="text" name="" value="' . $filter_name . '" class="js-inspect-text">';
												echo '</li>';
											}

											if( count( $filters_name ) !== count( $settings_for_import_array ) ) {
												echo '<li data-name="">';
												echo '<input type="text" name="" value="" class="js-inspect-text">';
												echo '</li>';
											}
										}
										else {
											for ( $i=0; $i < count( $settings_for_import_array ); $i++ ) {
												echo '<li data-name="">';
												echo '<input type="text" name="" value="" class="js-inspect-text">';
												echo '</li>';
											}
										}
									?>
								</ul>
							</div>
						</div>


						<div class="row mb-2">
							<div class="col-lg-4">
								<p>Основной цвет в виде scss-переменной, например brown_mod</p>
								<input type="text" name="main_color_scss" value="<?= $main_color_scss; ?>" class="regular-text js-inspect-text" placeholder="">
								<small></small>
							</div>

							<div class="col-lg-4">
								<p>Основной цвет в виде hex-переменной, например #B28864</p>
								<input type="text" name="main_color_hex" value="<?= $main_color_hex; ?>" class="regular-text js-inspect-text" placeholder="">
								<small></small>
							</div>

							<div class="col-lg-4">
								<p>Активный цвет в виде hex-переменной, например #1f1f1f</p>
								<input type="text" name="active_color_hex" value="<?= $active_color_hex; ?>" class="regular-text js-inspect-text" placeholder="">
								<small></small>
							</div>
						</div>

						<div class="row mb-2">
							<div class="col-lg-6">
								<p>Игнорировать изображение (Часть названия)</p>
								<input type="text" name="ignore_url" value="<?= $ignore_url; ?>" class="regular-text" placeholder="">
								<small></small>
							</div>

							<?
								$wpcf7_contact_form = get_posts( array(
									'post_type'     => 'wpcf7_contact_form',
									'numberposts'   => -1
								));

								if( $wpcf7_contact_form ) {
							?>
								<div class="col-lg-6">
									<p>Contact Form 7</p>
									<select name="cf7">
										<option value="">Выбрать форму</option>
										<?
											foreach ( $wpcf7_contact_form as $form ) {
												$selected = ( $cf7 == $form->ID ) ? 'selected' : '';
												echo '<option value="' . $form->ID . '" ' . $selected . '>' . $form->post_title . ' (' . $form->ID . ')</option>';
											}
										?>
									</select>
								</div>
							<?}?>
						</div>

					</div>

					<div class="col-lg-6">
						<? if( count( $settings_for_import_array ) == count( $filters ) && count( $settings_for_import_array ) == count( $filters_name ) && $main_color_scss && $main_color_hex && $active_color_hex ) { ?>
							<div class="mb-5">
								<h3>Ваш шорткод сгенерирован</h3>
								<button class="js-copy-to-buffer" data-target="#twbs-flats-template">Скопировать в буфер</button>
								<p><code id="twbs-flats-template">[twbs-flats-template filters="<?= implode( ';', $filters ); ?>" filters_name="<?= implode( ';', $filters_name ); ?>" main_color_scss="<?= $main_color_scss; ?>" main_color_hex="<?= $main_color_hex; ?>" active_color_hex="<?= $active_color_hex; ?>" ignore_url="<?= $ignore_url; ?>" cf7="<?= $cf7; ?>"]</code></p>
							</div>

							<div>
								<button class="js-copy-to-buffer" data-target="#uk-flats-template">Скопировать в буфер</button>
								<p><code id="uk-flats-template">[uk-flats-template filters="<?= implode( ';', $filters ); ?>" filters_name="<?= implode( ';', $filters_name ); ?>" main_color_scss="<?= $main_color_scss; ?>" main_color_hex="<?= $main_color_hex; ?>" active_color_hex="<?= $active_color_hex; ?>" ignore_url="<?= $ignore_url; ?>" cf7="<?= $cf7; ?>"]</code></p>
							</div>
						<?}?>
					</div>
				</div>
			</div>

			<input type="submit" value="Сгенерировать шорткод" class="form__btn js-generate-shortcode">

			<input type="hidden" name="redirect_to" value="<?= $_SERVER['REQUEST_URI']; ?>">
			<input type="hidden" name="action" value="generate_shortcode">
			<input type="hidden" name="nonce" value="<?= wp_create_nonce( 'generate_shortcode_nonce' ); ?>">
			<div class="response"></div>
		</form>

	<? } else { ?>
		<div class="text-center">
			<h3>Перед использованием шорткодов нужно установить настройки</h3>
			<a href="<?= home_url(); ?>/wp-admin/admin.php?page=amazing_feed_settings" class="form__btn js-cron">Настройки</a>
		</div>
	<? } ?>
</div>