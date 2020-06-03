<div class="wrap">
	<header class="af-header">
		<h2>Переменные</h2>
	</header>

	<?
		$output = get_option( 'amazing_feed_settings' );

		// AF\Api\SettingsApiPlugin::vardump( $output );

		$phone = isset( $output[ 'variables' ][ 'phone' ] ) ? $output[ 'variables' ][ 'phone' ] : '';
		$main_price = isset( $output[ 'variables' ][ 'main_price' ] ) ? $output[ 'variables' ][ 'main_price' ] : '';
		$finish_price = isset( $output[ 'variables' ][ 'finish_price' ] ) ? $output[ 'variables' ][ 'finish_price' ] : '';
		$mortgage = isset( $output[ 'variables' ][ 'mortgage' ] ) ? $output[ 'variables' ][ 'mortgage' ] : '';
	?>

	<form action="" method="post" class="form adminform_ajax">
		<table class="form-table" role="presentation">
			<tbody>
				<tr class="form-group">
					<th scope="row">
						<div class="form__th">
							<label>Телефон</label>
						</div>
					</th>
					<td>
						<input type="text" name="phone" value="<?= $phone; ?>" class="regular-text">
						<small></small>
					</td>
					<? if( $phone ) {?>
						<td>
							<p>
								<code id="amazing-feed-variable-phone">[amazing-feed-variable variable="phone"]</code>
								<button type="button" class="js-copy-to-buffer" data-target="#amazing-feed-variable-phone"><span class="dashicons dashicons-admin-page"></span></button>
							</p>
						</td>
					<?}?>
				</tr>

				<tr class="form-group">
					<th scope="row">
						<div class="form__th">
							<label>Цена на главной</label>
						</div>
					</th>
					<td>
						<input type="text" name="main_price" value="<?= $main_price; ?>" class="regular-text">
						<small></small>
					</td>
					<? if( $main_price ) {?>
						<td>
							<p>
								<code id="amazing-feed-variable-main_price">[amazing-feed-variable variable="main_price"]</code>
								<button type="button" class="js-copy-to-buffer" data-target="#amazing-feed-variable-main_price"><span class="dashicons dashicons-admin-page"></span></button>
							</p>
						</td>
					<?}?>
				</tr>

				<tr class="form-group">
					<th scope="row">
						<div class="form__th">
							<label>Цена на отделке</label>
						</div>
					</th>
					<td>
						<input type="text" name="finish_price" value="<?= $finish_price; ?>" class="regular-text">
						<small></small>
					</td>
					<? if( $finish_price ) {?>
						<td>
							<p>
								<code id="amazing-feed-variable-finish_price">[amazing-feed-variable variable="finish_price"]</code>
								<button type="button" class="js-copy-to-buffer" data-target="#amazing-feed-variable-finish_price"><span class="dashicons dashicons-admin-page"></span></button>
							</p>
						</td>
					<?}?>
				</tr>

				<tr class="form-group">
					<th scope="row">
						<div class="form__th">
							<label>Ипотека</label>
						</div>
					</th>
					<td>
						<input type="text" name="mortgage" value="<?= $mortgage; ?>" class="regular-text">
						<small></small>
					</td>
					<? if( $mortgage ) {?>
						<td>
							<p>
								<code id="amazing-feed-variable-mortgage">[amazing-feed-variable variable="mortgage"]</code>
								<button type="button" class="js-copy-to-buffer" data-target="#amazing-feed-variable-mortgage"><span class="dashicons dashicons-admin-page"></span></button>
							</p>
						</td>
					<?}?>
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
</div>