<?
/**
 * @package  DeepLevelPlugin
 */

namespace AF\Cron;

use \AF\Api\XmlPhpApiPlugin;

class CronPlugin
{
	public $xml_php_settings;
	/**
	 * Рассчет времени до следующего запуска функции
	 */
	public function nextCronTime( $cron_name )
	{
		foreach( _get_cron_array() as $timestamp => $crons ){
			if( in_array( $cron_name, array_keys( $crons ) ) ){
				return $this->secToStr( $timestamp - time() );
			}
		}

		return false;
	}


	/**
	 * Склонение существительных после числительных
	 */
	public function numWord( $value, $words, $show = true )
	{
		$num = $value % 100;
		if ($num > 19) {
			$num = $num % 10;
		}

		$out = ($show) ?  $value . ' ' : '';
		switch ($num) {
			case 1:  $out .= $words[0]; break;
			case 2:
			case 3:
			case 4:  $out .= $words[1]; break;
			default: $out .= $words[2]; break;
		}

		return $out;
	}


	/**
	 * Преобразование секунд в минуты, часы, дни
	 */
	public function secToStr( $secs )
	{
		$res = '';

		$days = floor( $secs / 86400 );

		if( $days > 0 ) {
			$secs = $secs % 86400;
			$res .= $this->numWord( $days, array( 'день', 'дня', 'дней' ) ) . ', ';
		}

		$hours = floor( $secs / 3600 );

		if( $hours > 0 ) {
			$secs = $secs % 3600;
			$res .= $this->numWord( $hours, array( 'час', 'часа', 'часов' ) ) . ', ';
		}

		$minutes = floor( $secs / 60 );

		if( $minutes > 0 ) {
			$secs = $secs % 60;
			$res .= $this->numWord( $minutes, array( 'минута', 'минуты', 'минут' ) ) . ', ';
		}

		$res .= $this->numWord( $secs, array( 'секунда', 'секунды', 'секунд' ) );

		return $res;
	}



	public function searchForArray( $id, $array ) {
		foreach ($array as $key => $val){
			if ($val['internal-id'] == $id){
				return $key;
			}
		}

		return null;
	}


	public function uploadFeaturedImage( $image_url, $post_id )
	{
		$image_name       = parse_url( home_url() )[ 'host' ] . '_' . basename( $image_url );
		$upload_dir       = wp_upload_dir();
		$image_data       = file_get_contents( $image_url );
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name );
		$filename         = basename( $unique_file_name );

		if( wp_mkdir_p( $upload_dir['path'] ) ) $file = $upload_dir['path'] . '/' . $filename;
		else $file = $upload_dir['basedir'] . '/' . $filename;

		file_put_contents( $file, $image_data );

		$wp_filetype = wp_check_filetype( $filename, null );

		$attachment = array(
			'guid'           => $upload_dir['path'] . '/' . $image_name,
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

		if ( ! is_wp_error( $attach_id ) ) {
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			set_post_thumbnail( $post_id, $attach_id );
		}


		/**
		 *
		 * Запасной вариант. 100% рабочий.
		 *
		 */

		// AFlude_once( ABSPATH . 'wp-admin/AFludes/image.php' );
		// $imageurl = '<IMAGE URL>';
		// $imagetype = end(explode('/', getimagesize($imageurl)['mime']));
		// $uniq_name = date('dmY').''.(int) microtime(true);
		// $filename = $uniq_name.'.'.$imagetype;

		// $uploaddir = wp_upload_dir();
		// $uploadfile = $uploaddir['path'] . '/' . $filename;
		// $contents= file_get_contents($imageurl);
		// $savefile = fopen($uploadfile, 'w');
		// fwrite($savefile, $contents);
		// fclose($savefile);

		// $wp_filetype = wp_check_filetype(basename($filename), null );
		// $attachment = array(
		//     'post_mime_type' => $wp_filetype['type'],
		//     'post_title' => $filename,
		//     'post_content' => '',
		//     'post_status' => 'inherit'
		// );

		// $attach_id = wp_insert_attachment( $attachment, $uploadfile );
		// $imagenew = get_post( $attach_id );
		// $fullsizepath = get_attached_file( $imagenew->ID );
		// $attach_data = wp_generate_attachment_metadata( $attach_id, $fullsizepath );
		// wp_update_attachment_metadata( $attach_id, $attach_data );
	}



	public function amazingFeedCron()
	{
		$output = get_option( 'amazing_feed_settings' );

		if( $output[ 'cron' ][ 'status' ] == 'activate' ) {
			$this->xml_php_settings = new XmlPhpApiPlugin();

			$xml = $this->xml_php_settings->simplexmlLoadStringNons( $output[ 'parse_link' ] );

			$offers = $xml->xpath('//offer[building-name[contains(.,"'. $output[ 'complex_name' ] .'")]]');
		}


		/**
		 * Получаем XML и настройки.
		 * Готовим массив для загрузки
		 */
		$array_to_import = array();

		foreach ( $offers as $key => $value ) {
			foreach ( $output[ 'settings_for_import_array' ] as $k => $v ) {
				$array_to_import[ $key ][ $k ] = $value->xpath( './' . $v ) ? ( string ) $value->xpath( './' . $v )[ 0 ] : '';
			}
		}


		/**
		 * Получаем массив записей из БД
		 */
		$old_posts_from_database_array = [];

		$args = array( 'fields' => 'ids', 'posts_per_page' => -1 );
		$posts = get_posts( $args );

		foreach ( $posts as $key => $post_id ) {
			foreach ( $output[ 'settings_for_import_array' ] as $k => $v ) {
				$old_posts_from_database_array[ $key ][ $k ] = get_post_meta( $post_id, $k, true );
			}
		}


		/**
		 * Ищем одинаковые записи в обоих массивах
		 */
		$ids1 = array();
		foreach($array_to_import as $elem1) {
			$ids1[] = $elem1['internal-id'];
		}

		$ids2 = array();
		foreach($old_posts_from_database_array as $elem2) {
			$ids2[] = $elem2['internal-id'];
		}

		$same_array = array_intersect($ids1, $ids2);



		/**
		 * Удаляем одинаковые записи из массива записей из БД
		 */
		foreach ( $same_array as $same_arr ) {
			$searchForArray = $this->searchForArray( $same_arr, $old_posts_from_database_array );
			unset( $old_posts_from_database_array[ $searchForArray ] );
		}

		foreach ( $posts as $key => $post_id ) {
			foreach ( $old_posts_from_database_array as $ids ) {
				if( $ids['internal-id'] == get_post_meta( $post_id, 'internal-id', true ) ) {
					echo $ids['internal-id'].' - '.$post_id.' - delete';

					if( has_post_thumbnail( $post_id ) ) {
						$attachment_id = get_post_thumbnail_id( $post_id );
						wp_delete_attachment( $attachment_id, true );
					}

					wp_delete_post( $post_id, true );
				}
			}
		}


		/**
		 * Удаляем одинаковые записи из массива для загрузки
		 */
		foreach ( $same_array as $same_arr ) {
			$searchForArray = $this->searchForArray( $same_arr, $array_to_import );
			unset( $array_to_import[ $searchForArray ] );
		}

		$array_to_import = array_values( $array_to_import );


		/**
		 * Заливаем новые записи в БД
		 */
		require_once( ABSPATH . 'wp-admin/AFludes/image.php' );

		$meta_array = array();

		$count = count( $array_to_import );

		foreach ( $array_to_import as $key => $value ) {
			$output[ 'check_progress' ] = 100 / $count * ( $key + 1 );
			update_option( 'amazing_feed_settings', $output );

			foreach ( $value as $k => $v ) {
				if( $v ) $meta_array[ $k ] = $v;
			}

			$post_data = array(
				'post_title'    => $array_to_import[ $key ][ 'internal-id' ],
				'post_content'  => isset( $array_to_import[ $key ][ 'description' ] ) ? $array_to_import[ $key ][ 'description' ] : '',
				'post_status'   => 'publish',
				'meta_input'     => $meta_array,
			);

			$post_id = wp_insert_post( wp_slash( $post_data ) );

			if( $post_id ) {
				$this->uploadFeaturedImage( $array_to_import[ $key ][ 'image' ], $post_id );
			}

			$meta_array = array();

			if( $output[ 'cron' ][ 'offers' ] > 200 && $key == 199 ) break;
		}


		$output[ 'check_progress' ] = 0;
		update_option( 'amazing_feed_settings', $output );
	}

}