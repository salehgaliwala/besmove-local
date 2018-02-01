<?php

add_filter( 'wp_generate_attachment_metadata', 'thrive_update_attachment', 10, 2 );

add_filter( 'manage_media_columns', 'thrive_media_columns' );
add_action( 'manage_media_custom_column', 'thrive_media_custom_column', 10, 2 );

add_action( 'admin_action_wp_kraken_manual', 'thrive_process_single_kraken_image' );

add_action( 'rest_api_init', 'thrive_kraken_callback_route' );

function thrive_kraken_callback_route() {
	register_rest_route( 'thrive', '/kraken', array(
		array(
			'methods'  => WP_REST_Server::CREATABLE,
			'callback' => 'thrive_kraken_callback',
		),
	) );
}

function thrive_update_attachment( $meta, $ID ) {

	$optimize_image_type = thrive_get_theme_options( 'image_optimization_type' );
	if ( $optimize_image_type === 'off' ) {
		return $meta;
	}
	$lossy = $optimize_image_type === 'lossy';

	$attachment_file_path = get_attached_file( $ID );
	$attachment_file_url  = wp_get_attachment_url( $ID );
	$upload_dir           = trailingslashit( dirname( $attachment_file_path ) );

	$sizes = array(
		array(
			'id'       => $ID,
			'strategy' => 'none',
			'file'     => $attachment_file_path,
		)
	);
	foreach ( $meta['sizes'] as $size_key => $size_data ) {
		$sizes[] = array(
			'id'       => $size_key,
			'strategy' => 'auto',
			'width'    => $size_data['width'],
			'height'   => $size_data['height'],
			'file'     => $upload_dir . $size_data['file']
		);
	}

	do {
		$reduced        = array_slice( $sizes, 0, 10 );
		$process_result = thrive_process_kraken_image( $attachment_file_url, $reduced, $lossy );
		$sizes          = array_slice( $sizes, 9 );
	} while ( count( $sizes ) > 10 );
	$meta['wp_kraken'] = $process_result;

	if ( ! isset( $meta['sizes'] ) ) {
		return $meta;
	}

	return $meta;
}

function thrive_media_columns( $defaults ) {
	$optimize_image_type = thrive_get_theme_options( 'image_optimization_type' );

	if ( $optimize_image_type == "off" ) {
		return $defaults;
	}
	$defaults['kraken'] = 'Optimize';

	return $defaults;
}

function thrive_media_custom_column( $column_name, $id ) {
	$optimize_image_type = thrive_get_theme_options( 'image_optimization_type' );
	if ( $optimize_image_type == "off" ) {
		return $defaults;
	}
	if ( 'kraken' == $column_name ) {
		$data = wp_get_attachment_metadata( $id );
		if ( isset( $data['wp_kraken'] ) && ! empty( $data['wp_kraken'] ) ) {
			print $data['wp_kraken'];
			printf( "<br><a href=\"admin.php?action=wp_kraken_manual&amp;attachment_ID=%d\">%s</a>", $id, __( 'Re-compress', 'thrive' ) );
		} else {
			if ( wp_attachment_is_image( $id ) ) {
				print __( 'Not processed', 'thrive' );
				printf( "<br><a href=\"admin.php?action=wp_kraken_manual&amp;attachment_ID=%d\">%s</a>", $id, __( 'Compress', 'thrive' ) );
			}
		}
	}
}

function thrive_process_single_kraken_image() {
	if ( ! current_user_can( 'upload_files' ) ) {
		wp_die( __( "You don't have permission to work with uploaded files.", 'thrive' ) );
	}

	if ( ! isset( $_GET['attachment_ID'] ) ) {
		wp_die( __( 'No attachment ID was provided.', 'thrive' ) );
	}

	$attachment_ID = intval( $_GET['attachment_ID'] );

	$original_meta = wp_get_attachment_metadata( $attachment_ID );

	$new_meta = thrive_update_attachment( $original_meta, $attachment_ID );
	wp_update_attachment_metadata( $attachment_ID, $new_meta );

	wp_redirect( preg_replace( '|[^a-z0-9-~+_.?#=&;,/:]|i', '', wp_get_referer() ) );
	exit();
}

/**
 * Send request to kraken for optimizing an image
 *
 * @param $file_url
 * @param array $sizes
 * @param int $lossy
 *
 * @return string
 */
function thrive_process_kraken_image( $file_url, $sizes = array(), $lossy = 1 ) {
	require_once 'libs/ThriveOptimize.php';

	$thriveOptimize = new ThriveOptimize();

	$kraken_callback_url = get_rest_url() . 'thrive/kraken';

	$params = array(
		'file_url'      => $file_url,
		'callback_url'  => $kraken_callback_url,
		'lossy'         => $lossy,
		'resize'        => array_values( $sizes ),
		'preserve_meta' => array(
			'profile',
			'copyright',
		),
	);

	$data = $thriveOptimize->url( $params );

	if ( ! isset( $data['id'] ) && isset( $data['message'] ) ) {
		return $data['message'];
	}

	if ( ! isset( $data['id'] ) ) {
		return 'Compress failed';
	}

	$paths = array();

	foreach ( $sizes as $size ) {
		$paths[ $size['id'] ] = $size['file'];
	}

	add_option( $data['id'], json_encode( $paths ), '', 'no' );

	return 'Compress in progress (refresh to see the result)';
}

/**
 * Kraken callback for optimizing images
 */
function thrive_kraken_callback() {
	$response = json_decode( file_get_contents( 'php://input' ), true );

	if ( ! isset( $response['id'] ) ) {
		die;
	}

	$results   = $response['results'];
	$option_id = $response['id'];

	$option_str = get_option( $option_id );

	if ( ! $option_str ) {
		die;
	}

	$files = json_decode( $option_str );
	foreach ( $files as $aid => $file_path ) {

		$meta = wp_get_attachment_metadata( $aid );

		if ( ! empty( $response['file_already_compressed'] ) ) {
			$meta_info_msg     = 'File is already compressed';
			$meta['wp_kraken'] = $meta_info_msg;
			wp_update_attachment_metadata( $aid, $meta );
			die;
		}

		/*
		 * On success overwrite the current file
		 */
		if ( ! empty( $results[ $aid ] ) ) {
			$original_size = filesize( $file_path );
			$file_response = wp_remote_get( $results[ $aid ]['kraked_url'] );
			$image_string  = wp_remote_retrieve_body( $file_response );

			if ( empty( $image_string ) || is_wp_error( $file_response ) ) {
				$meta_info_msg     = 'Compress failed';
				$meta['wp_kraken'] = $meta_info_msg;
				wp_update_attachment_metadata( $aid, $meta );
				die;
			}
			$new_size = file_put_contents( $file_path, $image_string );

			$meta_info_msg     = 'Compressed (saved ' . ( $original_size - $new_size ) . ' bytes)';
			$meta['wp_kraken'] = $meta_info_msg;
			wp_update_attachment_metadata( $aid, $meta );
		}
	}

	/* we should delete the option each time */
	delete_option( $option_id );
}
