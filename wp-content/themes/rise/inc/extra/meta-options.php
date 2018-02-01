<?php

function thrive_meta_post_format_options( $post ) {

	wp_nonce_field( plugin_basename( __FILE__ ), 'thrive_noncename_post_format' );

	$thrive_meta_postformat_video_type                    = get_post_meta( $post->ID, '_thrive_meta_postformat_video_type', true );
	$thrive_meta_postformat_video_youtube_url             = get_post_meta( $post->ID, '_thrive_meta_postformat_video_youtube_url', true );
	$thrive_meta_postformat_video_youtube_hide_related    = get_post_meta( $post->ID, '_thrive_meta_postformat_video_youtube_hide_related', true );
	$thrive_meta_postformat_video_youtube_hide_logo       = get_post_meta( $post->ID, '_thrive_meta_postformat_video_youtube_hide_logo', true );
	$thrive_meta_postformat_video_youtube_hide_controls   = get_post_meta( $post->ID, '_thrive_meta_postformat_video_youtube_hide_controls', true );
	$thrive_meta_postformat_video_youtube_hide_title      = get_post_meta( $post->ID, '_thrive_meta_postformat_video_youtube_hide_title', true );
	$thrive_meta_postformat_video_youtube_autoplay        = get_post_meta( $post->ID, '_thrive_meta_postformat_video_youtube_autoplay', true );
	$thrive_meta_postformat_video_youtube_hide_fullscreen = get_post_meta( $post->ID, '_thrive_meta_postformat_video_youtube_hide_fullscreen', true );
	$thrive_meta_postformat_video_vimeo_url               = get_post_meta( $post->ID, '_thrive_meta_postformat_video_vimeo_url', true );
	$thrive_meta_postformat_video_custom_url              = get_post_meta( $post->ID, '_thrive_meta_postformat_video_custom_url', true );
	$thrive_meta_postformat_quote_text                    = get_post_meta( $post->ID, '_thrive_meta_postformat_quote_text', true );
	$thrive_meta_postformat_quote_author                  = get_post_meta( $post->ID, '_thrive_meta_postformat_quote_author', true );
	$thrive_meta_postformat_audio_type                    = get_post_meta( $post->ID, '_thrive_meta_postformat_audio_type', true );
	$thrive_meta_postformat_audio_file                    = get_post_meta( $post->ID, '_thrive_meta_postformat_audio_file', true );
	$thrive_meta_postformat_audio_soundcloud_url          = get_post_meta( $post->ID, '_thrive_meta_postformat_audio_soundcloud_url', true );
	$thrive_meta_postformat_audio_soundcloud_autoplay     = get_post_meta( $post->ID, '_thrive_meta_postformat_audio_soundcloud_autoplay', true );
	$thrive_meta_postformat_gallery_images                = get_post_meta( $post->ID, '_thrive_meta_postformat_gallery_images', true );

	require( get_template_directory() . "/inc/templates/admin-post-format-options.php" );
}

add_action( 'save_post', 'thrive_save_post_formats_data' );

function thrive_save_post_formats_data( $post_id ) {

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['post_type'] ) && 'post' != $_POST['post_type'] ) {
		return;
	}
	if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
		return;
	}
	$post_data = $_POST;

	// Secondly we need to check if the user intended to change this value.
	if ( ! isset( $_POST['thrive_noncename_post_format'] ) || ! wp_verify_nonce( $_POST['thrive_noncename_post_format'], plugin_basename( __FILE__ ) ) ) {
		return;
	}

	$meta_fields        = _thrive_get_meta_fields( "post_formats" );
	$meta_fields_values = array();

	foreach ( $meta_fields as $field ) {
		$meta_fields_values[ $field ] = isset( $post_data[ $field ] ) ? $post_data[ $field ] : ''; // this is for checkboxes
	}

	foreach ( $meta_fields_values as $key => $value ) {
		add_post_meta( $post_id, '_' . $key, $value, true ) or
		update_post_meta( $post_id, '_' . $key, $value );
	}

	//get and save the soundcloud embed code
	if ( ! empty( $meta_fields_values['thrive_meta_postformat_audio_soundcloud_url'] ) ) {
		$soundcloudParams = array(
			'url'       => $meta_fields_values['thrive_meta_postformat_audio_soundcloud_url'],
			'auto_play' => ( $meta_fields_values['thrive_meta_postformat_audio_soundcloud_autoplay'] == 1 ) ? "true" : "false",
			'format'    => 'json'
		);
		if ( ! class_exists( 'ThriveSoundcloud' ) ) {
			include get_template_directory() . '/inc/libs/ThriveSoundcloud.php';
		}
		$thriveSoundcloud = new ThriveSoundcloud();
		$response         = $thriveSoundcloud->url( $soundcloudParams );

		if ( $response && isset( $response->html ) ) {
			add_post_meta( $post_id, '_thrive_meta_postformat_audio_soundcloud_embed_code', $response->html, true ) or
			update_post_meta( $post_id, '_thrive_meta_postformat_audio_soundcloud_embed_code', $response->html );
		}
	}
}

?>
