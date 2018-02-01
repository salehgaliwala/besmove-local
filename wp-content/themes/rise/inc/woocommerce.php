<?php

add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-slider' );
add_theme_support( 'wc-product-gallery-lightbox' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'thrive_woo_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'thrive_woo_wrapper_end', 10 );

add_action( 'widgets_init', 'thrive_woo_register_sidebar' );

function thrive_woo_wrapper_start() {
	$options            = thrive_get_options_for_post( get_the_ID() );
	$main_content_class = ( $options['sidebar_alignement'] == "right" ) ? "left" : "right";
	$sidebar_is_active  = is_active_sidebar( 'sidebar-woo' );

	if ( ! $sidebar_is_active ) {
		$main_content_class = "fullWidth";
	}

	ob_start();
	get_template_part( 'partials/breadcrumbs' );
	$content = ob_get_contents();
	ob_end_clean();
	$thrive_woo_open_wrapper = $content;

	$thrive_woo_open_wrapper .= '<div class="wrp cnt">';

	if ( $sidebar_is_active ) {
		$thrive_woo_open_wrapper .= '<div class="bSeCont">';
	}

	$thrive_woo_open_wrapper .= '<section class="bSe ' . $main_content_class . '"><div class="awr"><div class="awr-i">';
	echo $thrive_woo_open_wrapper;

}

function thrive_woo_wrapper_end() {
	$sidebar_is_active        = is_active_sidebar( 'sidebar-woo' );
	$thrive_woo_close_wrapper = '</div></div></section>';

	if ( $sidebar_is_active ):
		$thrive_woo_close_wrapper .= '</div>';
	endif;

	echo $thrive_woo_close_wrapper;

}

function thrive_woo_register_sidebar() {

	register_sidebar( array(
		'name'          => __( 'Woo Commerce Sidebar', 'thrive' ),
		'id'            => 'sidebar-woo',
		'before_widget' => '<section id="%1$s"><div class="scn">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<p class="ttl">',
		'after_title'   => '</p>',
	) );

}

/*
 * Remove the default Woocommerce breadcrumbs and change the default arguments
 */
add_action( 'init', 'thrive_woo_remove_wc_breadcrumbs' );

function thrive_woo_remove_wc_breadcrumbs() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

add_filter( 'woocommerce_breadcrumb_defaults', 'thrive_woo_change_breadcrumb_defaults' );
function thrive_woo_change_breadcrumb_defaults( $defaults ) {
	return array(
		'delimiter'   => '<li class="separator"> <span> &raquo; </span> </li>',
		'wrap_before' => '<ul class="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">',
		'wrap_after'  => '</ul>',
		'before'      => '<li>',
		'after'       => '</li>',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	);

}

function thrive_woo_enqueue_frontend_scripts() {

	wp_register_script( 'thrive-woo-script', get_template_directory_uri() . '/js/woocommerce.js', array( 'jquery' ), "", true );
	wp_register_style( 'thrive-woo-style', get_template_directory_uri() . '/css/woocommerce.css', array(), '20120208', 'all' );

	if ( _thrive_check_is_woocommerce_page() || thrive_has_woo_shortcode() || is_search() ) {
		wp_enqueue_script( 'thrive-woo-script' );
		wp_enqueue_style( 'thrive-woo-style' );
	}
}

/**
 * Check if a pots/page has a woo commerce shortcode
 * @return bool
 */
function thrive_has_woo_shortcode() {
	$has_woo_shortcode = false;

	if ( is_singular() ) {
		global $post;

		$woo_shortcodes = array(
			'product',
			'product_page',
			'product_category',
			'product_categories',
			'add_to_cart',
			'add_to_cart_url',
			'products',
			'recent_products',
			'sale_products',
			'best_selling_products',
			'top_rated_products',
			'featured_products',
			'product_attribute',
			'related_products',
			'shop_messages',
			'woocommerce_order_tracking',
			'woocommerce_cart',
			'woocommerce_checkout',
			'woocommerce_my_account',
		);

		$has_tve = function_exists( 'tve_compat_has_shortcode' );

		foreach ( $woo_shortcodes as $sc_name ) {
			if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, $sc_name ) ) {
				$has_woo_shortcode = true;
			}

			if ( $has_tve && tve_compat_has_shortcode( $sc_name ) ) {
				$has_woo_shortcode = true;
			}
		}
	}

	return $has_woo_shortcode;
}

add_action( 'wp_enqueue_scripts', 'thrive_woo_enqueue_frontend_scripts' );
//unregister the default styles
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// Woocommerce cart dropdown
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<?php require_once( 'templates/woocommerce-navbar-mini-cart.php' ); ?>
	<?php
	$fragments['.mini-cart-contents'] = ob_get_clean();

	return $fragments;
}

// Add cart menu Item if on mobile
add_filter( 'wp_nav_menu_items', 'woo_mobile_menu_item', 10, 2 );
function woo_mobile_menu_item( $items, $args ) {
	if ( $args->theme_location == 'primary' || class_exists( 'WooCommerce' ) ) {
		$item = '<a href="' . wc_get_cart_url() . '">';
		$item .= sprintf( "%d - ", WC()->cart->cart_contents_count ) . _n( 'item', 'items', WC()->cart->cart_contents_count, 'thrive' );
		$item .= '</a>';

		return $items . "<li class='mobile-mini-cart'>" . $item . "</li>";
	}

	return $items;
}

/**
 * Woocommerce applies a filter for showing the page title
 * As we have an option for each post in post editor implementing this filter is a must
 */
add_filter( "woocommerce_show_page_title", 'thrive_woocommerce_show_page_title' );
function thrive_woocommerce_show_page_title( $show_title ) {

	if ( ! is_search() && ! is_tax() ) {
		$shop_page_id = wc_get_page_id( 'shop' );
		$meta         = get_post_meta( $shop_page_id, '_thrive_meta_show_post_title', true );
		$show_title   = $meta == 1;
	}

	return $show_title;
}
