<div class="wrap">
	<header class="af-header">
		<h2>Ход строительства</h2>
	</header>

	<?
		$output = get_option( 'amazing_feed_settings' );

		// AF\Api\SettingsApiPlugin::vardump( $output );

		$site_parse_page = isset( $output[ 'building' ][ 'site_parse_page' ] ) ? $output[ 'building' ][ 'site_parse_page' ] : '';
		$id_for_find = isset( $output[ 'building' ][ 'id_for_find' ] ) ? $output[ 'building' ][ 'id_for_find' ] : '';
		$link_class_for_find = isset( $output[ 'building' ][ 'link_class_for_find' ] ) ? $output[ 'building' ][ 'link_class_for_find' ] : '';
		$title_class_for_find = isset( $output[ 'building' ][ 'title_class_for_find' ] ) ? $output[ 'building' ][ 'title_class_for_find' ] : '';
		$block_image_class = isset( $output[ 'building' ][ 'block_image_class' ] ) ? $output[ 'building' ][ 'block_image_class' ] : '';
		$image_attr = isset( $output[ 'building' ][ 'image_attr' ] ) ? $output[ 'building' ][ 'image_attr' ] : '';
		$utf8_decode = isset( $output[ 'building' ][ 'utf8_decode' ] ) ? ( empty( $output[ 'building' ][ 'utf8_decode' ] ) ? '' : 'checked' ) : '';
		$no_image = isset( $output[ 'building' ][ 'no_image' ] ) ? ( empty( $output[ 'building' ][ 'no_image' ] ) ? '' : 'checked' ) : '';
	?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<form action="" method="post" class="form adminform_ajax">
					<table class="form-table" role="presentation">
						<tbody>
							<tr class="form-group">
								<th scope="row">
									<div class="form__th">
										<label>Ссылка на ход строительства</label>
									</div>
								</th>
								<td>
									<input type="text" name="site_parse_page" value="<?= $site_parse_page; ?>" class="regular-text js-inspect-url">
									<small></small>
								</td>
							</tr>

							<tr class="form-group">
								<th scope="row">
									<div class="form__th">
										<label>ID блока с галереями</label>
									</div>
								</th>
								<td>
									<input type="text" name="id_for_find" value="<?= $id_for_find; ?>" class="regular-text js-inspect-text">
									<small></small>
								</td>
							</tr>

							<tr class="form-group">
								<th scope="row">
									<div class="form__th">
										<label>Класс ссылки</label>
									</div>
								</th>
								<td>
									<input type="text" name="link_class_for_find" value="<?= $link_class_for_find; ?>" class="regular-text js-inspect-text">
									<small></small>
								</td>
							</tr>

							<tr class="form-group">
								<th scope="row">
									<div class="form__th">
										<label>Класс заголовка</label>
									</div>
								</th>
								<td>
									<input type="text" name="title_class_for_find" value="<?= $title_class_for_find; ?>" class="regular-text js-inspect-text">
									<small></small>
								</td>
							</tr>

							<tr class="form-group">
								<th scope="row">
									<div class="form__th">
										<label>Класс блока с картинкой</label>
									</div>
								</th>
								<td>
									<input type="text" name="block_image_class" value="<?= $block_image_class; ?>" class="regular-text js-inspect-text">
									<small></small>
								</td>
							</tr>

							<tr class="form-group">
								<th scope="row">
									<div class="form__th">
										<label>Аттрибут картинки</label>
									</div>
								</th>
								<td>
									<input type="text" name="image_attr" value="<?= $image_attr; ?>" class="regular-text js-inspect-text">
									<small></small>
								</td>
							</tr>

							<tr class="form-group">
								<th scope="row">
									<div class="form__th">
										<label>Если кривое название, поставьте галочку</label>
									</div>
								</th>
								<td>
									<label for="utf8_decode">
										<input name="utf8_decode" type="checkbox" id="utf8_decode" value="1" <?= $utf8_decode; ?>>
										Починить название
									</label>
								</td>
							</tr>

							<tr class="form-group">
								<th scope="row">
									<div class="form__th">
										<label>Если нет картинки, поставьте галочку</label>
									</div>
								</th>
								<td>
									<label for="no_image">
										<input name="no_image" type="checkbox" id="no_image" value="1" <?= $no_image; ?>>
										Починить картинку
									</label>
								</td>
							</tr>

							<tr class="form-group">
								<th scope="row"></th>
								<td>
									<input type="submit" value="Сохранить" class="form__btn">

									<input type="hidden" name="redirect_to" value="<?= $_SERVER['REQUEST_URI']; ?>">
									<input type="hidden" name="action" value="edit_settings_building">
									<input type="hidden" name="nonce" value="<?= wp_create_nonce('edit_settings_building_nonce'); ?>">
								</td>
							</tr>
						</tbody>
					</table>

					<div class="response"></div>
				</form>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?
					if( $site_parse_page ) {
						$building = new AF\Base\BuildingPlugin;
						$images_from_url = $building->getImagesFromUrl( $output[ 'building' ] );

						echo '<p><strong>Название галереи</strong> - ' . $images_from_url[0][1] . '</p>';
						echo '<p>Пример картинки</p>';
						echo '<img src="' . $images_from_url[0]['images'][0] . '" alt="" style="max-width: 300px;">';


						echo '<p><code>[amazing-feed-building]</code></p>';
					}
				?>
			</div>
		</div>
	</div>
</div>