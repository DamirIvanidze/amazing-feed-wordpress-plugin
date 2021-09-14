<style>
	.mixer {
		padding-top: 15px;
		padding-bottom: 15px;
	}

	.mixer form {
		margin-bottom: 60px;
	}

	@media only screen and (max-width: 992px) {
		.mixer form .col {
			max-width: 100%;
			flex-basis: 100%;
			text-align: center;
			margin-bottom: 20px;
		}
	}

	@media only screen and (max-width: 576px) {
		.mixer form {
			text-align: center;
		}
	}

	.mixer__filters p {
		font-weight: bold;
	}

	.mixer__filters button {
		display: inline-block;
		width: 38px;
		height: 38px;
		padding-left: 0;
		padding-right: 0;
		margin-bottom: 4px;
		cursor: pointer;
	}


	.mixer__filters button.mixitup-control-active,
	.mixer__filters button.active-button {
		background: <?= $active_color_hex; ?>;
		border-color: <?= $active_color_hex; ?>;
		box-shadow: none;
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
		text-align: center;
		padding-top: 15px;
		padding-bottom: 15px;
		background: <?= $active_color_hex; ?>;
	}

	@media only screen and (max-width: 992px) {
		.mixer__sort {
			display: none;
		}
	}

	.mixer__sort p,
	.mixer__sort a {
		margin-bottom: 0;
		color: #fff;
		text-decoration: none;
	}

	.mixer__sort a.caret:after {
		content: '';
		position: relative;
		top: -2px;
		left: 5px;
		display: inline-block;
		transition: all .7s;
		border-left: 0.3em solid transparent;
	    border-right: 0.3em solid transparent;
	    border-top: 0.3em solid #fff;
	}

	.mixer__sort a.caret.active:after {
		transform: rotate(180deg);
	}


	/* MIX */
	.mix {
		padding-left: 15px;
		padding-right: 15px;
		margin-left: -15px;
		margin-right: -15px;
		position: relative;
	}

	<? list( $main_color_hex_r, $main_color_hex_g, $main_color_hex_b ) = sscanf( $main_color_hex, "#%02x%02x%02x" ); ?>

	.mix.js-stripped-color {
		background: rgba(<?= $main_color_hex_r; ?>, <?= $main_color_hex_g; ?>, <?= $main_color_hex_b; ?>, .3);
	}


	/* MIX Header */
	.mix__header {
		text-align: center;
	}

	.mix__header .col {
		padding-top: 15px;
		padding-bottom: 15px;
	}

	.mix__header .mix__image img,
	.mix__header .mix__image svg {
		height: 30px;
	}

	@media only screen and (max-width: 992px) {
		.mix__header .col,
		.mix__header .js-modal-link {
			display: none;
		}

		.mix__header .col.mix__image,
		.mix__header .col.mix__rooms,
		.mix__header .col.mix__area {
			display: initial;
		}
	}

	@media only screen and (min-width: 992px) {
		.mix__header .col.mix__image,
		.mix__header span,
		.mix__header .collapse_link {
			display: none;
		}
	}

	.mix__header .mix__price {
		position: relative;
	}

	.mix__header .mix__price .js-callbackwidget {
		z-index: 999;
	}


	/* MIX Body */
	.mix__body {
		text-align: center;
		margin-top: 20px;
	}

	.mix__body .stretched-link {
		margin: 30px;
	}

	.mix__body img,
	.mix__body svg {
		display: block;
		margin: 0 auto;
		max-height: 300px;
	}


	/* Fail message */
	.mixer__failmessage {
		font-weight: bold;
		margin: 40px auto;
		text-align: center;
		display: none;
	}


	/* Pagination */
	.mixer__pagination {
		margin-top: 40px;
		text-align: center;
	}

	.mixer__pagination:after {
		content: '';
		display: inline-block;
		width: 100%;
	}

	.mixer__pagination .mixitup-page-stats {
		font-weight: bold;
	}

	.mixer__pagination .mixitup-control {
		position: relative;
		display: inline-block;
		vertical-align: middle;
		text-align: center;
		width: 2.7rem;
		height: 2.7rem;
		background: #fff;
		border: 1px solid rgb(209, 209, 209);
		margin-right: 1px;
		margin-bottom: 5px;
		cursor: pointer;
		line-height: 2.7rem;
		font-weight: bold;
		transition: color 150ms, border-color 150ms;
	}

	.mixer__pagination .mixitup-control:first-child {
		border-radius: 3px 0 0 3px;
	}

	.mixer__pagination .mixitup-control:last-child {
		border-radius: 0 3px 3px 0;
	}

	.mixer__pagination .mixitup-control:not( .mixitup-control-active ):hover {
		color: <?= $main_color_hex; ?>;
	}

	.mixer__pagination .mixitup-control.mixitup-control-active {
		border-bottom: 3px solid <?= $main_color_hex; ?>;
	}

	.mixer__pagination .mixitup-control:disabled {
		background: #eaeaea;
		color: #aaa;
	}

	.mixer__pagination .mixitup-control.mixitup-control-truncation-marker {
		background: transparent;
		pointer-events: none;
		line-height: 2.2em;
	}


	/* Modal */
	@media only screen and (min-width: 576px) {
		.modal-shortcode-twbs .modal-dialog {
			max-width: 1140px;
			padding-left: 15px;
			padding-right: 15px;
		}
	}

	.modal-shortcode-twbs .modal-content {
		border-radius: 0;
		border: 0;
	}

	.modal-shortcode-twbs .modal-body {
		padding: 0;
	}

	.modal-shortcode-twbs .modal-body .btn-close {
		position: absolute;
		top: 10px;
		right: 20px;
		font-size: 30px;
	}

	.modal-shortcode-twbs .modal-body .close:hover,
	.modal-shortcode-twbs .modal-body .close:active,
	.modal-shortcode-twbs .modal-body .close:focus {
		color: <?= $main_color_hex; ?>;
	}

	.modal-shortcode-twbs .modal-body img,
	.modal-shortcode-twbs .modal-body svg {
		padding: 30px;
	}

	.modal-shortcode-twbs .modal-body svg {
		display: none;
		height: 300px;
	}

	.modal-shortcode-twbs .modal-body .area {
		margin-top: 20px;
	}

	.modal-shortcode-twbs .modal-body .area span {
		display: block;
		font-weight: bold;
	}

	.modal-shortcode-twbs .modal-body .area span:first-child {
		font-size: 40px;
	}

	.modal-shortcode-twbs .modal-body .area span:last-child {
		font-size: 18px;
		text-transform: uppercase;
	}

	.modal-shortcode-twbs .if-need-background-color {
		padding: 30px;
		height: 100%;
	}

	.modal-shortcode-twbs__form {
		border: 2px solid <?= $main_color_hex; ?>;
		padding: 15px;
		text-align: center;
	}

	.modal-shortcode-twbs__form p:first-child {
		color: <?= $main_color_hex; ?>;
		text-transform: uppercase;
		margin-bottom: 10px;
		font-weight: bold;
	}

	.modal-shortcode-twbs__form .ajax-loader {
		position: absolute;
	}

	.modal-shortcode-twbs__form .wpcf7-form .wpcf7-response-output.wpcf7-mail-sent-ok,
	.modal-shortcode-twbs__form .wpcf7-form .wpcf7-response-output.wpcf7-validation-errors {
		display: none !important;
	}

	.modal-shortcode-twbs__form .wpcf7-not-valid-tip {
		font-size: 10px;
		color: <?= $main_color_hex; ?>;
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
</style>