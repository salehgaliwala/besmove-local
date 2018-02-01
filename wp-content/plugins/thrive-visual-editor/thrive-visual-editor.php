<?php

/*
Plugin Name: Thrive Architect
Plugin URI: http://www.thrivethemes.com
Version: 2.0.20
Author: <a href="http://www.thrivethemes.com">Thrive Themes</a>
Description: Live front end editor for your Wordpress content
*/

if ( ! defined( 'TVE_TCB_CORE_INCLUDED' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'plugin-core.php';
}

if ( ! defined( 'TVE_PLUGIN_FILE' ) ) {
	define( 'TVE_PLUGIN_FILE', __FILE__ );
}

/**
 * Classes that should only be available when TCB is used stand-alone
 */
if ( ! class_exists( 'TCB_Post' ) ) {
	/**
	 * Case: TL v1, TCB v2
	 */
	require_once plugin_dir_path( __FILE__ ) . 'inc/classes/class-tcb-post.php';
}
require_once plugin_dir_path( __FILE__ ) . 'inc/classes/class-tcb-lightbox.php';
require_once plugin_dir_path( __FILE__ ) . 'landing-page/inc/class-tcb-landing-page.php';

/**
 * Init the UpdateCheck at init action because
 * Dashboard loads its class at plugins_loaded
 */
add_action( 'init', 'tve_update_checker' );

/**
 * admin licensing menu link
 */
add_action( 'admin_menu', 'tve_add_settings_menu' );

add_action( 'wp_enqueue_scripts', 'tve_frontend_enqueue_scripts' );

// add the same tve_editor_filter but on this case on Landing Page templates - only applies to TCB
add_filter( 'tve_landing_page_content', 'tve_editor_content' );

// add filter for including the TCB meta into the search functionality - this is only required on the TCB editor
add_filter( 'posts_clauses', 'tve_process_search_clauses', null, 2 );

add_filter( 'get_the_content_limit', 'tve_genesis_get_post_excerpt', 10, 4 );

// automatically modify lightbox title if the title of the associated landing page is modified - applies ony to TCB
add_action( 'save_post', 'tve_save_post_callback' );

/* filter that allows adding custom icon packs to the "Choose icon" lightbox in the TCB editor */
add_filter( 'tcb_get_extra_icons', 'tve_landing_page_extra_icon_packs', 10, 2 );

/* filter that allows adding custom fonts to the "choose custom font" menu item */
add_filter( 'tcb_extra_custom_fonts', 'tve_get_extra_custom_fonts', 10, 2 );

/* action that fires when the custom fonts css should be included in the page */
add_action( 'tcb_extra_fonts_css', 'tve_output_extra_custom_fonts_css' );

/** fires when all plugins are loaded - used for intermediate filter setup / plugin overrides */
add_action( 'plugins_loaded', 'tve_plugins_loaded_hook' );

//after the plugin is loaded load the dashboard version file
add_action( 'plugins_loaded', 'tve_load_dash_version' );

/**
 * TCB-specific AJAX actions
 */
add_action( 'wp_ajax_tve_lp_export', 'tve_ajax_landing_page_export' );
add_action( 'wp_ajax_tve_lp_import', 'tve_ajax_landing_page_import' );
add_action( 'wp_ajax_tve_cloud_templates', 'tve_ajax_landing_page_cloud' );

/**
 * AJAX call to return the TCB-added content for a post
 */
add_action( 'wp_ajax_get_tcb_content', 'tve_ajax_yoast_tcb_post_content' );

add_action( 'wp_head', 'tve_load_custom_css', 100, 0 );

if ( ! function_exists( 'tve_editor_url' ) ) {
	/**
	 * @return string the absolute url to this plugin's folder
	 *
	 * @param string $file optional, a path inside the plugin folder
	 */
	function tve_editor_url( $file = null ) {
		return rtrim( plugin_dir_url( __FILE__ ) . ( null !== $file ? ltrim( $file, '/\\' ) : '' ), '/' );
	}
}

if ( is_admin() ) {
	require_once( 'admin/class-tcb-admin.php' );
}

/**
 * output the admin license validation page
 */
function tve_license_validation() {
	include( 'tve_settings.php' );
}

/**
 * add the options link to the admin menu
 */
function tve_add_settings_menu() {
	add_submenu_page( false, '', '', 'manage_options', 'tve_license_validation', 'tve_license_validation' );
}

/**
 * include the TCB saved meta into query search fields
 *
 * wordpress actually allows inserting post META fields in the search query,
 * but it will always build the clauses with AND (between post content and post meta) e.g.:
 *  WHERE (posts.title LIKE '%xx%' OR posts.post_content) AND (postsmeta.meta_key = 'tve_save_post' AND postsmeta.meta_value LIKE '%xx%')
 *
 * - we cannot use this, so we hook into the final pieces of the built SQL query - we need a solution like this:
 *  WHERE ( (posts.title LIKE '%xx%' OR posts.post_content OR (postsmeta.meta_key = 'tve_save_post' AND postsmeta.meta_value LIKE '%xx%') )
 *
 * @param array    $pieces
 * @param WP_Query $wpQuery
 *
 * @return array
 */
function tve_process_search_clauses( $pieces, $wpQuery ) {
	if ( is_admin() || empty( $pieces ) || ! $wpQuery->is_search() ) {
		return $pieces;
	}
	/** @var wpdb $wpdb */
	global $wpdb;

	$query = '';
	$n     = ! empty( $q['exact'] ) ? '' : '%';
	$q     = $wpQuery->query_vars;
	if ( ! empty( $q['search_terms'] ) ) {
		foreach ( $q['search_terms'] as $term ) {
			if ( method_exists( $wpdb, 'esc_like' ) ) { // WP4
				$term = $wpdb->esc_like( $term );
			} else {
				$term = like_escape( $term ); // like escape is deprecated in WP4
			}

			$like  = $n . $term . $n;
			$query .= "((tve_pm.meta_key = 'tve_updated_post')";
			$query .= $wpdb->prepare( " AND (tve_pm.meta_value LIKE %s)) OR ", $like );
		}
	}

	if ( ! empty( $query ) ) {
		// add to where clause
		$pieces['where'] = str_replace( "((({$wpdb->posts}.post_title LIKE '{$n}", "( {$query} (({$wpdb->posts}.post_title LIKE '{$n}", $pieces['where'] );

		$pieces['join'] = $pieces['join'] . " LEFT JOIN {$wpdb->postmeta} AS tve_pm ON ({$wpdb->posts}.ID = tve_pm.post_id)";

		if ( empty( $pieces['groupby'] ) ) {
			$pieces['groupby'] = "{$wpdb->posts}.ID";
		}
	}

	return ( $pieces );
}

/**
 * Handler for "get_the_content_limit" action applied by genesis themes
 *
 * Called on pages with posts list
 * If posts was created with TCB the more_element link is searched. If it is found the content before it is returned.
 * If more_element is not found the post's content added from admin is appended with TCB content then truncation is applied
 *
 * @param string $output         Truncated content post by genesis
 * @param string $content        the stripped and truncated genesis content
 * @param string $link           the read more link
 * @param int    $max_characters the maximum number of characters to truncate to
 *
 * @return string $content
 */
function tve_genesis_get_post_excerpt( $output, $content, $link, $max_characters ) {
	global $post;
	$post_id = get_the_ID();

	if ( ! tve_check_in_loop( $post_id ) ) {
		tve_load_custom_css( $post_id );
	}

	if ( ! is_singular() ) {
		$more_found          = tve_get_post_meta( get_the_ID(), "tve_content_more_found", true );
		$content_before_more = tve_get_post_meta( get_the_ID(), "tve_content_before_more", true );
		if ( ! empty( $content_before_more ) && $more_found ) {
			$more_link = apply_filters( 'the_content_more_link', '<a href="' . get_permalink() . '#more-' . $post->ID . '" class="more-link">Continue Reading</a>', 'Continue Reading' );
			$content   = "<div id='tve_editor' class='tve_shortcode_editor'>" .
			             stripslashes( $content_before_more ) .
			             $more_link .
			             "</div>";

			return tve_restore_script_tags( $content );
		}

		$tcb_content = tve_restore_script_tags( stripslashes( tve_get_post_meta( get_the_ID(), "tve_updated_post", true ) ) );
		if ( ! $tcb_content ) {
			return $output;
		}

		/**
		 * inherited from genesis logic
		 */
		$tcb_content = strip_tags( strip_shortcodes( $tcb_content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		$tcb_content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $tcb_content ) );

		// append the original genesis content
		$tcb_content .= $content;
		$tcb_content = genesis_truncate_phrase( $tcb_content, $max_characters );
		$tcb_content = sprintf( '<p>%s %s</p>', $tcb_content, $link );

		return $tcb_content;
	}

	return $output;
}

/**
 * render all necessary things for page-level event manager
 *
 * @param $events
 */
function tve_page_events( $events ) {
	$triggers = tve_get_event_triggers( 'page' );
	$actions  = tve_get_event_actions( 'page' );

	/* hold all the javascript callbacks required for the identified actions */
	$javascript_callbacks = isset( $GLOBALS['tve_event_manager_callbacks'] ) ? $GLOBALS['tve_event_manager_callbacks'] : array();

	/* holds all the Global JS required by different actions and event triggers on page load */
	$registered_javascript_globals = isset( $GLOBALS['tve_event_manager_global_js'] ) ? $GLOBALS['tve_event_manager_global_js'] : array();

	/* hold all instances of the Action classes in order to output stuff in the footer, we need to get out of the_content filter */
	$registered_actions = isset( $GLOBALS['tve_event_manager_actions'] ) ? $GLOBALS['tve_event_manager_actions'] : array();

	/* each trigger instance might also need a bit of javascript to trigger it */
	$registered_triggers = isset( $GLOBALS['tve_event_manager_triggers'] ) ? $GLOBALS['tve_event_manager_triggers'] : array();

	/*
	 * all page level events
	 */
	foreach ( $events as $index => $event_config ) {
		if ( empty( $event_config['t'] ) || empty( $event_config['a'] ) || ! isset( $triggers[ $event_config['t'] ] ) || ! isset( $actions[ $event_config['a'] ] ) ) {
			continue;
		}
		/** @var TCB_Event_Action_Abstract $action */
		$action                = $actions[ $event_config['a'] ];
		$registered_actions [] = array(
			'class'        => $action,
			'event_config' => $event_config,
		);

		/** @var TCB_Event_Trigger_Abstract $trigger */
		$trigger                = $triggers[ $event_config['t'] ];
		$registered_triggers [] = array(
			'class'        => $trigger,
			'event_config' => $event_config,
		);

		if ( ! isset( $javascript_callbacks[ $event_config['a'] ] ) ) {
			$javascript_callbacks[ $event_config['a'] ] = $action->getJsActionCallback();
		}
		if ( ! isset( $registered_javascript_globals[ 'action_' . $event_config['a'] ] ) ) {
			$registered_javascript_globals[ 'action_' . $event_config['a'] ] = $action;
		}
		if ( ! isset( $registered_javascript_globals[ 'trigger_' . $event_config['t'] ] ) ) {
			$registered_javascript_globals[ 'trigger_' . $event_config['t'] ] = $trigger;
		}
	}

	if ( empty( $javascript_callbacks ) ) {
		return;
	}

	/* we need to add all the javascript callbacks into the page */
	/* this cannot be done using wp_localize_script WP function, as each if the callback will actually be JS code */
	///euuuughhh

	//TODO: how could we handle this in a more elegant fashion ?
	$GLOBALS['tve_event_manager_callbacks'] = $javascript_callbacks;
	$GLOBALS['tve_event_manager_global_js'] = $registered_javascript_globals;
	$GLOBALS['tve_event_manager_actions']   = $registered_actions;
	$GLOBALS['tve_event_manager_triggers']  = $registered_triggers;

	/* execute the mainPostCallback on all of the related actions, some of them might need to register stuff (e.g. lightboxes) */
	foreach ( $GLOBALS['tve_event_manager_actions'] as $key => $item ) {
		if ( empty( $item['main_post_callback_'] ) ) {
			$GLOBALS['tve_event_manager_actions'][ $key ]['main_post_callback_'] = true;
			$item['class']->mainPostCallback( $item['event_config'] );
		}
	}

	/* remove previously assigned callback, if any */
	remove_action( 'wp_print_footer_scripts', 'tve_print_footer_events' );
	add_action( 'wp_print_footer_scripts', 'tve_print_footer_events' );
}

/**
 * When a page is edited from admin -> we need to use the same title for the associated lightbox, if the page in question is a landing page
 * Copy post tve meta to revision meta
 *
 * This method is also called when a revision of a post is added
 *
 * @see wp_insert_post which is doing: "post_updated", "save_post"
 * @see defaults-filters.php for add_action("post_updated")
 *
 * @param $post_id
 */
function tve_save_post_callback( $post_id ) {
	/**
	 * If $post_id is an ID of a revision POST
	 */
	if ( $parent_id = wp_is_post_revision( $post_id ) ) {

		$meta_keys = tve_get_used_meta_keys();

		/**
		 * copy post metas to its revision
		 */
		foreach ( $meta_keys as $meta_key ) {
			if ( $meta_key === 'tve_landing_page' ) {
				$meta_value = get_post_meta( $parent_id, $meta_key, true );
			} else {
				$meta_value = tve_get_post_meta( $parent_id, $meta_key );
			}
			add_metadata( 'post', $post_id, 'tve_revision_' . $meta_key, $meta_value );
		}
	}

	$post_type = get_post_type( $post_id );
	if ( $post_type != 'page' ) {
		return;
	}
	$is_landing_page = tve_post_is_landing_page( $post_id );
	$tve_globals     = tve_get_post_meta( $post_id, 'tve_globals' );

	if ( ! $is_landing_page || empty( $tve_globals['lightbox_id'] ) ) {
		return;
	}
	$lightbox = get_post( $tve_globals['lightbox_id'] );
	if ( ! $lightbox ) {
		return;
	}

	wp_update_post( array(
		'ID'         => $tve_globals['lightbox_id'],
		'post_title' => 'Lightbox - ' . get_the_title( $post_id )
	) );
}


/**
 * integration with Wordpress SEO for page analysis.
 *
 * @param string $content WP post_content
 *
 * @return string $content
 */
function tve_yoast_seo_integration( $content ) {
	$post_id = get_the_ID();
	if ( $post_id && ! tve_is_post_type_editable( get_post_type( $post_id ) ) ) {
		return $content;
	}

	/**
	 * if the post is actually a Landing Page, we need to reset all previously saved content, as TCB content is the only one shown
	 */
	if ( $lp_template = tve_post_is_landing_page( $post_id ) ) {
		$content = '';
	}

	$tve_saved_content = tve_get_post_meta( get_the_ID(), "tve_updated_post" );

	$tve_saved_content = preg_replace( '#<p(.*?)>(.*?)</p>#s', '<p>$2</p>', $tve_saved_content );
	$tve_saved_content = str_replace( '<p></p>', '', $tve_saved_content );

	$content = $tve_saved_content . " " . $content;

	return $content;
}

/**
 * add TCB content images to the sitemap
 *
 * @param array $images
 * @param       $post_id
 *
 * @return array
 */
function tve_yoast_sitemap_images( $images, $post_id ) {
	$post_type = get_post_type( $post_id );
	$p         = get_post( $post_id );

	if ( ! tve_is_post_type_editable( $post_type, $post_id ) ) {
		return $images;
	}
	$home_url    = home_url();
	$parsed_home = parse_url( $home_url );
	$host        = '';
	$scheme      = 'http';
	if ( isset( $parsed_home['host'] ) && ! empty( $parsed_home['host'] ) ) {
		$host = str_replace( 'www.', '', $parsed_home['host'] );
	}
	if ( isset( $parsed_home['scheme'] ) && ! empty( $parsed_home['scheme'] ) ) {
		$scheme = $parsed_home['scheme'];
	}

	/**
	 * if the post is actually a Landing Page, we need to reset all other images and return just the ones setup in the landing page
	 */
	if ( $lp_template = tve_post_is_landing_page( $post_id ) ) {
		$images = array();
	}
	$content = tve_get_post_meta( $post_id, 'tve_updated_post' );

	if ( preg_match_all( '`<img [^>]+>`', $content, $matches ) ) {

		foreach ( $matches[0] as $img ) {
			if ( preg_match( '`src=["\']([^"\']+)["\']`', $img, $match ) ) {
				$src = $match[1];
				if ( WPSEO_Utils::is_url_relative( $src ) === true ) {
					if ( $src[0] !== '/' ) {
						continue;
					} else {
						// The URL is relative, we'll have to make it absolute
						$src = $home_url . $src;
					}
				} elseif ( strpos( $src, 'http' ) !== 0 ) {
					// Protocol relative url, we add the scheme as the standard requires a protocol
					$src = $scheme . ':' . $src;

				}

				if ( strpos( $src, $host ) === false ) {
					continue;
				}

				if ( $src != esc_url( $src ) ) {
					continue;
				}

				$image = array(
					'src' => apply_filters( 'wpseo_xml_sitemap_img_src', $src, $p )
				);

				if ( preg_match( '`title=["\']([^"\']+)["\']`', $img, $title_match ) ) {
					$image['title'] = str_replace( array( '-', '_' ), ' ', $title_match[1] );
				}
				unset( $title_match );

				if ( preg_match( '`alt=["\']([^"\']+)["\']`', $img, $alt_match ) ) {
					$image['alt'] = str_replace( array( '-', '_' ), ' ', $alt_match[1] );
				}
				unset( $alt_match );

				$image    = apply_filters( 'wpseo_xml_sitemap_img', $image, $p );
				$images[] = $image;
			}
			unset( $match, $src );
		}
	}

	return $images;
}

/**
 * export a Landing Page as a Zip file
 */
function tve_ajax_landing_page_export() {
	$response = array(
		'success' => true,
	);

	if ( empty( $_POST['template_name'] ) || empty( $_POST['post_id'] ) || ! is_numeric( $_POST['post_id'] ) || ! tve_post_is_landing_page( $_POST['post_id'] ) ) {
		$response['success'] = false;
		$response['message'] = __( 'Invalid request', 'thrive-cb' );
		wp_send_json( $response );
	}

	$transfer = new TCB_Landing_Page_Transfer();

	$thumb_attachment_id = empty( $_POST['thumb_id'] ) ? 0 : (int) $_POST['thumb_id'];

	try {

		$data                = $transfer->export( (int) $_POST['post_id'], $_POST['template_name'], $thumb_attachment_id );
		$response['url']     = $data['url'];
		$response['message'] = __( 'Landing Page exported successfully!', 'thrive-cb' );

	} catch ( Exception $e ) {
		$response['success'] = false;
		$response['message'] = $e->getMessage();
	}

	wp_send_json( $response );
}

/**
 * import a landing page from an attachment ID received in POST
 * the attachment should be a .zip file created with the "Export Landing Page" functionality
 */
function tve_ajax_landing_page_import() {
	$response = array(
		'success' => true,
		'message' => '',
	);

	if ( empty( $_POST['attachment_id'] ) || ! is_numeric( $_POST['attachment_id'] ) || empty( $_POST['page_id'] ) || ! is_numeric( $_POST['page_id'] ) || get_post_type( $_POST['page_id'] ) != 'page' ) {
		$response['success'] = false;
		$response['message'] = __( 'Invalid attachment id', 'thrive-cb' );
		wp_send_json( $response );
	}

	$transfer = new TCB_Landing_Page_Transfer();
	try {

		$landing_page_id     = $transfer->import( (int) $_POST['attachment_id'], (int) $_POST['page_id'] );
		$response['url']     = tcb_get_editor_url( $landing_page_id );
		$response['message'] = __( 'Landing Page imported successfully!', 'thrive-cb' );

	} catch ( Exception $e ) {
		$response['success'] = false;
		$response['message'] = $e->getMessage();
	}

	wp_send_json( $response );
}

/**
 * checks if any extra icons are attached to the page, and include those also the $icons array
 *
 * @param array $icons
 * @param int   $post_id
 *
 * @return array
 */
function tve_landing_page_extra_icon_packs( $icons, $post_id ) {
	if ( empty( $post_id ) ) {
		return $icons;
	}

	$globals = tve_get_post_meta( $post_id, 'tve_globals' );

	if ( empty( $globals['extra_icons'] ) ) {
		return $icons;
	}

	foreach ( $globals['extra_icons'] as $icon_pack ) {
		$icons = array_merge( $icons, $icon_pack['icons'] );
	}

	return $icons;

}

/**
 *
 * check if the current post / page has extra custom fonts associated and output the css needed for each
 * the extra custom fonts are enqueued from tve_enqueue_extra_resources()
 *
 * @param int $post_id
 *
 * @see tve_enqueue_extra_resources
 *
 */
function tve_output_extra_custom_fonts_css( $post_id = null ) {
	$fonts = apply_filters( 'tcb_extra_custom_fonts', array(), $post_id );

	if ( empty( $fonts ) ) {
		return;
	}

	tve_output_custom_font_css( $fonts );

}

/**
 *
 * action filter that adds the custom fonts to the $fonts array for a landing page / lightbox
 *
 * @param      $fonts
 * @param null $post_id
 *
 * @return array
 */
function tve_get_extra_custom_fonts( $fonts, $post_id = null ) {
	if ( empty( $post_id ) ) {
		$post_id = get_the_ID();
	}

	if ( empty( $post_id ) ) {
		return $fonts;
	}
	$globals = tve_get_post_meta( $post_id, 'tve_globals' );
	if ( empty( $globals['extra_fonts'] ) ) {
		return $fonts;
	}

	return array_merge( $fonts, $globals['extra_fonts'] );
}

/**
 * called on the 'plugins_loaded' hook
 */
function tve_plugins_loaded_hook() {
	if ( defined( 'WPSEO_VERSION' ) ) {
		// integration with YOAST SEO
		/* version 3 removed this filter completely - this is handled from javascript from version 3.0 onwards */
		if ( version_compare( WPSEO_VERSION, '3.0', '<' ) === true ) {
			add_filter( 'wpseo_pre_analysis_post_content', 'tve_yoast_seo_integration' );
		} else {
			/* this is handled from javascript */
		}

		// YOAST sitemaps - add image links
		add_filter( 'wpseo_sitemap_urlimages', 'tve_yoast_sitemap_images', 10, 2 );
	}

}

/**
 * sends an ajax response containing the TCB-saved post content, stripped of tags for yoast SEO integration
 *
 * @return void
 */
function tve_ajax_yoast_tcb_post_content() {
	$id = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );

	/**
	 * mimic the the_content filter on the post - this will return all TCB content
	 */
	global $post;
	$post = get_post( $id );

	$wp_content = $post->post_content;

	/* used ob_start to avoid any output generated by tve_editor_content) */
	ob_start();
	$tcb_content = tve_editor_content( $post->post_content, 'tcb_content' );
	ob_end_clean();

	$tcb_post = tcb_post( $post );
	if ( $tcb_post->meta( 'tcb2_ready' ) ) {
		if ( $tcb_post->meta( 'tcb_editor_enabled' ) ) {
			$wp_content = '';
		} elseif ( $tcb_post->meta( 'tcb_editor_disabled' ) ) {
			$tcb_content = '';
		}
	}

	wp_send_json( array(
		'post_id' => $post->ID,
		'content' => $tcb_content . $wp_content,
	) );
}

/**
 * main entry-point for Landing Pages stored in the cloud - get all, download etc
 */
function tve_ajax_landing_page_cloud() {
	if ( empty( $_POST['task'] ) ) {
		$error = __( 'Invalid request', 'thrive-cb' );
	}

	if ( ! isset( $error ) ) {

		try {
			switch ( $_POST['task'] ) {
				case 'download':
					$template = isset( $_POST['template'] ) ? $_POST['template'] : '';
					$post_id  = isset( $_POST['post_id'] ) ? $_POST['post_id'] : '';
					if ( empty( $template ) ) {
						throw new Exception( __( 'Invalid template', 'thrive-cb' ) );
					}
					$force_download = defined( 'TCB_CLOUD_DEBUG' ) && TCB_CLOUD_DEBUG;
					if ( ! $force_download ) {
						$transient_name = 'tcb_template_download_' . $template;
						if ( get_transient( $transient_name ) === false ) {
							$force_download = true;
							set_transient( $transient_name, 1, DAY_IN_SECONDS );
						}
					}
					$downloaded = tve_get_downloaded_templates();

					if ( $force_download || ! array_key_exists( $template, $downloaded ) || tve_get_landing_page_config( $template ) === false ) {
						/**
						 * this will throw Exception if anything goes wrong
						 */
						TCB_Landing_Page_Cloud_Templates_Api::getInstance()->download( $template, 2 );
					}

					tcb_landing_page( $post_id )->set_cloud_template( $template );

					wp_send_json( array(
						'success' => true,
					) );
			}
		} catch ( Exception $e ) {
			wp_send_json( array(
				'success' => false,
				'message' => $e->getMessage(),
			) );
		}
	}

	wp_die();
}

/**
 * get a list of templates from the cloud
 * search first in a local wp_option (to avoid making too many requests to the templates server)
 * cache the results for a set period of time
 *
 * default cache interval: 8h
 *
 * @return array
 */
function tve_get_cloud_templates() {
	$transient_name = 'tcb_cloud_cache';

	if ( defined( 'TCB_CLOUD_DEBUG' ) && TCB_CLOUD_DEBUG ) {
		delete_transient( $transient_name );
	}

	$cache_for = apply_filters( 'tcb_cloud_cache', 3600 * 8 );

	if ( false === ( $templates = get_transient( $transient_name ) ) ) {

		try {
			$templates = TCB_Landing_Page_Cloud_Templates_Api::getInstance()->getTemplateList();
			set_transient( $transient_name, $templates, $cache_for );
		} catch ( Exception $e ) {
			/* save the error message to display it in the LP modal */
			$GLOBALS['tcb_lp_cloud_error'] = $e->getMessage();
			$templates                     = array();
		}
	}

	return $templates;
}

/**
 * get a list of all landing page templates downloaded from the cloud
 *
 * @return array
 */
function tve_get_downloaded_templates() {
	$options = get_option( 'thrive_tcb_download_lp', array() );

	return ( $options ) ? $options : array();
}


/**
 * save the list of downloaded templates into the wp_option used for these
 *
 * @param array $templates
 */
function tve_save_downloaded_templates( $templates ) {
	update_option( 'thrive_tcb_download_lp', $templates );
}

/**
 * check if a landing page template is originating from the cloud (has been downloaded previously)
 *
 * @param string $lp_template
 *
 * @return bool
 */
function tve_is_cloud_template( $lp_template ) {
	if ( ! $lp_template ) {
		return false;
	}
	$templates = tve_get_downloaded_templates();

	return array_key_exists( $lp_template, $templates );
}

/**
 * get the configuration stored in the wp_option table for this template (this only applies to templates downloaded from the cloud)
 * if $validate === true => also perform validations of the files (ensure the required files exist in the uploads folder)
 *
 * @param string $lp_template
 * @param bool   $validate if true, causes the configuration to be validated
 *
 * @return array|bool false in case there is something wrong (missing files, invalid template name etc)
 */
function tve_get_cloud_template_config( $lp_template, $validate = true ) {
	$templates = tve_get_downloaded_templates();
	if ( ! isset( $templates[ $lp_template ] ) ) {
		return false;
	}

	$config          = $templates[ $lp_template ];
	$config['cloud'] = true;

	/**
	 * skip the validation process if $validate is falsy
	 */
	if ( ! $validate ) {
		return $config;
	}

	$base_folder = tcb_get_cloud_base_path();

	$required_files = array(
		'templates/' . $lp_template . '.tpl', // html contents
		'templates/css/' . $lp_template . '.css', // css file
	);

	foreach ( $required_files as $file ) {
		if ( ! is_readable( $base_folder . $file ) ) {
			unset( $templates[ $lp_template ] );
			tve_save_downloaded_templates( $templates );

			return false;
		}
	}

	return $config;
}

/**
 * resets all stored metadata for downloaded templates
 * this can be used if some of the template files have been deleted
 */
function tve_reset_cloud_templates_meta() {
	tve_save_downloaded_templates( array() );
}

/**
 * Just initialize the PluginUpdateChecker included from dash
 */
function tve_update_checker() {
	/** plugin updates script **/
	new TVE_PluginUpdateChecker(
		'http://service-api.thrivethemes.com/plugin/update',
		__FILE__,
		'thrive-visual-editor',
		12,
		'',
		'content_builder'
	);
}
