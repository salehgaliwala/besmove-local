<?php

/*
 * Render the theme options page
 */

function thrive_page_templates_admin_page() {
	$page_templates       = array(
		'page_tpl_privacy',
		'page_tpl_disclaimer',
		'page_tpl_lead_generation_video_page',
		'page_tpl_lead_generation_page',
		'page_tpl_download_page',
		'page_tpl_email_confirmation_page',
		'page_tpl_homepage',
		'page_tpl_sales_page'
	);
	$test_posts_generated = false;
	//GENERATE 6 TEST POSTS
	if ( $_SERVER['REQUEST_METHOD'] === "POST" && isset( $_POST['thrive_generate_test_posts'] ) && $_POST['thrive_generate_test_posts'] == 1 ) {
		require( get_template_directory() . "/inc/helpers/helper-tpls.php" );
		$test_post_content = _thrive_get_lorem_ipsum_post_content();
		$new_post_author   = thrive_get_current_user();
		for ( $index = 0; $index < 6; $index ++ ) {
			$my_post                   = array();
			$my_post['post_title']     = "Test post " . ( $index + 1 );
			$my_post['post_content']   = $test_post_content;
			$my_post['post_status']    = 'publish';
			$my_post['post_author']    = $new_post_author->ID;
			$my_post['post_category']  = array( 0 );
			$my_post['post_type']      = 'post';
			$my_post['comment_status'] = "open";
			$post_id                   = wp_insert_post( $my_post );
			if ( ! $post_id ) {
				require( get_template_directory() . "/inc/templates/admin-page-templates.php" );
				exit;
			}
			$featured_img_name = "post" . ( $index + 1 ) . ".jpg";
			$featured_img_path = get_template_directory() . "/images/templates/" . $featured_img_name;
			$featured_img_url  = get_template_directory_uri() . "/images/templates/" . $featured_img_name;

			//_thrive_insert_post_featured_image($featured_img_name, $featured_img_path, $post_id);

			_thrive_insert_post_featured_img( $featured_img_url, $post_id );
		}

		$test_posts_generated = true;
		$queryOptins          = new WP_Query( "post_type=thrive_optin&order=ASC&post_status=publish" );
		$optins               = $queryOptins->get_posts();
		require( get_template_directory() . "/inc/templates/admin-page-templates.php" );
	} //GENERATE THE PAGE TEMPLATES
	elseif ( $_SERVER['REQUEST_METHOD'] === "POST" ) {
		require( get_template_directory() . "/inc/helpers/helper-tpls.php" );
		$new_post_author = thrive_get_current_user();
		$post_data       = $_POST;
		$optin_id        = ( isset( $_POST['thrive_optin'] ) ) ? $_POST['thrive_optin'] : 0;
		foreach ( $post_data as $key => $val ) {
			if ( in_array( $key, $page_templates ) ) {
				$my_post               = array();
				$my_post['post_title'] = _thrive_get_page_template_title( $key );

				if ( isset( $_POST['editable_with_tcb'] ) && $_POST['editable_with_tcb'] == 1 && defined( "TVE_VERSION" ) ) {
					$my_post['post_content'] = "";
				} else {
					$my_post['post_content'] = _thrive_generate_page_template_content( $key, $optin_id );
				}

				$my_post['post_status']    = 'publish';
				$my_post['post_author']    = $new_post_author->ID;
				$my_post['post_category']  = array( 0 );
				$my_post['post_type']      = 'page';
				$my_post['comment_status'] = "closed";
				$post_id                   = wp_insert_post( $my_post );

				if ( isset( $_POST['editable_with_tcb'] ) && $_POST['editable_with_tcb'] == 1 && defined( "TVE_VERSION" ) ) {
					$tcb_content = _thrive_generate_page_template_tcb_content( $key, $optin_id );
					update_post_meta( $post_id, "tve_updated_post", $tcb_content );
					update_post_meta( $post_id, "tve_save_post", $tcb_content );
					update_post_meta( $post_id, 'tve_style_family', "Flat" );

				}
				if ( ! $post_id ) {
					require( get_template_directory() . "/inc/templates/admin-page-templates.php" );
					exit;
				}
				//set up the other options
				switch ( $key ) {
					case 'page_tpl_lead_generation_video_page':
					case 'page_tpl_lead_generation_page':
					case 'page_tpl_download_page':
					case 'page_tpl_email_confirmation_page':
						add_post_meta( $post_id, '_thrive_meta_post_focus_area_top', "hide", true ) or
						update_post_meta( $post_id, '_thrive_meta_post_focus_area_top', "hide" );
						update_post_meta( $post_id, '_wp_page_template', 'landing-page.php' );
						add_post_meta( $post_id, '_thrive_meta_show_post_title', 0, true ) or
						update_post_meta( $post_id, '_thrive_meta_show_post_title', 0 );
						add_post_meta( $post_id, '_thrive_meta_post_breadcrumbs', "off", true ) or
						update_post_meta( $post_id, '_thrive_meta_post_breadcrumbs', "off" );
						add_post_meta( $post_id, '_thrive_meta_show_content_title', 1, true ) or
						update_post_meta( $post_id, '_thrive_meta_show_content_title', 1 );
						add_post_meta( $post_id, '_thrive_meta_content_title', _thrive_generate_page_template_content( $key, $optin_id, true ), true ) or
						update_post_meta( $post_id, '_thrive_meta_content_title', _thrive_generate_page_template_content( $key, $optin_id, true ) );
						break;

					case 'page_tpl_homepage':
					case 'page_tpl_sales_page':
						add_post_meta( $post_id, '_thrive_meta_post_focus_area_top', "hide", true ) or
						update_post_meta( $post_id, '_thrive_meta_post_focus_area_top', "hide" );
						update_post_meta( $post_id, '_wp_page_template', 'fullwidth-page.php' );
						add_post_meta( $post_id, '_thrive_meta_show_post_title', 0, true ) or
						update_post_meta( $post_id, '_thrive_meta_show_post_title', 0 );
						add_post_meta( $post_id, '_thrive_meta_post_breadcrumbs', "off", true ) or
						update_post_meta( $post_id, '_thrive_meta_post_breadcrumbs', "off" );
						add_post_meta( $post_id, '_thrive_meta_show_content_title', 1, true ) or
						update_post_meta( $post_id, '_thrive_meta_show_content_title', 1 );
						add_post_meta( $post_id, '_thrive_meta_content_title', _thrive_generate_page_template_content( $key, $optin_id, true ), true ) or
						update_post_meta( $post_id, '_thrive_meta_content_title', _thrive_generate_page_template_content( $key, $optin_id, true ) );
						break;

					case 'page_tpl_privacy':
					case 'page_tpl_disclaimer':
						update_post_meta( $post_id, '_wp_page_template', 'narrow-page.php' );
						add_post_meta( $post_id, '_thrive_meta_post_focus_area_top', "hide", true ) or
						update_post_meta( $post_id, '_thrive_meta_post_focus_area_top', "hide" );

						add_post_meta( $post_id, '_thrive_meta_post_focus_area_bottom', "hide", true ) or
						update_post_meta( $post_id, '_thrive_meta_post_focus_area_bottom', "hide" );
						break;

				}
			}
		}
		wp_redirect( admin_url( 'edit.php?post_type=page&orderby=date&order=desc' ) );
		exit;
	} else {
		$queryOptins = new WP_Query( "post_type=thrive_optin&order=ASC&post_status=publish" );
		$optins      = $queryOptins->get_posts();
		require( get_template_directory() . "/inc/templates/admin-page-templates.php" );
	}
}

function _thrive_get_page_template_title( $template ) {
	switch ( $template ) {
		case 'page_tpl_lead_generation_video_page':
			return "Lead Generation Video Page";
			break;
		case 'page_tpl_lead_generation_page':
			return "Lead Generation Page";
			break;
		case 'page_tpl_download_page':
			return "Download Page";
			break;
		case 'page_tpl_email_confirmation_page':
			return "Email Confirmation Page";
			break;
		case 'page_tpl_sales_page':
			return "Sales Page";
			break;
		case 'page_tpl_homepage':
			return "Homepage";
			break;
		case 'page_tpl_privacy':
			return "Privacy Policy";
			break;
		case 'page_tpl_disclaimer':
			return "Disclaimer";
			break;
		default:
			return "Page Template";
	}
}

function _thrive_generate_page_template_content( $template, $optin_id = 0, $top_section = false ) {
	if ( $template == "page_tpl_privacy" ) {
		$privacy_options = array(
			'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
			'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
			'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
			'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
		);
	}

	array(
		'page_tpl_lead_generation_video_page',
		'page_tpl_lead_generation_page',
		'page_tpl_download_page',
		'page_tpl_email_confirmation_page',
		'page_tpl_homepage',
		'page_tpl_sales_page'
	);
	switch ( $template ) {
		case 'page_tpl_lead_generation_page':
			return _thrive_get_page_template_lead_gen( $optin_id );
			break;
		case 'page_tpl_download_page':
			return _thrive_get_page_template_download_page();
			break;
		case 'page_tpl_sales_page':
			return _thrive_get_page_template_sales();
			break;
		case 'page_tpl_lead_generation_video_page':
			return _thrive_get_page_template_video_lead_gen( $optin_id );
			break;
		case 'page_tpl_email_confirmation_page':
			return _thrive_get_page_template_email_confirmation();
			break;
		case 'page_tpl_homepage':
			return _thrive_get_page_template_homepage( $optin_id );
			break;
		case 'page_tpl_privacy':
			return _thrive_get_page_template_privacy();
			break;
		case 'page_tpl_disclaimer':
			return _thrive_get_page_template_disclaimer();
			break;
		default:
			return "";
	}

}

function _thrive_generate_page_template_tcb_content( $template, $optin_id = 0 ) {
	if ( $template == "page_tpl_privacy" ) {
		$privacy_options = array(
			'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
			'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
			'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
			'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
		);
	}
	switch ( $template ) {
		case 'page_tpl_lead_generation_page':
			return _thrive_get_page_template_tcb_lead_gen( $optin_id );
			break;
		case 'page_tpl_download_page':
			return _thrive_get_page_template_tcb_download_page();
			break;
		case 'page_tpl_sales_page':
			return _thrive_get_page_template_tcb_sales();
			break;
		case 'page_tpl_lead_generation_video_page':
			return _thrive_get_page_template_tcb_video_lead_gen( $optin_id );
			break;
		case 'page_tpl_email_confirmation_page':
			return _thrive_get_page_template_tcb_email_confirmation();
			break;
		case 'page_tpl_homepage':
			return _thrive_get_page_template_tcb_homepage( $optin_id );
			break;
		case 'page_tpl_privacy':
			return _thrive_get_page_template_tcb_privacy();
			break;
		case 'page_tpl_disclaimer':
			return _thrive_get_page_template_tcb_disclaimer();
			break;
		default:
			return "";
	}

}

?>