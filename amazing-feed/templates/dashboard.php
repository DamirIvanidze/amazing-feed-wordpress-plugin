<div class="wrap">
	<header class="af-header">
		<h2>Панель управления</h2>
	</header>

	<?
		$output = get_option( 'amazing_feed_settings' );

		// AF\Api\SettingsApiPlugin::vardump( $output );

		$count_posts = wp_count_posts();
		$published_posts = $count_posts->publish;

		if( isset( $output[ 'parse_link' ] ) && ! empty( $output[ 'parse_link' ] ) && isset( $output[ 'complex_name' ] ) && ! empty( $output[ 'complex_name' ] ) ) {
			if( isset( $output[ 'cron' ][ 'offers' ] ) && $output[ 'cron' ][ 'offers' ] == $published_posts ) {}
			else {
				$settings = new AF\Api\XmlPhpApiPlugin;
				$cron_offers = $settings->getCronOffersCount();

				$output['cron']['offers'] = $cron_offers;
				update_option( 'amazing_feed_settings', $output );
			}
		}


		if( isset( $output['cron']['offers'] ) && $output['cron']['offers'] > 200 && isset( $output['cron']['status'] ) && $output['cron']['status'] == 'activate' ) echo '<div class="alert alert-info"><strong>Обратите внимание!</strong> Записей больше 200, поэтому за каждую итерацию будет загружаться не больше 200 записей во избежание большой нагрузки на сервер.</div>';
	?>


	<div class="container">
		<div class="row text-center">
			<div class="col-lg-6">
				<? if( isset( $output[ 'parse_link' ] ) && ! empty( $output[ 'parse_link' ] ) && isset( $output[ 'complex_name' ] ) && ! empty( $output[ 'complex_name' ] ) ) { ?>
					<h3><?= isset( $output[ 'cron' ][ 'status' ] ) ? ( $output[ 'cron' ][ 'status' ] == 'activate' ? 'Cron запущен' : 'Запустить Cron' ) : 'Запустить Cron'; ?></h3>

					<form action="" method="post" class="form adminform_ajax">
						<input type="hidden" name="cron_status" value="<?= isset( $output[ 'cron' ][ 'status' ] ) ? ( $output[ 'cron' ][ 'status' ] == 'activate' ? 'deactivate' : 'activate' ) : 'activate'; ?>">

						<input type="submit" value="<?= isset( $output[ 'cron' ][ 'status' ] ) ? ( $output[ 'cron' ][ 'status' ] == 'activate' ? 'Деактивировать Cron' : 'Активировать Cron' ) : 'Активировать Cron'; ?>" class="form__btn js-cron">

						<input type="hidden" name="redirect_to" value="<?= $_SERVER['REQUEST_URI']; ?>">
						<input type="hidden" name="action" value="activate_deactivate_cron">
						<input type="hidden" name="nonce" value="<?= wp_create_nonce('activate_deactivate_cron_nonce'); ?>">
						<div class="response"></div>
					</form>
				<? } else { ?>
					<h3>Перед запуском Cron нужно установить настройки</h3>
					<a href="<?= home_url(); ?>/wp-admin/admin.php?page=amazing_feed_settings" class="form__btn js-cron">Настройки</a>
				<? } ?>
			</div>

			<div class="col-lg-6">

				<h3>Всего записей: <span class="js-count-posts"><?= $published_posts ?></span> <?= isset( $output[ 'cron' ][ 'offers' ] ) ? 'из ' . $output[ 'cron' ][ 'offers' ] : '' ?></h3>

				<form action="" method="post" class="form adminform_ajax">

					<input type="submit" value="Удалить все записи" class="form__btn js-remove-all-posts">

					<input type="hidden" name="redirect_to" value="<?= $_SERVER['REQUEST_URI']; ?>">
					<input type="hidden" name="action" value="remove_all_posts">
					<input type="hidden" name="nonce" value="<?= wp_create_nonce('remove_all_posts_nonce'); ?>">
					<div class="response"></div>
				</form>


				<div class="js-remove-all-posts-progress-bar">
					<span></span>
				</div>
			</div>
		</div>
	</div>


	<? if( isset( $output[ 'cron' ][ 'status' ] ) && $output[ 'cron' ][ 'status' ] == 'activate' ) { ?>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<table id="cron-table">
						<thead>
							<tr>
								<th>Время до следующего запуска</th>
								<th>Повтор</th>
								<th>Статус</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="js-next-cron-time"></td>
								<td>Каждые 2 часа</td>
								<td class="js-cron-status"><span></span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<? } ?>

</div>