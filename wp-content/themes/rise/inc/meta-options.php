<?php
require_once 'extra/meta-options.php';


add_action( 'add_meta_boxes', 'thrive_add_custom_fields' );

add_action( 'save_post', 'thrive_save_postdata' );

function thrive_add_custom_fields() {
	$pageID = get_the_ID();
	add_meta_box( 'thrive_post_format_options', __( 'Thrive Post Format Options', 'thrive' ), 'thrive_meta_post_format_options', "post", "normal", "high" );

	add_meta_box( 'thrive_post_options', __( 'Thrive Theme Options', 'thrive' ), 'thrive_meta_post_options', "post" );
	if ( get_option( 'page_for_posts ' ) != $pageID ) {
		add_meta_box( 'thrive_page_options', __( 'Thrive Theme Options', 'thrive' ), 'thrive_meta_page_options', "page" );
	}
	add_meta_box( 'thrive_focus_options', __( 'Build Your Focus Area', 'thrive' ), 'thrive_meta_focusarea_options', "focus_area", "advanced", "high" );
	add_meta_box( 'thrive_optin_options', __( 'Build Your Optin Form', 'thrive' ), 'thrive_meta_optin_options', "thrive_optin", "advanced", "high" );

	add_meta_box( 'thrive_focus_display_options', __( 'Thrive Focus Area Display Options', 'thrive' ), 'thrive_meta_focusarea_display_options', "focus_area", "side" );
}

function thrive_meta_post_options( $post ) {

	wp_nonce_field( plugin_basename( __FILE__ ), 'thrive_noncename' );

	$post_templates = array( 'Default', 'Full Width', 'Landing Page', 'Narrow' );

	//get the focus areas
	$queryFocusAreas = new WP_Query( "post_type=focus_area&order=ASC&posts_per_page=-1" );

	$meta_fields        = _thrive_get_meta_fields( "post" );
	$meta_fields_values = array();
	foreach ( $meta_fields as $field ) {
		$meta_fields_values[ $field ] = get_post_meta( $post->ID, '_' . $field, true );
	}

	$value_post_body_scripts_top = get_post_meta( $post->ID, '_thrive_meta_post_body_scripts_top', true );

	if ( $meta_fields_values['thrive_meta_post_floating_icons'] != "on" && $meta_fields_values['thrive_meta_post_floating_icons'] != "off" ) {
		$meta_fields_values['thrive_meta_post_floating_icons'] = "default";
	}
	if ( $meta_fields_values['thrive_meta_show_post_title'] != 0 || $meta_fields_values['thrive_meta_show_post_title'] == "" ) {
		$meta_fields_values['thrive_meta_show_post_title'] = 1;
	}

	if ( $meta_fields_values['thrive_meta_post_breadcrumbs'] != "on" && $meta_fields_values['thrive_meta_post_breadcrumbs'] != "off" ) {
		$meta_fields_values['thrive_meta_post_breadcrumbs'] = "default";
	}
	if ( $meta_fields_values['thrive_meta_post_meta_info'] != "on" && $meta_fields_values['thrive_meta_post_meta_info'] != "off" ) {
		$meta_fields_values['thrive_meta_post_meta_info'] = "default";
	}
	if ( $meta_fields_values['thrive_meta_post_featured_image'] != "thumbnail"
	     && $meta_fields_values['thrive_meta_post_featured_image'] != "wide"
	     && $meta_fields_values['thrive_meta_post_featured_image'] != "off"
	     && $meta_fields_values['thrive_meta_post_featured_image'] != "top"
	) {
		$meta_fields_values['thrive_meta_post_featured_image'] = "default";
	}
	$scheme_options = thrive_get_default_customizer_options();
	//remove the first element which is the 'no pattern' png
	$patterns = _thrive_get_patterns_from_directory();
	array_shift( $patterns );

	$thrive_meta_social_data_title       = get_post_meta( $post->ID, '_thrive_meta_social_data_title', true );
	$thrive_meta_social_data_description = get_post_meta( $post->ID, '_thrive_meta_social_data_description', true );
	$thrive_meta_social_image            = get_post_meta( $post->ID, '_thrive_meta_social_image', true );
	$thrive_meta_social_twitter_username = get_post_meta( $post->ID, '_thrive_meta_social_twitter_username', true );
	$thrive_meta_social_data_overwrite   = get_post_meta( $post->ID, '_thrive_meta_social_data_overwrite', true );

	require( get_template_directory() . "/inc/templates/admin-post-options.php" );
}

function thrive_meta_page_options( $page ) {

	wp_nonce_field( plugin_basename( __FILE__ ), 'thrive_noncename' );

	//get the focus areas
	$queryFocusAreas = new WP_Query( "post_type=focus_area&order=ASC&posts_per_page=-1" );

	$meta_fields        = _thrive_get_meta_fields( "page" );
	$meta_fields_values = array();
	foreach ( $meta_fields as $field ) {
		$meta_fields_values[ $field ] = get_post_meta( $page->ID, '_' . $field, true );
	}

	if ( $meta_fields_values['thrive_meta_post_floating_icons'] != "on" && $meta_fields_values['thrive_meta_post_floating_icons'] != "off" ) {
		$meta_fields_values['thrive_meta_post_floating_icons'] = "default";
	}
	if ( $meta_fields_values['thrive_meta_show_post_title'] != 0 || $meta_fields_values['thrive_meta_show_post_title'] == "" ) {
		$meta_fields_values['thrive_meta_show_post_title'] = 1;
	}

	if ( $meta_fields_values['thrive_meta_post_breadcrumbs'] != "on" && $meta_fields_values['thrive_meta_post_breadcrumbs'] != "off" ) {
		$meta_fields_values['thrive_meta_post_breadcrumbs'] = "default";
	}

	if ( $meta_fields_values['thrive_meta_post_featured_image'] != "thumbnail"
	     && $meta_fields_values['thrive_meta_post_featured_image'] != "wide"
	     && $meta_fields_values['thrive_meta_post_featured_image'] != "off"
	     && $meta_fields_values['thrive_meta_post_featured_image'] != "top"
	) {
		$meta_fields_values['thrive_meta_post_featured_image'] = "default";
	}

	$scheme_options = thrive_get_default_customizer_options();

	$value_post_body_scripts_top         = get_post_meta( $page->ID, '_thrive_meta_post_body_scripts_top', true );
	$thrive_meta_social_data_title       = get_post_meta( $page->ID, '_thrive_meta_social_data_title', true );
	$thrive_meta_social_data_description = get_post_meta( $page->ID, '_thrive_meta_social_data_description', true );
	$thrive_meta_social_image            = get_post_meta( $page->ID, '_thrive_meta_social_image', true );
	$thrive_meta_social_twitter_username = get_post_meta( $page->ID, '_thrive_meta_social_twitter_username', true );
	$thrive_meta_social_data_overwrite   = get_post_meta( $page->ID, '_thrive_meta_social_data_overwrite', true );

	require( get_template_directory() . "/inc/templates/admin-page-options.php" );
}

function thrive_meta_focusarea_options( $page ) {

	wp_enqueue_script( "thrive-focus-options" );
	wp_enqueue_style( "thrive-admin-focus" );
	wp_enqueue_style( "thrive-admin-focustemplates" );
	wp_enqueue_style( "thrive-admin-responsivefocus" );


	wp_nonce_field( plugin_basename( __FILE__ ), 'thrive_noncename' );

	$focus_templates = array(
		'1' => 'Template 1',
		'2' => 'Template 2',
		'3' => 'Template 3',
		'4' => 'Template 4',
		'5' => 'Template 5',
		'6' => 'Template 6',
		'0' => 'Custom Template',
	);

	$focus_templates = apply_filters( "thrive_focus_templates_filter", $focus_templates );

	$focus_colors = _thrive_get_color_scheme_options( "focusareas" );
	$focus_colors = array_merge( $focus_colors, array( 'light' => 'Light', 'dark' => 'Dark' ) );

	$meta_fields        = _thrive_get_meta_fields( "focusarea" );
	$meta_fields_values = array();
	foreach ( $meta_fields as $field ) {
		if ( $field == "thrive_meta_focus_display_categories" ) {
			$meta_fields_values[ $field ] = json_decode( get_post_meta( $page->ID, '_' . $field, true ) );
		} else {
			$meta_fields_values[ $field ] = get_post_meta( $page->ID, '_' . $field, true );
		}
	}

	if ( ! $meta_fields_values['thrive_meta_focus_template'] || $meta_fields_values['thrive_meta_focus_template'] == "" ) {
		$meta_fields_values['thrive_meta_focus_template'] = "template1";
	}

	$queryOptins = new WP_Query( "post_type=thrive_optin&order=ASC&post_status=publish&posts_per_page=-1" );

	//prepare the javascript params
	$wpnonce         = wp_create_nonce( "thrive_preview_focus_nonce" );
	$focusPreviewUrl = admin_url( 'admin-ajax.php?action=focus_render_preview&nonce=' . $wpnonce );

	$js_params_array = array(
		'focusPreviewUrl' => $focusPreviewUrl,
		'noonce'          => $wpnonce,
		'id_post'         => $page->ID
	);
	wp_localize_script( 'thrive-focus-options', 'ThriveFocusOptions', $js_params_array );

	$button_colors = _thrive_get_color_scheme_options( "buttons" );

	require( get_template_directory() . "/inc/templates/admin-focus-area.php" );
}

function thrive_meta_optin_options( $page ) {

	wp_enqueue_script( "thrive-optin-options" );
	wp_nonce_field( plugin_basename( __FILE__ ), 'thrive_noncename' );

	$value_optin_autoresponder_code = get_post_meta( $page->ID, '_thrive_meta_optin_autoresponder_code', true );
	$value_optin_autoresponder_code = htmlentities( $value_optin_autoresponder_code );

	//prepare the javascript params
	$wpnonce         = wp_create_nonce( "thrive_render_fields_nonce" );
	$renderFieldsUrl = admin_url( 'admin-ajax.php?action=optin_render_fields&nonce=' . $wpnonce );
	$saveFieldsUrl   = admin_url( 'admin-ajax.php?action=optin_save_field_labels&nonce=' . $wpnonce );
	$js_params_array = array(
		'renderFieldsUrl' => $renderFieldsUrl,
		'saveFieldsUrl'   => $saveFieldsUrl,
		'noonce'          => $wpnonce,
		'id_post'         => $page->ID,
		'stuff'           => 'ole'
	);
	wp_localize_script( 'thrive-optin-options', 'ThriveOptinOptions', $js_params_array );

	require( get_template_directory() . "/inc/templates/admin-optin-options.php" );
}

function thrive_meta_focusarea_display_options( $page ) {

	$meta_fields        = _thrive_get_meta_fields( "focusarea" );
	$meta_fields_values = array();
	foreach ( $meta_fields as $field ) {
		if ( $field == "thrive_meta_focus_display_categories" ) {
			$meta_fields_values[ $field ] = json_decode( get_post_meta( $page->ID, '_' . $field, true ) );
		} else {
			$meta_fields_values[ $field ] = get_post_meta( $page->ID, '_' . $field, true );
		}
	}

	if ( ! is_array( $meta_fields_values['thrive_meta_focus_display_categories'] ) ) {
		$meta_fields_values['thrive_meta_focus_display_categories'] = array();
	}

	$all_categories   = get_categories();
	$categories_array = array();

	foreach ( $all_categories as $cat ) {
		array_push( $categories_array, array( 'id' => $cat->cat_ID, 'name' => $cat->cat_name ) );
	}

	require( get_template_directory() . "/inc/templates/admin-focus-area-display.php" );
}

/* When the post is saved, saves our custom data */

function thrive_save_postdata( $post_id ) {

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Secondly we need to check if the user intended to change this value.
	if ( ! isset( $_POST['thrive_noncename'] ) || ! wp_verify_nonce( $_POST['thrive_noncename'], plugin_basename( __FILE__ ) ) ) {
		return;
	}

	if ( 'page' == $_POST['post_type'] ) {
		_thrive_save_page_options( $_POST );
	} elseif ( 'focus_area' == $_POST['post_type'] ) {
		_thrive_save_focus_options( $_POST );
	} elseif ( 'post' == $_POST['post_type'] || TT_APPR_POST_TYPE_LESSON == $_POST['post_type']
	           || TT_APPR_POST_TYPE_PAGE == $_POST['post_type']
	) {
		_thrive_save_post_options( $_POST );
	} elseif ( 'thrive_optin' == $_POST['post_type'] ) {
		_thrive_save_optin_options( $_POST );
	}
}

function _thrive_save_post_options( $post_data ) {

	$post_ID = $post_data['post_ID'];

	$meta_fields        = _thrive_get_meta_fields( "post" );
	$meta_fields_values = array();

	foreach ( $meta_fields as $field ) {
		$meta_fields_values[ $field ] = isset( $post_data[ $field ] ) ? $post_data[ $field ] : '';
	}

	//apply some defaults
	if ( $post_data['thrive_meta_post_focus_area_top'] == "default" || $post_data['thrive_meta_post_focus_area_top'] == "hide" ) {
		$meta_fields_values['thrive_meta_post_focus_area_top'] = $post_data['thrive_meta_post_focus_area_top'];
	} else if ( $post_data['thrive_meta_post_focus_area_top'] == "custom" ) {
		$meta_fields_values['thrive_meta_post_focus_area_top'] = is_numeric( $post_data['thrive_meta_post_focus_area_top_select'] ) ? $post_data['thrive_meta_post_focus_area_top_select'] : "default";
	} else {
		$meta_fields_values['thrive_meta_post_focus_area_top'] = "default";
	}

	if ( $post_data['thrive_meta_post_focus_area_bottom'] == "default" || $post_data['thrive_meta_post_focus_area_bottom'] == "hide" ) {
		$meta_fields_values['thrive_meta_post_focus_area_bottom'] = $post_data['thrive_meta_post_focus_area_bottom'];
	} else if ( $post_data['thrive_meta_post_focus_area_bottom'] == "custom" ) {
		$meta_fields_values['thrive_meta_post_focus_area_bottom'] = is_numeric( $post_data['thrive_meta_post_focus_area_bottom_select'] ) ? $post_data['thrive_meta_post_focus_area_bottom_select'] : "default";
	} else {
		$meta_fields_values['thrive_meta_post_focus_area_bottom'] = "default";
	}

	$meta_fields_values['thrive_meta_post_body_scripts_top'] = $post_data['thrive_meta_post_body_scripts_top'];

	foreach ( $meta_fields_values as $key => $value ) {
		add_post_meta( $post_ID, '_' . $key, $value, true ) or
		update_post_meta( $post_ID, '_' . $key, $value );
	}

}

function _thrive_save_page_options( $post_data ) {
	$page_ID = $post_data['post_ID'];

	$meta_fields        = _thrive_get_meta_fields( "post" );
	$meta_fields_values = array();

	foreach ( $meta_fields as $field ) {
		$meta_fields_values[ $field ] = isset( $post_data[ $field ] ) ? $post_data[ $field ] : '';
	}

	//apply some defaults
	if ( $post_data['thrive_meta_post_focus_area_top'] == "default" || $post_data['thrive_meta_post_focus_area_top'] == "hide" ) {
		$meta_fields_values['thrive_meta_post_focus_area_top'] = $post_data['thrive_meta_post_focus_area_top'];
	} else if ( $post_data['thrive_meta_post_focus_area_top'] == "custom" ) {
		$meta_fields_values['thrive_meta_post_focus_area_top'] = is_numeric( $post_data['thrive_meta_post_focus_area_top_select'] ) ? $post_data['thrive_meta_post_focus_area_top_select'] : "default";
	} else {
		$meta_fields_values['thrive_meta_post_focus_area_top'] = "default";
	}

	if ( $post_data['thrive_meta_post_focus_area_bottom'] == "default" || $post_data['thrive_meta_post_focus_area_bottom'] == "hide" ) {
		$meta_fields_values['thrive_meta_post_focus_area_bottom'] = $post_data['thrive_meta_post_focus_area_bottom'];
	} else if ( $post_data['thrive_meta_post_focus_area_bottom'] == "custom" ) {
		$meta_fields_values['thrive_meta_post_focus_area_bottom'] = is_numeric( $post_data['thrive_meta_post_focus_area_bottom_select'] ) ? $post_data['thrive_meta_post_focus_area_bottom_select'] : "default";
	} else {
		$meta_fields_values['thrive_meta_post_focus_area_bottom'] = "default";
	}

	$meta_fields_values['thrive_meta_post_body_scripts_top'] = $post_data['thrive_meta_post_body_scripts_top'];

	foreach ( $meta_fields_values as $key => $value ) {
		add_post_meta( $page_ID, '_' . $key, $value, true ) or
		update_post_meta( $page_ID, '_' . $key, $value );
	}

}

function _thrive_save_focus_options( $post_data ) {
	$page_ID = $post_data['post_ID'];

	$meta_fields        = _thrive_get_meta_fields( "focusarea" );
	$meta_fields_values = array();

	foreach ( $meta_fields as $field ) {
		if ( isset( $post_data[ $field ] ) ) {
			if ( $field == "thrive_meta_focus_display_categories" || $field == "thrive_meta_focus_subheading_text" ) {
				$meta_fields_values[ $field ] = $post_data[ $field ];
			} else {
				$meta_fields_values[ $field ] = sanitize_text_field( $post_data[ $field ] );
			}
		} else {
			if ( $field == "thrive_meta_focus_page_blog" || $field == "thrive_meta_focus_page_archive" ) {
				$meta_fields_values[ $field ] = ""; //if the checkboxes are not checked
			}
		}
	}


	foreach ( $meta_fields_values as $key => $value ) {
		add_post_meta( $page_ID, '_' . $key, $value, true ) or
		update_post_meta( $page_ID, '_' . $key, $value );
	}
}

function _thrive_save_optin_options( $post_data ) {

	$page_ID = $post_data['post_ID'];
	//sanitize user input
	$thrive_meta_optin_autoresponder_code = ( $post_data['thrive_meta_optin_autoresponder_code'] );

	add_post_meta( $page_ID, '_thrive_meta_optin_autoresponder_code', $thrive_meta_optin_autoresponder_code, true ) or
	update_post_meta( $page_ID, '_thrive_meta_optin_autoresponder_code', $thrive_meta_optin_autoresponder_code );
}

add_action( "wp_ajax_nopriv_focus_render_preview", "thrive_optin_render_fields" );
add_action( "wp_ajax_focus_render_preview", "thrive_focus_render_preview" );

function thrive_focus_render_preview() {

	if ( ! wp_verify_nonce( $_REQUEST['nonce'], "thrive_preview_focus_nonce" ) ) {
		echo 0;
		die;
	}
	if ( ! isset( $_POST['id_post'] ) ) {
		$current_focus = array();
	} else {
		$current_focus = get_post( $_POST['id_post'] );
	}

	$current_attrs = get_post_custom( $current_focus->ID );
	if ( ! $current_attrs || ! isset( $current_attrs['_thrive_meta_focus_template'] ) || ! isset( $current_attrs['_thrive_meta_focus_template'][0] ) ) {
		$current_attrs = array();
	}

	//overwrite the attributes
	$current_attrs['_thrive_meta_focus_color'][0]           = $_POST['thrive_meta_focus_color'];
	$current_attrs['_thrive_meta_focus_template'][0]        = $_POST['thrive_meta_focus_template'];
	$current_attrs['_thrive_meta_focus_optin'][0]           = $_POST['thrive_meta_focus_optin'];
	$current_attrs['_thrive_meta_focus_heading_text'][0]    = stripslashes( $_POST['thrive_meta_focus_heading_text'] );
	$current_attrs['_thrive_meta_focus_subheading_text'][0] = apply_filters( 'the_content', stripslashes( $_POST['thrive_meta_focus_subheading_text'] ) );
	$current_attrs['_thrive_meta_focus_image'][0]           = $_POST['thrive_meta_focus_image'];
	$current_attrs['_thrive_meta_focus_image2'][0]          = $_POST['thrive_meta_focus_image2'];
	$current_attrs['_thrive_meta_focus_button_link'][0]     = $_POST['thrive_meta_focus_button_link'];
	$current_attrs['_thrive_meta_focus_button_text'][0]     = stripslashes( $_POST['thrive_meta_focus_button_text'] );
	$current_attrs['_thrive_meta_focus_spam_text'][0]       = stripslashes( $_POST['thrive_meta_focus_spam_text'] );
	$current_attrs['_thrive_meta_focus_button_color'][0]    = $_POST['thrive_meta_focus_button_color'];
	$current_attrs['_thrive_meta_focus_custom_text'][0]     = isset( $_POST['thrive_meta_focus_custom_text'] ) ? $_POST['thrive_meta_focus_custom_text'] : "";
	$current_attrs['_thrive_meta_focus_new_tab'][0]         = empty( $_POST['thrive_meta_focus_new_tab'] ) ? 0 : 1;

	$current_attrs = apply_filters( 'thrive_focus_filter_preview_attributes', $current_attrs );

	if ( isset( $current_attrs['_thrive_meta_focus_optin'] ) && isset( $current_attrs['_thrive_meta_focus_optin'][0] ) ) {
		$optin_id = (int) $current_attrs['_thrive_meta_focus_optin'][0];

		//form action
		$optinFormAction = get_post_meta( $optin_id, '_thrive_meta_optin_form_action', true );

		//form method
		$optinFormMethod = get_post_meta( $optin_id, '_thrive_meta_optin_form_method', true );
		$optinFormMethod = strtolower( $optinFormMethod );
		$optinFormMethod = $optinFormMethod === 'post' || $optinFormMethod === 'get' ? $optinFormMethod : 'post';

		//form hidden inputs
		$optinHiddenInputs = get_post_meta( $optin_id, '_thrive_meta_optin_hidden_inputs', true );

		//form fields
		$optinFieldsJson  = get_post_meta( $optin_id, '_thrive_meta_optin_fields_array', true );
		$optinFieldsArray = json_decode( $optinFieldsJson, true );

		//form not visible inputs
		$optinNotVisibleInputs = get_post_meta( $optin_id, '_thrive_meta_optin_not_visible_inputs', true );
	} else {
		$optinFieldsArray  = array();
		$optinFormAction   = "";
		$optinHiddenInputs = "";
	}


	if ( ! isset( $current_attrs['_thrive_meta_focus_template'] ) || ! isset( $current_attrs['_thrive_meta_focus_template'][0] ) || $current_attrs['_thrive_meta_focus_template'][0] == 'undefined' ) {
		$current_attrs['_thrive_meta_focus_template'][0] = 'custom';
	}
	$current_attrs['_thrive_meta_focus_template'][0] = strtolower( $current_attrs['_thrive_meta_focus_template'][0] );

	$position = "top";

	$base_path = get_template_directory();

	/**
	 * Apply filters to let others load other templates from elsewhere
	 */
	$base_path = apply_filters( 'thrive_focus_preview_template_base_path', $base_path, $current_attrs['_thrive_meta_focus_template'][0] );

	$template_path = $base_path . "/focusareas/" . $current_attrs['_thrive_meta_focus_template'][0] . ".php";
	if ( ! file_exists( $template_path ) ) {
		die;
	}
	require_once $template_path;
	die;
}

add_action( "wp_ajax_nopriv_optin_render_fields", "thrive_optin_render_fields" );
add_action( "wp_ajax_optin_render_fields", "thrive_optin_render_fields" );

function thrive_optin_render_fields() {
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], "thrive_render_fields_nonce" ) ) {
		echo 0;
		die;
	}
	if ( ! isset( $_POST['id_post'] ) || ! isset( $_POST['autoresponder_code'] ) ) {
		echo 0;
		die;
	}
	$current_optin = get_post( $_POST['id_post'] );
	if ( ! $current_optin ) {
		echo 0;
		die;
	}

	$autoresponder_code    = stripslashes( $_POST['autoresponder_code'] );
	$parsed_responder_code = _thrive_parse_autoresponder_code( $autoresponder_code );

	if ( $parsed_responder_code['parse_status'] == 0 || empty( $parsed_responder_code['elements'] ) ) {
		echo 0;
		die;
	}

	//save form action
	update_post_meta( $_POST['id_post'], '_thrive_meta_optin_form_action', $parsed_responder_code['form_action'] );

	//save form method
	update_post_meta( $_POST['id_post'], '_thrive_meta_optin_form_method', $parsed_responder_code['form_method'] );

	//save hidden inputs
	update_post_meta( $_POST['id_post'], '_thrive_meta_optin_hidden_inputs', $parsed_responder_code['hidden_inputs'] );

	//save not visible inputs
	update_post_meta( $_POST['id_post'], '_thrive_meta_optin_not_visible_inputs', $parsed_responder_code['not_visible_inputs'] );


	$optinFieldsJson  = get_post_meta( $_POST['id_post'], '_thrive_meta_optin_fields_array', true );
	$optinFieldsArray = json_decode( $optinFieldsJson, true );

	require_once get_template_directory() . "/inc/templates/admin-optin-render-fields.php";
	die;
}

add_action( "wp_ajax_nopriv_optin_save_field_labels", "thrive_optin_save_field_labels" );
add_action( "wp_ajax_optin_save_field_labels", "thrive_optin_save_field_labels" );

function thrive_optin_save_field_labels() {
	if ( ! wp_verify_nonce( $_REQUEST['nonce'], "thrive_render_fields_nonce" ) ) {
		echo 0;
		die;
	}
	if ( ! isset( $_POST['id_post'] ) || ! isset( $_POST['fieldsArray'] ) ) {
		echo 0;
		die;
	}
	$postID        = (int) $_POST['id_post'];
	$current_optin = get_post( $postID );
	if ( ! $current_optin ) {
		echo 0;
		die;
	}

	if ( ! is_array( $_POST['fieldsArray'] ) ) {
		$thrive_meta_optin_fields = array();
	} else {
		$thrive_meta_optin_fields = $_POST['fieldsArray'];
	}

	$thrive_meta_optin_fields_json = esc_sql( json_encode( $thrive_meta_optin_fields ) );

	update_post_meta( $postID, '_thrive_meta_optin_fields_array', $thrive_meta_optin_fields_json );

	echo 1;
	die;
}

function _thrive_get_meta_fields( $post_type = "post" ) {
	$meta = array();

	switch ( $post_type ) {
		case "post":
			$meta = array(
				'thrive_meta_post_template',
				'thrive_meta_show_post_title',
				'thrive_meta_post_meta_info',
				'thrive_meta_post_breadcrumbs',
				'thrive_meta_post_featured_image',
				'thrive_meta_post_header_scripts',
				'thrive_meta_post_body_scripts',
				'thrive_meta_post_custom_css',
				'thrive_meta_post_focus_area_top',
				'thrive_meta_post_focus_area_bottom',
				'thrive_meta_post_title_bg_type',
				'thrive_meta_post_title_bg_solid_color',
				'thrive_meta_post_title_bg_img_trans',
				'thrive_meta_post_title_bg_overlay_type',
				'thrive_meta_post_title_bg_img_static',
				'thrive_meta_post_title_bg_img_full_height',
				'thrive_meta_post_share_buttons',
				'thrive_meta_show_content_title',
				'thrive_meta_content_title',
				'thrive_meta_post_floating_icons',
				'thrive_meta_social_data_title',
				'thrive_meta_social_data_description',
				'thrive_meta_social_image',
				'thrive_meta_social_twitter_username',
			);
			break;

		case "page":
			$meta = array(
				'thrive_meta_show_post_title',
				'thrive_meta_post_breadcrumbs',
				'thrive_meta_post_featured_image',
				'thrive_meta_post_header_scripts',
				'thrive_meta_post_body_scripts',
				'thrive_meta_post_custom_css',
				'thrive_meta_post_focus_area_top',
				'thrive_meta_post_focus_area_bottom',
				'thrive_meta_post_share_buttons',
				'thrive_meta_post_floating_icons',
				'thrive_meta_post_title_bg_type',
				'thrive_meta_post_title_bg_solid_color',
				'thrive_meta_post_title_bg_img_trans',
				'thrive_meta_post_title_bg_overlay_type',
				'thrive_meta_post_title_bg_img_static',
				'thrive_meta_post_title_bg_img_full_height',
				'thrive_meta_show_content_title',
				'thrive_meta_content_title',
				'thrive_meta_social_data_title',
				'thrive_meta_social_data_description',
				'thrive_meta_social_image',
				'thrive_meta_social_twitter_username',
			);
			break;

		case "focusarea":
			$meta = array(
				'thrive_meta_focus_template',
				'thrive_meta_focus_color',
				'thrive_meta_focus_heading_text',
				'thrive_meta_focus_subheading_text',
				'thrive_meta_focus_button_text',
				'thrive_meta_focus_button_link',
				'thrive_meta_focus_button_color',
				'thrive_meta_focus_new_tab',
				'thrive_meta_focus_spam_text',
				'thrive_meta_focus_image',
				'thrive_meta_focus_image2',
				'thrive_meta_focus_optin',
				'thrive_meta_focus_custom_text',
				'thrive_meta_focus_display_location',
				'thrive_meta_focus_display_post_type',
				'thrive_meta_focus_display_is_default',
				'thrive_meta_focus_display_categories',
				'thrive_meta_focus_display_between_posts',
				'thrive_meta_focus_page_blog',
				'thrive_meta_focus_page_archive'
			);
			break;

		case "optin":
			$meta = array( 'thrive_meta_optin_autoresponder_code' );
			break;

		case "post_formats":
			$meta = array(
				'thrive_meta_postformat_video_type',
				'thrive_meta_postformat_video_youtube_url',
				'thrive_meta_postformat_video_youtube_hide_related',
				'thrive_meta_postformat_video_youtube_hide_logo',
				'thrive_meta_postformat_video_youtube_hide_controls',
				'thrive_meta_postformat_video_youtube_hide_title',
				'thrive_meta_postformat_video_youtube_autoplay',
				'thrive_meta_postformat_video_youtube_hide_fullscreen',
				'thrive_meta_postformat_video_vimeo_url',
				'thrive_meta_postformat_video_custom_url',
				'thrive_meta_postformat_quote_text',
				'thrive_meta_postformat_quote_author',
				'thrive_meta_postformat_audio_type',
				'thrive_meta_postformat_audio_file',
				'thrive_meta_postformat_audio_soundcloud_url',
				'thrive_meta_postformat_audio_soundcloud_autoplay',
				'thrive_meta_postformat_gallery_images',
			);
			break;
	}

	$meta = apply_filters( 'thrive_filter_meta_fields', $meta, $post_type );

	return $meta;
}
