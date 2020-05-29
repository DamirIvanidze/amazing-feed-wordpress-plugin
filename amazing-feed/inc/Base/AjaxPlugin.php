<?
/**
 * @package  AmazingFeed
 */

namespace Inc\Base;

use \Inc\Cron\KamaCronPlugin;
use \Inc\Cron\CronPlugin;

class AjaxPlugin {

	public $output;
	public $cron;
	public $kama_cron;
	public $errors = array();

	public function __construct()
	{
		$this->output = get_option( 'amazing_feed_settings' );

		$this->cron = new CronPlugin();

		$this->kama_cron = new KamaCronPlugin([
			'id'     => 'af_cron_jobs',
			'auto_activate' => false,
			'events' => array(
				'wpkama_cron_func' => array(
					'callback'      => [ $this->cron, 'amazingFeedCron' ],
					'interval_name' => '10_min',
					'interval_desc' => 'Каждые 2 часа',
				),
			),
		]);

		$this->errors = array(
			'error_verify_nonce' => 'Данные присланны со сторонней страницы!',
			'error_authorized' => 'Вы не авторизованы!',
			'error_url' => 'Неверный формат. Ипользуйте http или https перед адресом сайта. Пример: http://google.com.',
			'error_length' => 'Количество символов должно быть не меньше 2 и не больше 50!',
		);
	}

	public function register()
	{
		add_action( 'wp_ajax_remove_all_posts', array( $this, 'removeAllPosts') );

		add_action( 'wp_ajax_check_progress', array( $this, 'checkProgress') );

		add_action( 'wp_ajax_activate_deactivate_cron', array( $this, 'activateDeactivateCron') );

		add_action( 'wp_ajax_edit_settings', array( $this, 'editSettings') );
	}

	public function checkNonce( $nonce_from_func )
	{
		$nonce = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';

		if ( !wp_verify_nonce( $nonce, $nonce_from_func ) ) wp_send_json_error( array( 'message' => $this->errors[ 'error_verify_nonce' ] ) );
		if ( !is_user_logged_in() ) wp_send_json_error( array( 'message' => $this->errors[ 'error_authorized' ] ) );
	}


	public function removeAllPosts()
	{
		$this->checkNonce( 'remove_all_posts_nonce' );

		$redirect_to = isset( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : '';

		$args = array( 'posts_per_page' => -1 );
		$posts = get_posts( $args );
		$count = count( $posts );

		foreach ( $posts as $key => $post ) {
			$this->output[ 'check_progress' ] = 100 / $count * ( $key + 1 );
			update_option( 'amazing_feed_settings', $this->output );

			if( has_post_thumbnail( $post->ID ) ) {
				$attachment_id = get_post_thumbnail_id( $post->ID );
				wp_delete_attachment( $attachment_id, true );
			}

			wp_delete_post( $post->ID, true );
		}

		$this->output[ 'check_progress' ] = 0;
		update_option( 'amazing_feed_settings', $this->output );

		wp_send_json_success( array( 'message' => 'Saved.', 'redirect' => $redirect_to ) );
	}


	public function activateDeactivateCron()
	{
		$this->checkNonce( 'activate_deactivate_cron_nonce' );

		$redirect_to = isset( $_POST[ 'redirect_to' ] ) ? $_POST[ 'redirect_to' ] : '';

		// $cron_status = isset( $_POST[ 'status '] ) ? $_POST[ 'cron_status' ] : '';

		$cron_status = $_POST[ 'cron_status' ];

		switch ( $cron_status ) {
			case 'activate':
				$this->kama_cron::activate( 'af_cron_jobs' );
				break;

			case 'deactivate':
				$this->kama_cron::deactivate( 'af_cron_jobs' );
				break;
		}


		$this->output[ 'cron' ][ 'status' ] = $cron_status;
		update_option( 'amazing_feed_settings', $this->output );

		wp_send_json_success( array( 'message' => 'Saved.', 'redirect' => $redirect_to ) );
	}


	public function editSettings()
	{
		$this->checkNonce( 'edit_settings_nonce' );

		$redirect_to = isset( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : '';

		$edit = array();

		$parse_link = isset( $_POST['parse_link'] ) ? $_POST['parse_link'] : '';
		$parse_link = esc_url_raw( $parse_link );

		$complex_name = isset( $_POST['complex_name'] ) ? $_POST['complex_name'] : '';
		$complex_name = esc_attr( sanitize_text_field( $complex_name ) );

		$edit[ 'parse_link' ] = $parse_link;
		$edit[ 'complex_name' ] = $complex_name;


		$custom_name = isset( $_POST['custom_name'] ) ? $_POST['custom_name'] : '';
		$custom_value = isset( $_POST['custom_value'] ) ? $_POST['custom_value'] : '';
		$result = array_combine( $custom_name, $custom_value );

		$edit[ 'settings_for_import_array' ] = $result;


		foreach ( $edit as $key => $val ) {
			if( ! $edit[ $key ] ) {
				unset( $edit[ $key ] );
			}
		}


		foreach ( $edit as $key => $val ) {
			$this->output[ $key ] = $val;
		}

		update_option( 'amazing_feed_settings', $this->output );


		wp_send_json_success( array( 'message' => 'Saved.', 'redirect' => $redirect_to ) );
	}



	public function checkProgress()
	{
		/**
		 * Получаем, если вызвана функция удаления всех постов из БД
		 * Получаем, если проверяем запущена ли функция во время Cron
		 */
		$check_progress = $this->output[ 'check_progress' ];

		/**
		 * Время до следующего выполнения Cron
		 */
		$next_cron_time = $this->cron->nextCronTime( 'wpkama_cron_func' );

		/**
		 * Количество постов
		 */
		$count_posts = wp_count_posts();
		$published_posts = $count_posts->publish;


		wp_send_json_success( array( 'check_progress' => $check_progress, 'next_cron_time' => $next_cron_time, 'cron_func_run' => $check_progress, 'published_posts' => $published_posts) );
	}


}