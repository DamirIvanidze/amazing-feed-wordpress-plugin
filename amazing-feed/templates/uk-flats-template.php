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

	<!-- Modal -->

	<div id="modal" class="modal uk-modal-container uk-container-large" uk-modal>
		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
			<button class="uk-modal-close-outside uk-close-large" type="button" uk-close></button>
			<div class="uk-flex-middle" uk-grid>
				<div class="uk-width-1-2@m">
					<img data-src="" alt="" class="modal__plan" uk-img>
					<div class="modal__svg">
						<?= $no_pic; ?>
					</div>
				</div>

				<div class="uk-width-1-2@m">
					<div class="modal__data"></div>
					<? if( $cf7 ) { ?>
						<div class="fos fos--dark fos--col uk-text-center">
							<h6 class="fos__subtitle">Оставьте номер телефона, мы перезвоним вам<br>через 30 секунд</h6>
							<?= do_shortcode( '[contact-form-7 id="' . $cf7 . '" title="Feedback"]' ); ?>
						</div>
					<?}?>
				</div>
			</div>
		</div>
	</div>

	<section class="flats mixer js-mixer">
		<div class="uk-padding-large uk-container">
			<div uk-grid>
				<div class="uk-width-1-1">
					<form class="mixer__filters uk-text-center uk-text-left@m">
						<div uk-grid>
							<? foreach ( $filters_wp_query_unique as $key => $value ) { ?>
								<div class="col uk-width-1-2@s uk-width-expand@m">
									<fieldset class="mixer__filters" data-filter-group="">
										<p><?= $filters_result[ $key ];?></p>

										<?
											sort($value);

											if( $key == 'floor') {
												echo '<select>';
												echo '<option value="">Укажите этаж</option>';
												foreach ( $value as $k => $v ) {
													echo '<option value=".floor-'.$v.'">'.$v.'</option>';
												}
												echo '</select>';
											}
											else if( $key == 'renovation' ) {
												echo '<select>';
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
													echo '<button type="button" class="' . $main_color_scss . '" data-mixitup-control="" data-filter=".rooms-0">С</button> ';
												}

												foreach ($value as $k => $v) {
													echo '<button type="button" class="' . $main_color_scss . '" data-mixitup-control="" data-filter=".' . $key . '-' . $v . '">' . $v . '</button> ';
												}
											}
										?>
									</fieldset>
								</div>
							<?}?>

							<div class="col uk-width-1-2@s uk-width-expand@m">
								<p>Сбросить фильтры</p>
								<button class="btn" type="reset">Показать все</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="uk-container-expand">
			<div uk-grid>
				<div class="uk-width-1-1">

					<div class="mixer__sort js-mixer-sort uk-visible@m uk-flex-middle uk-grid-small uk-child-width-1-2 uk-child-width-expand@m uk-text-center" uk-grid>
						<? foreach ( $filters_result as $key => $value ) { ?>
							<div class="col">
								<a href="#" class="caret" id="<?= $key; ?>" data-mixitup-control data-sort="<?= $key; ?>:desc"><?= $value; ?></a>
							</div>
						<?}?>
						<div class="col"><span>Узнать цену</span></div>
					</div>


					<div class="uk-margin-remove-top js-tooltip-parent" uk-grid>
						<div class="uk-width-1-1">
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
										<div class="js-modal mix <?= $mix_class; ?>" <?= $mix_data;?> data-image="<?= $image; ?>" data-flat_number="<?= $flat_number ? $flat_number : ''; ?>" data-filters_name="<?= implode( ';', $filters_name )?>">
											<div class="uk-flex-middle uk-grid-small uk-grid-row-collapse uk-child-width-expand uk-text-center" uk-grid>
												<div class="col mix__image uk-hidden@m">
													<?= $image ? '<img data-src="' . $image . '" alt="" class="img-fluid" uk-img>' : $no_pic; ?>
												</div>

												<? foreach ( $filters_meta as $key => $value ) { ?>
													<div class="col mix__<?= $key; ?>">
														<?
															if( $key == 'area') echo $value . ' м<sup>2</sup>';
															else if( $key == 'rooms') {
																$studio = get_post_meta( $post->ID, 'studio', true );
																if( $studio ) echo "Студия";
																else echo '<span class="uk-hidden@m">Комнат: </span>' . $value;
															}
															else if( $key == 'floor') echo '<span class="uk-hidden@m">Этаж: </span>' . $value;
															else echo $value;
														?>
													</div>
												<?}?>

												<div class="col mix__price">
													<a href="#callbackwidget" class="btn">Узнать цену</a>
												</div>
											</div>
										</div>
							<?
									}
								}
								wp_reset_postdata();
							?>

							<div class="js-mix-tooltip">Посмотреть планировку</div>
						</div>
					</div>

					<div class="uk-width-1-1 uk-text-center">
						<div class="mixer__failmessage uk-padding">
							<strong>Нет апартаментов с выбранными параметрами</strong>
						</div>
					</div>

					<div class="uk-width-1-1 uk-text-center">
						<div class="mixer__pagination">
							<div class="mixitup-page-list"></div>
							<div class="mixitup-page-stats"></div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

<? } else { ?>
	<div class="uk-padding-large uk-container">
		<div uk-grid>
			<div class="uk-width-2-3@m uk-width-1-2@l">
				<h2 class="title">Записей не обнаружено!</h2>
			</div>
		</div>
	</div>
<?}?>