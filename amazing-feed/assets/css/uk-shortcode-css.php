<style>
	.mixer {
		overflow: hidden;
	}

	.mixer form p {
		font-size: 16px;
	}

	.mixer .btn {
		min-height: 50px;
	}

	.mixer__filters {
		margin: 0;
		padding: 0;
	}

	@media only screen and (max-width: 639px) {
		.mixer__filters {
			max-width: 320px;
			margin-left: auto;
			margin-right: auto;
		}
	}

	.mixer__filters p {
		font-weight: 500;
	}

	.mixer__filters .btn {
		font-size: 16px;
		white-space: nowrap;
		padding: 0 20px;
		cursor: pointer;
	}

	.mixer__filters select {
		font: normal 16px/1 'Montserrat', sans-serif;
		display: inline-block;
		width: 100%;
		min-height: 50px;
		padding: 10px 20px 10px 10px;
		outline: 0;
		border-radius: 0;
		background-color: transparent;
		cursor: pointer;
	}

	.mixer__filters .btn[type="reset"] {
		font-size: 16px;
	}

	@media only screen and (max-width: 639px) {
		.mixer__filters .btn[type="reset"] {
			width: 100%;
		}
	}

	.mixer__filters button.mixitup-control-active,
	.mixer__filters button.active-button {
		background: <?= $active_color_hex; ?>;
		border-color: <?= $active_color_hex; ?>;
		box-shadow: none;
		color: #fff;
	}


	/* RangeSlider */
	.irs--flat .irs-from,
	.irs--flat .irs-to,
	.irs--flat .irs-single,
	.irs-bar {
		background-color: <?= $active_color_hex; ?> !important;
	}

	.irs--flat .irs-from:before,
	.irs--flat .irs-to:before,
	.irs--flat .irs-single:before {
		border-top-color: <?= $active_color_hex; ?> !important;
	}

	.irs-handle {
		width: 20px !important;
		height: 20px !important;
		border-radius: 50%;
		background-color: <?= $main_color_hex; ?> !important;
		margin-top: -1px;
	}

	.irs-handle i {
		display: none !important;
	}


	.mixer__sort {
		background-color: <?= $active_color_hex; ?>;
	}

	.mixer__sort .col {
		padding: 20px 10px;
		order: 1;
	}

	.mixer__sort a,
	.mixer__sort span {
		font-size: 16px;
		font-weight: 500;
		color: white;
		text-decoration: none;
	}

	.mixer__sort a.caret:after {
		content: '';
		position: relative;
		top: -2px;
		left: 5px;
		display: inline-block;
		border-top: 0.3em solid;
		border-right: 0.3em solid transparent;
		border-bottom: 0;
		border-left: 0.3em solid transparent;
		transition: all .7s;
	}

	.mixer__sort a.caret.active:after {
		transform: rotate(180deg);
	}


	.mixer__pagination {
		text-align: center;
		padding-top: 40px;
	}

	.mixer__pagination .mixitup-control {
		font-family: 'Montserrat', sans-serif;
		font-size: 18px;
		background-color: transparent;
		padding: 8px 14px;
		border: none;
		color: <?= $active_color_hex; ?>;
		text-align: center;
		text-decoration: none;
		cursor: pointer;
		outline: none;
	}

	.mixer__pagination .mixitup-control:hover,
	.mixer__pagination .mixitup-control-active {
		background-color: <?= $main_color_hex; ?>;
		color: <?= $active_color_hex; ?>;
	}

	.mixer__pagination .mixitup-control-disabled,
	.mixer__pagination .mixitup-control-disabled:hover {
		background-color: transparent;
		border-color: #999;
		color: #999;
		cursor: default;
	}

	.mixer__pagination .mixitup-control-truncation-marker,
	.mixer__pagination .mixitup-control-truncation-marker:hover {
		border-top: none;
		border-left: none;
		border-right: none;
		background-color: transparent;
		color: <?= $active_color_hex; ?>;
		cursor: default;
	}

	.mixer__pagination .mixitup-page-stats{
		padding-top: 20px;
		color: <?= $active_color_hex; ?>;
		opacity: .5;
		font-size: 12px;
	}

	.mixer__failmessage {
		display: none;
	}


	.mix {
		font-weight: 500;
		cursor: pointer !important;
	}

	<? list( $main_color_hex_r, $main_color_hex_g, $main_color_hex_b ) = sscanf( $main_color_hex, "#%02x%02x%02x" ); ?>

	.mix.js-stripped-color {
		background: rgba(<?= $main_color_hex_r; ?>, <?= $main_color_hex_g; ?>, <?= $main_color_hex_b; ?>, .3);
	}

	.mix .mix__image img,
	.mix .mix__image svg {
		height: 30px;
	}

	.mix .col {
		padding: 20px 10px;
		order: 1;
	}


	@media only screen and (max-width: 959px) {
		.mix .col {
			flex: 1 0 33.3332%;
			min-height: 30px;
		}

		.mix .mix__flat_number,
		.mix .mix__floor,
		.mix .mix__price {
			display: none;
		}

		.mix.mix__open .mix__rooms {
			margin-left: 33.3332%;
		}

		.mix.mix__open .mix__flat_number,
		.mix.mix__open .mix__floor,
		.mix.mix__open .mix__image,
		.mix.mix__open .mix__price {
			display: block;
			flex-basis: 100%;
			order: 2;
			margin-top: 0;
			padding-left: 30px;
		}

		.mix.mix__open .mix__image,
		.mix.mix__open .mix__price {
			order: 3;
		}

		.mix.mix__open .mix__image img,
		.mix.mix__open .mix__price img {
			height: auto;
		}
	}

	@media only screen and (min-width: 960px) {
		.mix .col {
			display: block;
			order: 1;
		}

		.mix .btn {
			width: 100%;
		}
	}


	.js-tooltip-parent {
		position: relative;
	}

	.js-mix-tooltip {
		position:absolute;
		z-index: 999;
		top: 0;
		left: 0;
		background: <?= $main_color_hex; ?>;
		color: #fff;
		padding: 10px;
		display: none;
		margin-left: 20px;
		width: 250px;
		text-align: center;
	}



	.modal .fos__subtitle {
		text-align: center;
	}

	.modal .fos__field input {
		border-color: #ccc;
		color: <?= $active_color_hex; ?>;
	}


	.modal .fos__field input::placeholder {
		color: <?= $active_color_hex; ?>;
	}

	@media only screen and (min-width: 1200px) {
		.modal .uk-grid > div:last-child{
			max-width: 500px;
			margin-right: 0;
			margin-left: auto;
		}
	}

	.modal .modal__data {
		font-size: 24px;
		margin-bottom: 30px;
	}

	.modal .modal__plan {
		display: block;
		margin: auto;
	}
</style>