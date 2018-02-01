<?php
add_filter( 'auto_update_theme', '__return_true' );
add_filter( 'previous_comments_link_attributes', 'thrive_get_previous_comments_link_attributes' );
add_filter( 'next_comments_link_attributes', 'thrive_get_next_comments_link_attributes' );
/*
 * Set up a global variable in order to know that this is a thrive theme
 */
global $is_thrive_theme;
$is_thrive_theme = true;
/*
 * Include the init file that handles the main configurations and the backend 
 * methods
 */
include( get_template_directory() . '/inc/configs/init.php' );

include( get_template_directory() . "/inc/configs/theme-options.php" );

include( get_template_directory() . '/inc/tha-theme-hooks.php' );

include( get_template_directory() . '/inc/thrive-image-optimization.php' );

include( get_template_directory() . '/inc/templates/custom-menu-walker.php' );

include( get_template_directory() . '/inc/helpers/views.php' );

include( get_template_directory() . '/inc/dashboard/init.php' );

require( get_template_directory() . "/inc/theme-options.php" );

/*
 * Render the breadcrumbs
 */
if ( ! function_exists( 'thrive_breadcrumbs' ) ) :
	function thrive_breadcrumbs() {

		global $post;

		if ( is_404() ) {
			return;
		}

		$arrowImg = "&nbsp;»";


		if ( get_option( 'show_on_front' ) == 'page' ) {
			$posts_page_id  = get_option( 'page_for_posts' );
			$posts_page_url = get_page_link( $posts_page_id );
			$homepage_id    = get_option( 'page_on_front' );
			$homepage_url   = empty( $homepage_id ) ? get_option( 'home' ) : get_page_link( $homepage_id );
			echo "<li typeof='v:Breadcrumb'><a rel='v:url' property='v:title' class='home' href='" . $homepage_url . "'> " . __( "Home", 'thrive' ) . $arrowImg . "</a></li>";
			if ( ! is_page() && ! empty( $posts_page_id ) ) {
				if ( ! is_home() ) {
					echo "<li typeof='v:Breadcrumb'><a rel='v:url' property='v:title' class='home' href='" . $posts_page_url . "'> " . __( "Blog", 'thrive' ) . $arrowImg . "</a></li>";
				} else {
					echo "<li typeof='v:Breadcrumb'><a class='no-link' rel='v:url' property='v:title' href='" . $posts_page_url . "'>" . __( "Blog", 'thrive' ) . "</a></li>";
				}
			}
		} else {
			echo "<li typeof='v:Breadcrumb'><a rel='v:url' property='v:title' class='home' href='" . get_option( 'home' ) . "'> " . __( "Home", 'thrive' ) . $arrowImg . "</a></li>";
		}


		if ( is_category() || is_single() ) {
			$cats = get_the_category( $post->ID );
			@usort( $cats, '_usort_terms_by_ID' );
			if ( ! empty( $cats ) ) {
				if ( isset( $cats[0] ) ) {
					echo "<li typeof='v:Breadcrumb'><a rel='v:url' property='v:title' href='" . get_category_link( $cats[0]->term_id ) . "'>" . $cats[0]->cat_name . "</a></li>";
				}
			}
			if ( is_single() ) {
				if ( ! isset( $cats[0] ) ) {
					$arrowImg = "";
				}
				echo "<li typeof='v:Breadcrumb'><a class='no-link' rel='v:url' property='v:title' href='" . get_permalink( $post->id ) . "'>" . $arrowImg . " ";
				echo get_the_title();
				echo "</a></li>";
			}
		} elseif ( is_page() ) {
			if ( $post->post_parent ) {
				$anc    = array_reverse( get_post_ancestors( $post->ID ) );
				$output = "";
				foreach ( $anc as $ancestor ) {
					$anc_link = get_page_link( $ancestor );
					$output   .= "<li typeof='v:Breadcrumb'><a rel='v:url' property='v:title' href='" . $anc_link . "'>" . get_the_title( $ancestor ) . " " . $arrowImg . "</a></li>";
				}
				echo $output . "<li typeof='v:Breadcrumb'><a class='no-link' rel='v:url' property='v:title' href='" . get_permalink() . "'>";
				the_title();
				echo "</a></li>";
			} else {
				echo "<li typeof='v:Breadcrumb'><a class='no-link' rel='v:url' property='v:title' href='" . get_permalink() . "'>";
				echo the_title();
				echo "</a></li>";
			}
		} elseif ( is_tag() ) {
			echo "<li typeof='v:Breadcrumb'>" . single_tag_title( '', false ) . '</li>';
		} elseif ( is_day() ) {
			echo "<li typeof='v:Breadcrumb'>" . __( "Archive", 'thrive' ) . ": ";
			the_time( 'F jS, Y' );
			echo '</li>';
		} elseif ( is_month() ) {
			echo "<li typeof='v:Breadcrumb'>" . __( "Archive", 'thrive' ) . ": ";
			the_time( 'F, Y' );
			echo '</li>';
		} elseif ( is_year() ) {
			echo "<li typeof='v:Breadcrumb'>" . __( "Archive", 'thrive' ) . ": ";
			the_time( 'Y' );
			echo '</li>';
		} elseif ( is_author() ) {
			echo "<li typeof='v:Breadcrumb'>" . __( "Author's archive", 'thrive' ) . ": ";
			echo '</li>';
		} elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) {
			echo "<li typeof='v:Breadcrumb'>" . __( "Archive", 'thrive' ) . ": ";
			echo '</li>';
		} elseif ( is_search() ) {
			echo "<li typeof='v:Breadcrumb'>" . __( "Search results", 'thrive' ) . ": ";
		} elseif ( is_archive() ) {
			echo "<li typeof='v:Breadcrumb'>" . __( "Archive", 'thrive' ) . ": ";
			echo '</li>';
		}

		return;
	}
endif; //thrive_breadcrumbs

/*
 * Render the pagination links
 */

function thrive_pagination() {
	global $wp_query;

	$total_pages = $wp_query->max_num_pages;

	if ( $total_pages > 1 ) {

		$current_page = max( 1, get_query_var( 'paged' ) );

		/**
		 * SUPP-3492 RISE pagination issues on search - Commented out the line
		 */
		echo paginate_links( array(
//			'format'  => ( ( get_option( 'permalink_structure' ) && ! $wp_query->is_search ) || ( is_home() && get_option( 'show_on_front' ) !== 'page' && ! get_option( 'page_on_front' ) ) ) ? '?paged=%#%' : '&paged=%#%',
			'current' => $current_page,
			'total'   => $total_pages,
		) );
	}
}

/*
 * Check if the curernt post (or page) has a focus area that needs to be rendered
 * @return Boolean
 */

function thrive_check_top_focus_area() {
	if ( is_home() || is_404() ) {
		return false;
	}

	global $post;
	if ( ! $post || ! isset( $post->post_type ) ) {
		return false;
	}
	if ( $post->post_type == TT_APPR_POST_TYPE_LESSON || $post->post_type == TT_APPR_POST_TYPE_PAGE ) {
		$post->post_type = "post";
	}
	if ( $post->post_type == "post" ) {
		return _thrive_check_top_focus_area_post( $post );
	} else {
		return _thrive_check_top_focus_area_page( $post );
	}
}

function thrive_check_blog_focus_area( $position ) {
	if ( ! is_home() ) {
		return false;
	}
	$query       = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_display_location&meta_value=between_posts&order=ASC" );
	$focus_areas = $query->get_posts();

	foreach ( $focus_areas as $temp_focus ) {
		$post_custom_atr = get_post_custom( $temp_focus->ID );
		if ( isset( $post_custom_atr['_thrive_meta_focus_display_between_posts'] ) && isset( $post_custom_atr['_thrive_meta_focus_display_between_posts'][0] ) && $post_custom_atr['_thrive_meta_focus_display_between_posts'][0] == $position ) {
			return true;
		}
	}

	return false;
}

/*
 * Check if the curernt post (or page) has a focus area that needs to be rendered
 * @return Boolean
 */

function thrive_check_bottom_focus_area() {

	if ( is_home() || is_404() ) {
		return false;
	}

	global $post;
	if ( ! $post || ! isset( $post->post_type ) ) {
		return false;
	}
	if ( $post->post_type == "post" ) {
		return _thrive_check_top_focus_area_post( $post, "bottom" );
	} else {
		return _thrive_check_top_focus_area_page( $post, "bottom" );
	}
}

/*
 * Helper function used to check if the curernt post has a focus area that needs to be rendered
 * @param Post object
 * @return Boolean
 */

function _thrive_check_top_focus_area_post( $post, $position = "top" ) {
	$custom_fields = get_post_custom( $post->ID );

	if ( $position == "top" ) {
		if ( isset( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && $post->post_type == "post" ) {
			return true;
		}

		if ( isset( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && $custom_fields['_thrive_meta_post_focus_area_top'][0] == "hide" && $post->post_type == "post" ) {
			return false;
		}
	} else {
		if ( isset( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && $post->post_type == "post" ) {
			return true;
		}

		if ( isset( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && $custom_fields['_thrive_meta_post_focus_area_bottom'][0] == "hide" && $post->post_type == "post" ) {
			return false;
		}
	}

	$post_categories = wp_get_post_categories( $post->ID );

	$query1 = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_display_post_type&meta_value=post&order=ASC&posts_per_page=-1" );
	foreach ( $query1->get_posts() as $p ) {
		//check for the top display option
		$post_custom_atr = get_post_custom( $p->ID );
		$focus_cats      = json_decode( $post_custom_atr['_thrive_meta_focus_display_categories'][0] );
		if ( ! is_array( $focus_cats ) ) {
			$focus_cats = array();
		}

		if ( isset( $post_custom_atr['_thrive_meta_focus_display_location'] ) && isset( $post_custom_atr['_thrive_meta_focus_display_location'][0] ) && $post_custom_atr['_thrive_meta_focus_display_location'][0] == $position && ( $post_custom_atr['_thrive_meta_focus_display_is_default'][0] == 1 || count( array_intersect( $post_categories, $focus_cats ) ) > 0 ) ) {
			return true;
		}
	}

	return false;
}

/*
 * Helper function used to check if the curernt page has a focus area that needs to be rendered
 * @param Post object
 * @return Boolean
 */

function _thrive_check_top_focus_area_page( $post, $position = "top" ) {
	$custom_fields = get_post_custom( $post->ID );
	if ( $position == "top" ) {
		if ( isset( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && $post->post_type == "page" ) {
			return true;
		}

		if ( isset( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && $custom_fields['_thrive_meta_post_focus_area_top'][0] == "hide" && $post->post_type == "page" ) {
			return false;
		}
	} else {
		if ( isset( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && $post->post_type == "page" ) {
			return true;
		}

		if ( isset( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && $custom_fields['_thrive_meta_post_focus_area_bottom'][0] == "hide" && $post->post_type == "page" ) {
			return false;
		}
	}
	$query2 = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_display_post_type&meta_value=page&order=ASC&posts_per_page=-1" );

	$post_categories = wp_get_post_categories( $post->ID );

	foreach ( $query2->get_posts() as $p ) {
		$post_custom_atr = get_post_custom( $p->ID );
		if ( isset( $post_custom_atr['_thrive_meta_focus_display_categories'] ) && $post_custom_atr['_thrive_meta_focus_display_categories'][0] ) {
			$focus_cats = json_decode( $post_custom_atr['_thrive_meta_focus_display_categories'][0] );
		} else {
			$focus_cats = array();
		}
		if ( ! is_array( $focus_cats ) ) {
			$focus_cats = array();
		}

		if ( isset( $post_custom_atr['_thrive_meta_focus_display_location'] ) && isset( $post_custom_atr['_thrive_meta_focus_display_location'][0] ) && $post_custom_atr['_thrive_meta_focus_display_location'][0] == $position ) {
			return true;
		}
	}

	return false;
}

/**
 * Renders the top focus area
 */
function thrive_render_top_focus_area( $position = "top", $place = null ) {
	global $post;
	$current_post        = $post;
	$page_focus          = null;
	$post_focus          = null;
	$current_focus       = null;
	$current_focus_attrs = null;

	$custom_fields = get_post_custom( $post->ID );

	if ( $position == "top" ) {
		if ( isset( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && $post->post_type == "post" ) {
			$post_focus = get_post( $custom_fields['_thrive_meta_post_focus_area_top'][0] );
		}

		if ( isset( $custom_fields['_thrive_meta_post_focus_area_top'] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_top'][0] ) && $post->post_type == "page" ) {
			$page_focus = get_post( $custom_fields['_thrive_meta_post_focus_area_top'][0] );
		}
	} else {
		if ( isset( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && $post->post_type == "post" ) {
			$post_focus = get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] );
		}

		if ( isset( $custom_fields['_thrive_meta_post_focus_area_bottom'] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && $post->post_type == "page" ) {
			$page_focus = get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] );
		}
	}

	if ( ! $post_focus ) {
		$post_categories = wp_get_post_categories( $post->ID );
		$query1          = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_display_post_type&meta_value=post&order=ASC&posts_per_page=-1" );
		foreach ( $query1->get_posts() as $p ) {
			$post_custom_atr = get_post_custom( $p->ID );
			$focus_cats      = json_decode( $post_custom_atr['_thrive_meta_focus_display_categories'][0] );
			if ( ! is_array( $focus_cats ) ) {
				$focus_cats = array();
			}

			if ( isset( $post_custom_atr['_thrive_meta_focus_display_location'] ) && isset( $post_custom_atr['_thrive_meta_focus_display_location'][0] ) && $post_custom_atr['_thrive_meta_focus_display_location'][0] == $position && ( $post_custom_atr['_thrive_meta_focus_display_is_default'][0] == 1 || count( array_intersect( $post_categories, $focus_cats ) ) > 0 ) ) {
				$post_focus = $p;
			}
		}
	}

	if ( ! $page_focus ) {
		$post_categories = wp_get_post_categories( $post->ID );
		//get the focus area for the posts and for the pages, if any is set
		$query2 = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_display_post_type&meta_value=page&order=ASC&posts_per_page=-1" );
		foreach ( $query2->get_posts() as $p ) {
			$post_custom_atr = get_post_custom( $p->ID );
			if ( isset( $post_custom_atr['_thrive_meta_focus_display_categories'] ) && $post_custom_atr['_thrive_meta_focus_display_categories'][0] ) {
				$focus_cats = json_decode( $post_custom_atr['_thrive_meta_focus_display_categories'][0] );
			} else {
				$focus_cats = array();
			}
			if ( ! is_array( $focus_cats ) ) {
				$focus_cats = array();
			}
			if ( isset( $post_custom_atr['_thrive_meta_focus_display_location'] ) && isset( $post_custom_atr['_thrive_meta_focus_display_location'][0] ) && $post_custom_atr['_thrive_meta_focus_display_location'][0] == $position ) {
				$page_focus = $p;
			}
		}
	}

	if ( $current_post->post_type == "post" ) {
		if ( $post_focus ) {
			$current_focus = $post_focus;
		}
	}

	if ( $post->post_type == "page" ) {
		if ( $page_focus ) {
			$current_focus = $page_focus;
		}
	}

	if ( $position == "between_posts" ) {
		$query3      = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_display_location&meta_value=between_posts&order=ASC&posts_per_page=-1" );
		$focus_areas = $query3->get_posts();

		foreach ( $focus_areas as $temp_focus ) {
			$post_custom_atr = get_post_custom( $temp_focus->ID );
			if ( isset( $post_custom_atr['_thrive_meta_focus_display_between_posts'] ) && isset( $post_custom_atr['_thrive_meta_focus_display_between_posts'][0] ) && $post_custom_atr['_thrive_meta_focus_display_between_posts'][0] == $place ) {
				$current_focus = $temp_focus;
			}
		}
	}

	if ( is_search() && ! $current_focus && $page_focus ) {
		$current_focus = $page_focus;
	}

	if ( $place == "blog" || $place == "archive" ) {

		if ( $place == "blog" ) {
			$query4 = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_page_blog&meta_value=blog&order=ASC&posts_per_page=-1" );
		} elseif ( $place == "archive" ) {
			$query4 = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_page_archive&meta_value=archive&order=ASC&posts_per_page=-1" );
		}

		$focus_areas = $query4->get_posts();

		foreach ( $focus_areas as $focus_area ) {
			$post_custom_atr = get_post_custom( $focus_area->ID );

			if ( isset( $post_custom_atr['_thrive_meta_focus_display_location'] )
			     && isset( $post_custom_atr['_thrive_meta_focus_display_location'][0] )
			     && $post_custom_atr['_thrive_meta_focus_display_location'][0] == $position
			) {
				$current_focus = $focus_area;
			}
		}
	}

	/**
	 * Danutz: logic for custom Zack focus area
	 *
	 * @see Everywhere on top option for location of focus area
	 * @see child theme made for Zack
	 */
	if ( ! $current_focus && $position === 'top_posts' ) {
		$query5      = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_display_location&meta_value=top_posts&order=DESC&posts_per_page=1" );
		$focus_areas = $query5->get_posts();
		if ( ! empty( $focus_areas ) ) {
			$current_focus = current( $focus_areas );
		}
	}

	if ( ! $current_focus ) {
		return;
	}
	$current_attrs = get_post_custom( $current_focus->ID );

	if ( ! $current_attrs || ! isset( $current_attrs['_thrive_meta_focus_template'] ) || ! isset( $current_attrs['_thrive_meta_focus_template'][0] ) ) {
		return;
	}

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
	$value_focus_template = strtolower( $current_attrs['_thrive_meta_focus_template'][0] );

	$base_path = get_template_directory();
	$base_path = apply_filters( 'thrive_focus_preview_template_base_path', $base_path, $current_attrs['_thrive_meta_focus_template'][0] );

	$template_path = $base_path . "/focusareas/" . $value_focus_template . ".php";
	if ( $position != "top" ) {
		//echo $template_path; die;
	}

	if ( ! empty( $_GET['tve'] ) ) {
		return;
	}

	require $template_path;
}

/*
 * Renders the bottom focus area
 */

function thrive_render_bottom_focus_area() {
	global $post;
	$current_post  = $post;
	$page_focus    = null;
	$post_focus    = null;
	$current_focus = null;

	$custom_fields = get_post_custom( $post->ID );

	if ( isset( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && $post->post_type == "post" ) {
		$post_focus = get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] );
	}

	if ( isset( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && is_numeric( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] ) && $post->post_type == "page" ) {
		$page_focus = get_post( $custom_fields['_thrive_meta_post_focus_area_bottom'][0] );
	}


	//get the focus area for the posts and for the pages, if any is set
	$query1 = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_display_post_type&meta_value=post&order=ASC&posts_per_page=-1" );
	foreach ( $query1->get_posts() as $p ) {
		$post_custom_atr = get_post_custom( $p->ID );
		if ( isset( $post_custom_atr['_thrive_meta_focus_display_location'] ) && isset( $post_custom_atr['_thrive_meta_focus_display_location'][0] ) && $post_custom_atr['_thrive_meta_focus_display_location'][0] == "bottom" ) {
			$post_focus = $p;
		}
	}

	//get the focus area for the posts and for the pages, if any is set
	$query2 = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_display_post_type&meta_value=page&order=ASC&posts_per_page=-1" );
	foreach ( $query2->get_posts() as $p ) {
		$post_custom_atr = get_post_custom( $p->ID );
		if ( isset( $post_custom_atr['_thrive_meta_focus_display_location'] ) && isset( $post_custom_atr['_thrive_meta_focus_display_location'][0] ) && $post_custom_atr['_thrive_meta_focus_display_location'][0] == "bottom" ) {
			$page_focus = $p;
		}
	}

	if ( $current_post->post_type == "post" ) {
		if ( $post_focus ) {
			$current_focus = $post_focus;
		}
	}

	if ( $post->post_type == "page" ) {
		if ( $page_focus ) {
			$current_focus = $page_focus;
		}
	}

	if ( ! $current_focus ) {
		return;
	}
	$current_attrs = get_post_custom( $current_focus->ID );

	if ( ! $current_attrs || ! isset( $current_attrs['_thrive_meta_focus_template'] ) || ! isset( $current_attrs['_thrive_meta_focus_template'][0] ) ) {
		return;
	}

	$template_path = get_template_directory() . "/focusareas/" . strtolower( $current_attrs['_thrive_meta_focus_template'][0] ) . "_bottom.php";

	require_once $template_path;
}

/*
 * Changes the page menu markup in order to render it accordingly to the theme's markup
 * @param string $page_markup The menu markup
 * @return string The new markup
 */

function thrive_custom_page_menu( $page_markup ) {
	preg_match( '/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches );
	$divclass   = $matches[1];
	$toreplace  = array( '<div class="' . $divclass . '">', '</div>' );
	$new_markup = str_replace( $toreplace, '', $page_markup );
	$new_markup = preg_replace( '/^<ul>/i', '<ul id="' . $divclass . '">', $new_markup );
	$new_markup = '<nav class="right">' . $new_markup . '</nav>';

	return $new_markup;
}

add_filter( 'wp_page_menu', 'thrive_custom_page_menu' );

// read more link
add_filter( 'the_content_more_link', 'thrive_more_link', 10, 2 );
function thrive_more_link( $more_link, $more_link_text ) {
	$options          = thrive_get_theme_options();
	$read_more_class  = ( $options['other_read_more_type'] == "button" ) ? "btn dark medium" : "readmore_link";
	$read_more_text   = ( $options['other_read_more_text'] != "" ) ? $options['other_read_more_text'] : "Read more";
	$read_more_text   = ( $options['other_read_more_type'] == "button" ) ? "<span>" . $options['other_read_more_text'] . "</span>" : $options['other_read_more_text'];
	$thrive_more_link = '<a class="' . $read_more_class . '" href="' . get_permalink() . '">' . $read_more_text . '</a>';

	return $thrive_more_link;
}

/**
 * Because TCB does apply filters on "the_content_more_link"
 * and because of the filter "the_content_more_link" added in this theme
 * This function removes the more_text appended to the excerpt
 *
 * @see  thrive_more_link()
 */
add_filter( "the_excerpt", "thrive_the_excerpt" );
function thrive_the_excerpt( $excerpt ) {
	$thrive_read_more_text = trim( thrive_get_theme_options( 'other_read_more_text' ) );
	$last_occurrence       = strrpos( $excerpt, $thrive_read_more_text );
	if ( $last_occurrence !== false ) {
		$excerpt = substr_replace( $excerpt, "", $last_occurrence, strlen( $thrive_read_more_text ) );
	}

	return $excerpt;
}

// Adding actions to show and edit the field
add_action( 'show_user_profile', 'thrive_social_fields_display', 10 );
add_action( 'edit_user_profile', 'thrive_social_fields_display', 10 );

function thrive_social_fields_display( $user ) {
	$tt_authorbox_image = esc_attr( get_the_author_meta( 'tt_authorbox_image', $user->ID ) );
	if ( empty( $tt_authorbox_image ) ) {
		$tt_authorbox_image = get_template_directory_uri() . "/images/" . TT_DEFAULT_AUTHORBOX_IMAGE;
	}
	require "inc/templates/user-thrive-authorbox-settings.php";
}

add_action( 'personal_options_update', 'thrive_save_user_fields' );
add_action( 'edit_user_profile_update', 'thrive_save_user_fields' );

function thrive_save_user_fields( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	$show_social_profiles = implode( ',', $_POST["show_social_profiles"] );

	$_POST['gauthor']               = ( isset( $_POST['gauthor'] ) ) ? $_POST['gauthor'] : "";
	$_POST['gplus']                 = ( isset( $_POST['gplus'] ) ) ? $_POST['gplus'] : "";
	$_POST['twitter']               = ( isset( $_POST['twitter'] ) ) ? $_POST['twitter'] : "";
	$_POST['facebook']              = ( isset( $_POST['facebook'] ) ) ? $_POST['facebook'] : "";
	$_POST['linkedin']              = ( isset( $_POST['linkedin'] ) ) ? $_POST['linkedin'] : "";
	$_POST['xing']                  = ( isset( $_POST['xing'] ) ) ? $_POST['xing'] : "";
	$_POST['tt_authorbox_image']    = ( isset( $_POST['tt_authorbox_image'] ) ) ? $_POST['tt_authorbox_image'] : "";
	$_POST['thrive_author_website'] = ( isset( $_POST['thrive_author_website'] ) ) ? $_POST['thrive_author_website'] : "";

	update_user_meta( $user_id, 'gauthor', $_POST['gauthor'] );
	update_user_meta( $user_id, 'gplus', $_POST['gplus'] );
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
	update_user_meta( $user_id, 'xing', $_POST['xing'] );
	update_user_meta( $user_id, 'show_social_profiles', $show_social_profiles );
	update_user_meta( $user_id, 'thrive_author_website', $_POST['thrive_author_website'] );
	update_user_meta( $user_id, 'tt_authorbox_image', $_POST['tt_authorbox_image'] );
	if ( filter_var( $_POST['tt_authorbox_image'], FILTER_VALIDATE_URL ) ) {
		update_user_meta( $user_id, 'tt_authorbox_image', $_POST['tt_authorbox_image'] );
	} else {
		delete_user_meta( $user_id, 'tt_authorbox_image' );
	}
}

// google authorship link
add_action( 'wp_head', 'thrive_gauthorship' );

function thrive_gauthorship() {
	if ( is_single() || is_page() ) {
		global $post;
		$user_id     = $post->post_author;
		$g_page      = get_the_author_meta( 'gplus', $user_id );
		$g_activated = get_the_author_meta( 'gauthor', $user_id );
		if ( $g_page && $g_activated ):
			echo '<link rel="author" href="' . $g_page . '"/>';
		endif;
	}
}

function thrive_exclude_category( $query ) {
	$hide_cat_option = thrive_get_theme_options( 'hide_cats_from_blog' );

	if ( ! is_string( $hide_cat_option ) ) {
		$hide_cat_option = "";
	}

	$hide_categories        = is_array( json_decode( $hide_cat_option ) ) ? json_decode( $hide_cat_option ) : array();
	$temp_query_string_part = "";
	foreach ( $hide_categories as $temp_cat_id ) {
		$temp_query_string_part .= "-" . $temp_cat_id . " ";
	}

	if ( $query->is_home() ) {
		$query->set( 'cat', $temp_query_string_part );
	}

	return $query;
}

add_filter( 'pre_get_posts', 'thrive_exclude_category' );

// prevent wrapping of paragraph tags around shortcodes
add_filter( 'the_content', 'thrive_remove_autop_shortcodes' );

function thrive_remove_autop_shortcodes( $content ) {
	$array = array(
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']'
	);

	$content = strtr( $content, $array );

	return $content;
}

// attach classes that are helpful for CSS to primary menu and remove all pages apart from top level pages from the footer menu
function thrive_menu_set_dropdown( $sorted_menu_items, $args ) {
	if ( isset( $args->theme_location ) && $args->theme_location == "primary" ) {
		$last_top    = 0;
		$post_id_key = array();

		foreach ( $sorted_menu_items as $key => $obj ) {
			// if not parent element (class not to be applied to parent element
			if ( 0 != $obj->menu_item_parent ) {
				$sorted_menu_items[ $last_top ]->classes['dropdown'] = 'toplvl dropdown';
				// need to map key to post id
				$post_id_key[ $obj->db_id ] = $key;

				// if menu item has parent
				if ( $obj->menu_item_parent ) {
					if ( isset( $post_id_key[ $obj->menu_item_parent ] ) ) {
						// give parent class identifier
						$sub_menu_parent_key                                            = $post_id_key[ $obj->menu_item_parent ];
						$sorted_menu_items[ $sub_menu_parent_key ]->classes['dropdown'] = 'arl';
					}
				}
			} else {
				// top level menu item
				$sorted_menu_items[ $key ]->classes['dropdown'] = 'toplvl';
				$last_top                                       = $key;
			}
		}

		return $sorted_menu_items;
	}

	return $sorted_menu_items;
}

add_filter( 'wp_nav_menu_objects', 'thrive_menu_set_dropdown', 10, 2 );

require( get_template_directory() . "/inc/clone-post.php" );
require( get_template_directory() . "/inc/theme-update.php" );

/*
 * Add a new default avatar image
 */
add_filter( 'avatar_defaults', 'thrive_default_avatar_image' );

function thrive_default_avatar_image( $avatar_defaults ) {
	$myavatar                     = get_template_directory_uri() . '/images/default_avatar.png';
	$avatar_defaults[ $myavatar ] = "ThriveDefaultAvatar";

	return $avatar_defaults;
}

/*
 * Remove the query string for the static scripts and stylesheets used
 * by this theme
 */

function thrive_remove_script_version( $src ) {
	$thrive_files = array(
		"script.js",
		"jquery",
		"reset.css",
		"main_blue.css",
		"main_green.css",
		"main_orange.css",
		"main_purple.css",
		"main_red.css"
	);

	if ( thrive_strposa( $src, $thrive_files ) ) {
		$my_theme = wp_get_theme();
		$parts    = explode( '?', $src );

		return $parts[0] . "?v=" . $my_theme->get( 'Version' );
	}

	return $src;
}

add_filter( 'script_loader_src', 'thrive_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'thrive_remove_script_version', 15, 1 );

add_action( 'wp_ajax_thrive_lazy_load_comments', 'thrive_lazy_load_comments' );
add_action( 'wp_ajax_nopriv_thrive_lazy_load_comments', 'thrive_lazy_load_comments' );
add_action( 'tve_dash_main_ajax_theme_comments', 'thrive_lazy_load_comments', 10, 2 );

function thrive_lazy_load_comments( $current = '', $post_data = null ) {
	$data              = is_null( $post_data ) ? $_POST : $post_data;
	$post_id           = isset( $data['post_id'] ) ? (int) $data['post_id'] : 0;
	$comment_page      = isset( $data['comment_page'] ) ? (int) $data['comment_page'] : 1;
	$comments_per_page = 10;

	$args     = array(
		'post_id'      => $post_id,
		'order'        => strtoupper( get_option( 'comment_order', 'asc' ) ),
		'number'       => $comments_per_page,
		'offset'       => ( $comment_page - 1 ) * $comments_per_page,
		'hierarchical' => true,
	);
	$comments = get_comments( $args );
	if ( ! is_null( $post_data ) ) {
		ob_start();
	}
	wp_list_comments(
		array(
			'callback'          => 'thrive_comments',
			'reverse_top_level' => false
		),
		$comments );
	if ( ! is_null( $post_data ) ) {
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
	wp_die();
}

/*
 * Render the comments template and the comments form
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if ( ! function_exists( 'thrive_comments' ) ) :
	function thrive_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'trackback' :
				break;
			case 'pingback' :
			default :
				// Proceed with normal comments.
				global $post;
				if ( ! $post ) {
					$post = get_post( $comment->comment_post_ID );
				}
				$show_comment_date         = thrive_get_theme_options( 'other_show_comment_date' );
				$relative_time             = thrive_get_theme_options( 'relative_time' );
				$highlight_author_comments = thrive_get_theme_options( 'highlight_author_comments' );
				$comment_author            = get_user_by( 'email', get_comment_author_email() );
				$comment_author_url        = get_comment_author_url();
				$display_name              = null;
				$comment_container_class   = "cmc";
				$comment_author_id         = 0;
				$color_theme               = thrive_get_theme_options( 'color_scheme' );
				if ( $comment_author ) {
					$fname        = get_the_author_meta( 'first_name', $comment_author->ID );
					$lname        = get_the_author_meta( 'last_name', $comment_author->ID );
					$author_name  = get_the_author_meta( 'display_name', $comment_author->ID );
					$display_name = empty( $author_name ) ? $fname . " " . $lname : $author_name;
					if ( $post->post_author == $comment_author->ID && $highlight_author_comments == 1 ) {
						$comment_container_class .= " byAut";
					}
					$comment_author_id = $comment_author->ID;
				}
				if ( ! $display_name || $display_name == "" ) {
					$display_name = get_comment_author();
				}
				$client_ip         = _thrive_get_client_ip();
				$comment_author_ip = get_comment_author_IP();
				$user_ID           = get_current_user_id();
				?>
				<?php if ( _thrive_check_comment_approved( $comment->comment_approved, $client_ip, $comment_author_ip, $user_ID, $comment_author_id ) ): ?>
                <div class="cmb" id="comment-<?php echo get_comment_ID(); ?>">
                    <div class="<?php echo $comment_container_class; ?>">
                        <div class="left">
							<?php echo get_avatar( get_comment_author_email(), 50 ); ?>
                        </div>

                        <div class="ccr right">
                                <span class="nam">
                                    <?php if ( $comment_author_url && $comment_author_url != "" ): ?>
                                        <a href="<?php echo $comment_author_url; ?>" target="_blank" rel="nofollow">
		                                    <?php echo $display_name; ?>
	                                    </a>
	                                    <?php _e( 'says', 'thrive' ); ?>
                                    <?php else: ?>
                                        <span
                                                class="uNM"><?php echo $display_name; ?></span> <?php _e( 'says', 'thrive' ); ?>
                                    <?php endif; ?>
                                </span>
                            <span class="uDt">
                                   <?php if ( $show_comment_date == 1 ): ?>
	                                   <?php if ( $relative_time == 1 ): ?>
		                                   <?php echo thrive_human_time( get_comment_date( 'U' ) ); ?>
	                                   <?php else: ?>
		                                   <?php echo get_comment_date(); ?>
	                                   <?php endif; ?>
                                   <?php endif; ?>
                                </span>

							<?php if ( '0' == $comment->comment_approved ): ?>
                                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'thrive' ); ?></p>
							<?php else: ?>
                                <p><?php comment_text(); ?></p>
							<?php endif; ?>

							<?php if ( comments_open() && ! post_password_required() && '0' != $comment->comment_approved ) : ?>
                                <a class="rpl reply left" href="#"
                                   id="link-reply-<?php echo get_comment_ID(); ?>"
                                   cid="<?php echo get_comment_ID(); ?>">
									<?php _e( "Reply", 'thrive' ); ?>
                                </a>
							<?php endif; ?>
                            <div class="clear"></div>

                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="lrp" id="respond-container-<?php echo get_comment_ID(); ?>" style="display: none;">
                        <div class="clear"></div>
                        <form action="<?php echo site_url( '/wp-comments-post.php' ) ?>" method="post">
							<?php if ( ! is_user_logged_in() ): ?>
                                <div class="llw">
                                    <label
                                            for="author"><?php _e( "Name", 'thrive' ); ?><?php if ( get_option( "require_name_email" ) == 1 ) { ?>*<?php } ?></label>
                                    <input type="text" id="author"
                                           placeholder="" name="author"/>
                                </div>
                                <div class="llw">
                                    <label
                                            for="email"><?php _e( "Email", 'thrive' ); ?><?php if ( get_option( "require_name_email" ) == 1 ) { ?>*<?php } ?></label>

                                    <input type="text" id="email"
                                           placeholder="" name="email"/>
                                </div>
                                <label
                                        for="website"><?php _e( "Website", 'thrive' ); ?></label>
                                <input type="text" id="website"
                                       placeholder="" name="website"/>
							<?php endif; ?>
                            <label for="comment"><?php _e( 'Comment', 'thrive' ); ?></label>
                            <textarea id="comment" name="comment" class="textarea"></textarea>

                            <div class="btn <?php echo $color_theme; ?> small">
                                <input type="submit" value="<?php _e( "Post Comment", 'thrive' ); ?>">
                            </div>

                            <input id="comment_post_ID" type="hidden" value="<?php echo get_the_ID(); ?>"
                                   name="comment_post_ID">
                            <input id="comment_parent" type="hidden" value="<?php echo get_comment_ID(); ?>"
                                   name="comment_parent">
                        </form>
                        <a href="#" class="rpl right cancel_reply" cid="<?php echo get_comment_ID(); ?>">
							<?php _e( "Cancel", 'thrive' ); ?>
                        </a>

                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="lrp" style="display: none;" id="respond-container-<?php echo get_comment_ID(); ?>">
                </div>
			<?php endif; ?>
				<?php
				break;
		endswitch;
	}
endif; //thrive_comments

/*
 * Add custom items to the menu from the admin part. 
 */
add_filter( 'wp_setup_nav_menu_item', 'thrive_custom_admin_nav_item' );

function thrive_custom_admin_nav_item( $menu_item ) {
	$menu_item->extended_activate     = get_post_meta( $menu_item->ID, '_menu_item_extended_activate', true );
	$menu_item->highlight_menu        = get_post_meta( $menu_item->ID, '_menu_item_highlight_menu_item', true );
	$menu_item->extended_columns      = get_post_meta( $menu_item->ID, '_menu_item_extended_columns', true );
	$menu_item->extended_heading      = get_post_meta( $menu_item->ID, '_menu_item_extended_heading', true );
	$menu_item->extended_disable_link = get_post_meta( $menu_item->ID, '_menu_item_extended_disable_link', true );
	$menu_item->extended_text_chk     = get_post_meta( $menu_item->ID, '_menu_item_extended_text_chk', true );
	$menu_item->extended_free_text    = get_post_meta( $menu_item->ID, '_menu_item_extended_free_text', true );

	return $menu_item;
}

add_action( 'wp_update_nav_menu_item', 'thrive_custom_admin_nav_update', 10, 3 );

function thrive_custom_admin_nav_update( $menu_id, $menu_item_db_id, $args ) {
	if ( isset( $_REQUEST['menu-item-extended-activate'][ $menu_item_db_id ] ) && is_array( $_REQUEST['menu-item-extended-activate'] ) ) {
		$custom_value = $_REQUEST['menu-item-extended-activate'][ $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, '_menu_item_extended_activate', $custom_value );
	} else {
		update_post_meta( $menu_item_db_id, '_menu_item_extended_activate', 'off' );
	}

	if ( isset( $_REQUEST['menu-item-highlight-menu-item'][ $menu_item_db_id ] ) && is_array( $_REQUEST['menu-item-highlight-menu-item'] ) ) {
		$custom_value = $_REQUEST['menu-item-highlight-menu-item'][ $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, '_menu_item_highlight_menu_item', $custom_value );
	} else {
		update_post_meta( $menu_item_db_id, '_menu_item_highlight_menu_item', 'off' );
	}

	if ( isset( $_REQUEST['menu-item-extended-columns'][ $menu_item_db_id ] ) && is_array( $_REQUEST['menu-item-extended-columns'] ) ) {
		$custom_value = $_REQUEST['menu-item-extended-columns'][ $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, '_menu_item_extended_columns', $custom_value );
	}

	if ( isset( $_REQUEST['menu-item-extended-heading'][ $menu_item_db_id ] ) && is_array( $_REQUEST['menu-item-extended-heading'] ) ) {
		$custom_value = $_REQUEST['menu-item-extended-heading'][ $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, '_menu_item_extended_heading', $custom_value );
	} else {
		if ( get_post_meta( $menu_item_db_id, '_menu_item_extended_heading', true ) == '' ) {
			update_post_meta( $menu_item_db_id, '_menu_item_extended_heading', 'on' );
		} else {
			update_post_meta( $menu_item_db_id, '_menu_item_extended_heading', 'off' );
		}
	}

	if ( isset( $_REQUEST['menu-item-extended-disable-link'][ $menu_item_db_id ] ) && is_array( $_REQUEST['menu-item-extended-disable-link'] ) ) {
		$custom_value = $_REQUEST['menu-item-extended-disable-link'][ $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, '_menu_item_extended_disable_link', $custom_value );
	} else {
		update_post_meta( $menu_item_db_id, '_menu_item_extended_disable_link', 'off' );
	}

	if ( isset( $_REQUEST['menu-item-extended-text-chk'][ $menu_item_db_id ] ) && is_array( $_REQUEST['menu-item-extended-text-chk'] ) ) {
		$custom_value = $_REQUEST['menu-item-extended-text-chk'][ $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, '_menu_item_extended_text_chk', $custom_value );
	} else {
		update_post_meta( $menu_item_db_id, '_menu_item_extended_text_chk', 'off' );
	}

	if ( isset( $_REQUEST['menu-item-extended-free-text'][ $menu_item_db_id ] ) && is_array( $_REQUEST['menu-item-extended-free-text'] ) ) {
		$custom_value = $_REQUEST['menu-item-extended-free-text'][ $menu_item_db_id ];
		update_post_meta( $menu_item_db_id, '_menu_item_extended_free_text', $custom_value );
	}
}

add_filter( 'wp_edit_nav_menu_walker', 'thrive_function_admin_custom_menu_walker', 10, 2 );


function custom_nav_edit_walker( $walker, $menu_id ) {
	return 'Walker_Nav_Menu_Edit_Custom';
}

/*
 * add custom font css
 */
add_action( "tha_head_top", "thrive_load_font_css" );

function thrive_load_font_css( $font ) {

	$fonts = (array) json_decode( get_option( 'thrive_font_manager_options' ) );
	if ( ! $fonts || ! is_array( $fonts ) ) {
		return;
	}
	echo '<style type="text/css">';

	foreach ( $fonts as $font ) {
		echo ' .' . $font->font_class . '{';
		echo "font-family: " . thrive_prepare_font_family( $font->font_name ) . ";";
		echo 'font-size:' . $font->font_size . ';';
		echo 'line-height:' . $font->font_height . ';';
		echo 'color:' . $font->font_color . ';';
		echo '} ';
		echo $font->custom_css;
	}

	echo '</style>';
}

/**
 * Prepare font family name to be added to css rule
 *
 * @param $font_family
 *
 * @return string
 */
function thrive_prepare_font_family( $font_family ) {
	$chunks = explode( ",", $font_family );
	$length = count( $chunks );
	$font   = "";
	foreach ( $chunks as $key => $value ) {
		$font .= "'" . trim( $value ) . "'";
		$font .= ( $key + 1 ) < $length ? ", " : "";
	}

	return $font;
}

function thrive_save_post_font( $post_id ) {

	$post_content = get_post_field( 'post_content', $post_id );
	preg_match_all( "/thrive_custom_font id='\d+'/", $post_content, $font_ids );

	$post_fonts = array();
	foreach ( $font_ids[0] as $font_id ) {
		$parts = explode( "'", $font_id );
		$id    = $parts[1];
		$font  = thrive_get_font_options( $id );
		if ( tve_dash_font_manager_is_safe_font( $font->font_name ) ) {
			continue;
		}
		if ( Tve_Dash_Font_Import_Manager::isImportedFont( $font->font_name ) ) {
			$post_fonts[] = Tve_Dash_Font_Import_Manager::getCssFile();
			continue;
		}
		$post_fonts[] = "//fonts.googleapis.com/css?family=" . str_replace( " ", "+", $font->font_name ) . ( $font->font_style != 0 ? ":" . $font->font_style : "" ) . ( $font->font_bold != 0 ? "," . $font->font_bold : "" ) . ( $font->font_italic != 0 ? $font->font_italic : "" ) . ( $font->font_character_set != 0 ? "&subset=" . $font->font_character_set : "" );
	}
	$post_fonts = array_unique( $post_fonts );
	update_post_meta( $post_id, 'thrive_post_fonts', sanitize_text_field( json_encode( $post_fonts ) ) );
}

add_action( 'save_post', 'thrive_save_post_font' );

function thrive_enqueue_head_fonts() {

	if ( is_singular() ) {
		$post_id = get_the_ID();
	} else {
		$post_id = array();
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$post_id[] = get_the_ID();
			}
		}
	}
	if ( is_array( $post_id ) ) {
		foreach ( $post_id as $id ) {
			$fonts = json_decode( get_post_meta( $id, 'thrive_post_fonts', true ) );
			if ( $fonts != null ) {
				foreach ( $fonts as $key => $font ) {
					wp_enqueue_style( 'tcf_' . md5( $font ), $font );
				}
			}
		}
	} else {
		$fonts = json_decode( get_post_meta( $post_id, 'thrive_post_fonts', true ) );
		if ( $fonts != null ) {
			foreach ( $fonts as $key => $font ) {
				wp_enqueue_style( 'tcf_' . md5( $font ), $font );
			}
		}
	}
}

add_filter( 'is_protected_meta', 'thrive_hide_custom_fields', 10, 2 );

function thrive_hide_custom_fields( $protected, $meta_key ) {
	$keys = array(
		'thrive_post_fonts',
		'thrive_share_count'
	);

	if ( in_array( $meta_key, $keys ) ) {
		return true;
	}

	return $protected;
}

add_action( 'wp_ajax_thrive_get_share_count', 'thrive_get_share_count' );
add_action( 'wp_ajax_nopriv_thrive_get_share_count', 'thrive_get_share_count' );

add_action( 'tve_dash_main_ajax_theme_shares', 'thrive_dash_social_ajax_share_counts', 10, 2 );

/**
 * return share counts to the dashboard main ajax call
 *
 * @param array $current
 * @param array $post_data
 */
function thrive_dash_social_ajax_share_counts( $current, $post_data ) {
	return thrive_get_share_count( true, $post_data );
}

/**
 * @param bool|false $return
 * @param null $post_data
 *
 * @return mixed
 */
function thrive_get_share_count( $return = false, $post_data = null ) {
	$post_data = null !== $post_data ? $post_data : $_REQUEST;

	if ( isset( $post_data['post_id'] ) ) {
		$post_id = $post_data['post_id'];
	} else {
		$post_id = 0;
	}

	if ( empty( $post_id ) ) {
		return '';
	}

	$cache_lifetime = apply_filters( 'thrive_cache_shares_lifetime', 300 );

	$share_count = json_decode( get_post_meta( $post_id, 'thrive_share_count', true ), true );
	if ( empty( $share_count ) ) {
		$share_count = array();
	}

	$post_link = get_permalink( $post_id );
	if ( ! empty( $share_count['url'] ) && $share_count['url'] != $post_link ) { // if url has changed => refresh the cache
		$share_count = array();
	}

	if ( empty( $_POST['no_cache'] ) && ! empty( $share_count['last_fetch'] ) && time() < $share_count['last_fetch'] + $cache_lifetime ) {
		if ( $return ) {
			return $share_count['total'] . ' ' . _n( 'Share', 'Shares', $share_count['total'], 'thrive' );
		}
		exit( $share_count['total'] . ' ' . _n( 'Share', 'Shares', $share_count['total'], 'thrive' ) );
	}

	$fb = thrive_get_facebook_share( $post_link );
	if ( ! empty( $fb ) || ! isset( $share_count['facebook'] ) ) {
		$share_count['facebook'] = $fb;
	}

	$share_count['twitter'] = 0;

	$po = thrive_get_plusones_shares( $post_link );
	if ( ! empty( $po ) || ! isset( $share_count['plusone'] ) ) {
		$share_count['plusone'] = $po;
	}

	$pinterest = thrive_get_plusones_shares( $post_link, 'pinterest' );
	if ( ! empty( $pinterest ) || ! isset( $share_count['pinterest'] ) ) {
		$share_count['pinterest'] = $pinterest;
	}
	$li = thrive_get_linkedin_share( $post_link );
	if ( ! empty( $li ) || ! isset( $share_count['linkedin'] ) ) {
		$share_count['linkedin'] = $li;
	}
	$total = 0;
	foreach ( $share_count as $network => $count ) {
		if ( $network == 'last_fetch' || $network == 'total' || $network == 'url' ) {
			continue;
		}
		$total += $count;
	}
	$share_count['total']      = $total;
	$share_count['last_fetch'] = time();
	$share_count['url']        = $post_link;
	//update post meta options
	update_post_meta( $post_id, 'thrive_share_count', sanitize_text_field( json_encode( $share_count ) ) );

	if ( $return ) {
		return $total . ' ' . _n( 'Share', 'Shares', $total + 12321, 'thrive' );
	}
	exit( $total . ' ' . _n( 'Share', 'Shares', $total, 'thrive' ) );
}

add_theme_support( 'woocommerce' );

/*
 * Custom title output
 */
if ( ! function_exists( 'thrive_wp_title' ) ) :
	function thrive_wp_title( $title ) {
		if ( is_front_page() ) {
			return get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
		} elseif ( is_feed() ) {
			return ' | RSS Feed';
		} else {
			return trim( $title, '| ' ) . ' | ' . get_bloginfo( 'name' );
		}

	}

	add_filter( 'wp_title', 'thrive_wp_title' );
endif;

/**
 * add custom classes for woocommerce - the right way
 */
add_filter( 'body_class', 'thrive_body_class' );

/**
 * check if Woocommerce specific pages and append required classes
 *
 * @param array $classes
 *
 * @return array
 */
function thrive_body_class( $classes ) {
	if ( class_exists( 'WooCommerce' ) ) {
		$classes [] = 'tve-woo-minicart';
	} else {
		return $classes;
	}

	if ( _thrive_check_is_woocommerce_page() || thrive_has_woo_shortcode() ) {
		$classes [] = 'tve-woocommerce';
	}

	return $classes;
}

add_filter( 'get_avatar_url', 'thrive_get_avatar_url', 10, 3 );
/**
 * Filter the avatar url
 * Returns the thrive user image if is set
 *
 * @param $url
 * @param $id_or_email
 *
 * @return string
 */
function thrive_get_avatar_url( $url, $id_or_email ) {
	if ( is_numeric( $id_or_email ) && $user = get_user_by( 'id', absint( $id_or_email ) ) ) {
		$thrive_url = get_user_meta( $user->ID, 'tt_authorbox_image', true );
		/** just some check for backwards compatibility */
		if ( strpos( $thrive_url, 'TT_DEFAULT_AUTHORBOX_IMAGE' ) !== false ) {
			return $url;
		}

		if ( ! empty( $thrive_url ) ) {
			return $thrive_url;
		}
	}

	return $url;
}

/**
 *  Display navigation to next/previous comments when applicable.
 */
function thrive_theme_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
		echo "<div class='pgn clearfix'>";

		if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'thrive' ) ) ) {
			printf( '%s', $prev_link );
		}

		if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'thrive' ) ) ) {
			printf( '%s', $next_link );
		}

		echo "</div><!-- .nav-links -->";
	}
}

/**
 * return the previous comments page link's class
 *
 * @return string
 */
function thrive_get_previous_comments_link_attributes() {
	return 'class="prev page-numbers"';
}

/**
 * return the next comments page link's class
 *
 * @return string
 */
function thrive_get_next_comments_link_attributes() {
	return 'class="next page-numbers"';
}

add_action( 'wp_head', 'thrive_fb_comments_moderators' );

/**
 * output the meta tags needed for FB comments moderation tool
 *
 * <meta property="fb:admins" content="{YOUR_FACEBOOK_USER_ID}"/>
 *
 */
function thrive_fb_comments_moderators() {
	$fb_moderators = thrive_get_theme_options( 'fb_moderators' );
	$fb_app_id     = thrive_get_theme_options( 'fb_app_id' );

	if ( empty( $fb_moderators ) ) {
		return;
	}

	if ( ! is_singular() && ! is_front_page() && ! is_home() ) {
		return;
	}

	foreach ( $fb_moderators as $moderator ) {
		echo sprintf( '<meta property="fb:admins" content="%s"/>', $moderator );
	}

	echo sprintf( '<meta property="fb:app_id" content="%s"/>', $fb_app_id );

}
