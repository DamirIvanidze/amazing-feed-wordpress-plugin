<?
	$output = get_option( 'amazing_feed_settings' );

	$filters_result = array_combine( $filters, $filters_name );

	// AF\Api\SettingsApiPlugin::vardump( $filters_name );

	$args = array( 'posts_per_page' => -1 );

	$q = new WP_Query( $args );

	$filters_wp_query = [];
	$filters_wp_query_unique = [];

	if( $q->have_posts() ) {

		while( $q->have_posts() ) {
			$q->the_post();
			global $post;

			foreach ( $filters as $filter ) {
				$filters_wp_query[ $filter ][] = get_post_meta( $post->ID, $filter, true );
			}

	} } wp_reset_postdata();


	foreach ( $filters_wp_query as $key => $value ) {
		$filters_wp_query_unique[ $key ] = array_unique( $value );
	}


	if( $filters_wp_query_unique ) {
?>

	<div class="modal fade modal-shortcode-twbs" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

					<div class="row">
						<div class="col-lg-6 d-flex justify-content-center">
							<div class="align-self-center">
								<img data-src="" alt="" class="img-fluid lozad">
								<?= $no_pic; ?>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="if-need-background-color">
								<div class="modal-shortcode-twbs__descr"></div>

								<? if( $cf7 ) { ?>
									<div class="modal-shortcode-twbs__form">
										<p>Остались вопросы?</p>
										<p>Оставьте ваши данные, мы перезвоним через 30 секунд и бесплатно проконсультируем.</p>
										<?= do_shortcode( '[contact-form-7 id="' . $cf7 . '" title="Feedback"]' ); ?>
									</div>
								<?}?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>


	<section class="mixer">
		<form>
			<div class="container-fluid">
				<div class="row">
					<?
						foreach ( $filters_wp_query_unique as $key => $value ) {
							if( count( $filters_wp_query_unique ) >= 5 ) $filters_class = 'col-lg-4 col-md-4 col-sm-6 mb-3';
							else $filters_class = 'col';
					?>
						<div class="<?= $filters_class; ?>">
							<fieldset data-filter-group="" class="mixer__filters">
								<p><?= $filters_result[ $key ];?></p>

								<?
									sort($value);

									if( $key == 'floor') {
										echo '<select class="form-control">';
										echo '<option value="">Укажите этаж</option>';
										foreach ( $value as $k => $v ) {
											echo '<option value=".floor-'.$v.'">'.$v.'</option>';
										}
										echo '</select>';
									}
									else if( $key == 'renovation' ) {
										echo '<select class="form-control">';
											echo '<option value="">Выберите отделку</option>';
											foreach ( $value as $k => $v ) {
												switch ( $v ) {
													case 'c отделкой':
														$v_switch = 2;
														break;

													case 'без отделки':
														$v_switch = 0;
														break;

													case 'черновая отделка':
														$v_switch = 1;
														break;
												}

												echo '<option value=".renovation-'.$v_switch.'">'.$v.'</option>';
											}
										echo '</select>';
									}
									else if( $key == 'area') {
										$end = end( $value );

										echo '<div class="range-slider">';
											echo '<input type="text" class="js-range-slider" value="">';
										echo '</div>';

										echo '<div class="extra-controls">';
											echo '<input name="minSize" type="hidden" min="0" max="10" value="0" list="sizeLegend" class="inp js-from">';
											echo '<input name="maxSize" type="hidden" min="0" max="10" value="' . ceil( $end ) . '" list="sizeLegend" class="inp js-to">';
										echo '</div>';
									}
									else {
										if( $key == 'rooms' && in_array( 'studio', $output['settings_for_import_array'] ) ) {
											echo '<button type="button" class="btn btn-' . $main_color_scss . '" data-mixitup-control="" data-filter=".rooms-0">С</button> ';
										}

										foreach ($value as $k => $v) {
											echo '<button type="button" class="btn btn-' . $main_color_scss . '" data-mixitup-control="" data-filter=".' . $key . '-' . $v . '">' . $v . '</button> ';
										}
									}
								?>
							</fieldset>
						</div>
					<?}?>

					<div class="<?= $filters_class; ?>">
						<p><strong>Сбросить фильтры</strong></p>
						<button type="reset" class="btn btn-<?= $main_color_scss; ?>">Показать все</button>
					</div>
				</div>
			</div>
		</form>

		<div class="container-fluid">
			<div class="row mixer__sort align-items-center">
				<? foreach ( $filters_result as $key => $value ) { ?>
					<div class="col">
						<a href="#" class="caret" id="<?= $key; ?>" data-mixitup-control data-sort="<?= $key; ?>:desc"><?= $value; ?></a>
					</div>
				<?}?>

				<div class="col">
					<p>Цена</p>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="accordion" id="mixer_accordion">
						<?
							if( $q->have_posts() ) {
								while( $q->have_posts() ) {
									$q->the_post();
									global $post;

									$image = get_the_post_thumbnail_url();
									$image = ( $image !== $ignore_url ) ? $image : '';

									$flat_number = get_post_meta( $post->ID, 'flat_number', true );

									$filters_meta = [];

									foreach ( $filters as $filter ) {
										$filters_meta[ $filter ] = get_post_meta( $post->ID, $filter, true );
									}

									$mix_class = '';
									$mix_data = '';

									foreach ( $filters_meta as $key => $value ) {
										if( $key == 'renovation' ) {
											switch ( $value ) {
												case 'c отделкой':
													$value = 2;
													break;

												case 'без отделки':
													$value = 0;
													break;

												case 'черновая отделка':
													$value = 1;
													break;
											}
										}
										else if( $key == 'rooms' ) {
											$studio = get_post_meta( $post->ID, 'studio', true );
											if( $studio ) $value = 0;
										}

										$mix_class .= $key . '-' . ceil( $value ) .' ';
										$mix_data .= 'data-' . $key . '="' . $value . '"';
									}
						?>
							<div class="mix <?= $mix_class; ?>" <?= $mix_data;?>>
								<div class="mix__header">
									<a href="#" class="stretched-link collapse_link" data-toggle="collapse" data-target="#collapse_<?= $post->ID; ?>"></a>
									<a href="#" class="stretched-link js-modal-link" <?= $mix_data; ?> data-image="<?= $image; ?>" data-flat_number="<?= $flat_number ? $flat_number : ''; ?>" data-filters_name="<?= implode( ';', $filters_name )?>"></a>

									<div class="row align-items-center">
										<div class="col mix__image">
											<?= $image ? '<img data-src="' . $image . '" alt="" class="img-fluid lozad">' : $no_pic; ?>
										</div>

										<? foreach ( $filters_meta as $key => $value ) { ?>
											<div class="col mix__<?= $key; ?>">
												<?
													if( $key == 'area') echo $value . ' м<sup>2</sup>';
													else if( $key == 'rooms') {
														$studio = get_post_meta( $post->ID, 'studio', true );
														if( $studio ) echo "Студия";
														else echo '<span>Комнат: </span>' . $value;
													}
													else echo $value;
												?>
											</div>
										<?}?>

										<div class="col mix__price">
											<a href="#callbackwidget" class="stretched-link js-callbackwidget"></a>
											<button type="button" class="btn btn-<?= $main_color_scss; ?>">Узнать цену</button>
										</div>
									</div>
								</div>

								<div id="collapse_<?= $post->ID; ?>" class="collapse" data-parent="#mixer_accordion">
									<div class="mix__body">
										<div class="row align-items-center">
											<div class="col">
												<?
													$building_section = get_post_meta( $post->ID, 'building_section', true );
													echo $building_section ? 'Корпус: ' . $building_section : '';
												?>
											</div>

											<div class="col">
												<?
													$mortgage = do_shortcode( '[amazing-feed-variable variable="mortgage"]' );
													echo $mortgage ? '<div class="btn btn-' . $main_color_scss . '">Ипотека от ' . $mortgage . '&nbsp;%</div>' : '';
												?>
											</div>

											<div class="w-100 mb-3"></div>

											<div class="col">
												<?
													$floor = get_post_meta( $post->ID, 'floor', true );
													echo $floor ? 'Этаж: ' . $floor : '';
												?>
											</div>

											<div class="col">
												<?
													$renovation = get_post_meta( $post->ID, 'renovation', true );
													echo $renovation ? $renovation : '';
												?>
											</div>

											<div class="w-100 mb-3"></div>

											<div class="col">
												<?= $image ? '<img data-src="' . $image . '" alt="" class="img-fluid lozad">' : $no_pic; ?>
												<div class="position-relative">
													<a href="#callbackwidget" class="stretched-link btn btn-<?= $main_color_scss; ?>">Узнать цену</a>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
						<? } } wp_reset_postdata(); ?>

						<div class="js-mix-tooltip">Посмотреть планировку</div>
					</div>
				</div>

				<div class="col-lg-12">
					<div class="mixer__failmessage">Нет квартир с выбранными параметрами</div>
				</div>

				<div class="col-md-12">
					<div class="mixer__pagination">
						<div class="mixitup-page-list"></div>
						<div class="mixitup-page-stats mt-3"></div>
					</div>
				</div>

			</div>
		</div>
	</section>

<? } else { ?>
	<div class="alert alert-danger text-center">
		<strong>Записей не обнаружено!</strong>
	</div>
<?}?>