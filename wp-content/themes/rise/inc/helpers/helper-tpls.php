<?php

function _thrive_get_page_template_privacy() {
	$options = array(
		'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
		'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
		'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
		'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
	);

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/privacy.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_disclaimer() {

	$options = array(
		'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
		'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
		'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
		'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
	);

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/disclaimer.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_lead_gen( $optin_id = 0 ) {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/lead_gen.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_video_lead_gen( $optin_id = 0 ) {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/video_lead_gen.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_download_page() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/download_page.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}


function _thrive_get_page_template_email_confirmation() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/email_confirmation.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_homepage( $optin_id = 0 ) {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/homepage.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_sales() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/sales.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}


function _thrive_get_lorem_ipsum_post_content() {
	$content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean volutpat lacus sit amet hendrerit cursus. Mauris id justo et nunc tempus dictum. Aenean vestibulum id neque ac sollicitudin. Praesent hendrerit nisl vitae tellus fringilla, in condimentum risus vehicula. Etiam quis luctus sem. Nulla sed tempor augue. Cras ac neque egestas, ultrices metus in, eleifend felis. Nullam laoreet ac felis in mattis.

Sed nulla erat, viverra nec orci vel, lacinia suscipit ligula. Proin diam tortor, porttitor eu enim vel, porttitor tempor ante. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed a arcu sed elit placerat accumsan rutrum non erat. Cras hendrerit metus eget mattis suscipit. Etiam scelerisque dui id purus gravida, molestie vulputate libero fermentum. Suspendisse potenti. Pellentesque tristique odio quis tellus auctor malesuada. Aenean vestibulum in enim a varius. Quisque tellus diam, viverra eget libero eget, malesuada mollis quam. Vivamus auctor pharetra placerat. Quisque sagittis commodo elit, vestibulum cursus nisl accumsan pulvinar. Praesent consequat mollis quam ut aliquet. Pellentesque nulla enim, tempor eu egestas sed, posuere ut purus. Morbi ultricies arcu a dapibus euismod.

Etiam mattis quis tortor id luctus. Ut aliquam odio eu velit interdum tincidunt. Etiam semper leo id eros gravida tempor. Curabitur posuere erat lectus, a ultricies ipsum scelerisque eu. Curabitur tempus varius massa nec dignissim. Phasellus pretium a risus condimentum porta. Nam eu urna velit. Nulla vitae molestie nisl. Aliquam posuere rhoncus tortor, eu laoreet massa imperdiet nec.

Morbi justo turpis, placerat vel lectus id, ultrices ultrices eros. Praesent molestie dolor non est ultrices interdum. Nunc pellentesque pharetra ligula, quis commodo mi luctus vitae. Aenean et nulla ut nibh molestie adipiscing id vitae mauris. Phasellus vitae tellus accumsan, mattis urna at, euismod leo. Aenean aliquet egestas erat, nec fringilla tellus imperdiet sed. Maecenas nisi augue, placerat molestie bibendum eu, congue in nisl.

Cras nec mi euismod velit consectetur sagittis. Mauris sollicitudin massa vitae nisl scelerisque, sed adipiscing ante fermentum. Aenean odio arcu, consequat vitae scelerisque ut, rutrum id lectus. Donec dolor ipsum, porttitor et quam tincidunt, commodo placerat dui. Fusce commodo orci ac quam iaculis, eu dignissim odio accumsan. Mauris sed condimentum erat. Sed tincidunt, magna ut ultrices feugiat, massa ante vulputate augue, a porttitor lectus diam eget sem. Etiam sit amet tincidunt massa. Duis accumsan non nibh vitae venenatis. Cras nec lectus massa. Cras at diam in nisl vestibulum consequat sed quis risus. Aenean eu arcu tortor.";

	return $content;
}

function _thrive_get_page_template_tcb_privacy() {
	$options = array(
		'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
		'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
		'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
		'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
	);

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/privacy.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_disclaimer() {

	$options = array(
		'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
		'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
		'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
		'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
	);

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/disclaimer.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_lead_gen( $optin_id = 0 ) {
	$config_optin = json_encode( array(
		'optin'  => $optin_id,
		'color'  => 'orange',
		'size'   => 'medium',
		'text'   => 'Subscribe',
		'layout' => 'horizontal'
	) );
	$images_dir   = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/lead_gen.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_email_confirmation() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/email_confirmation.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_video_lead_gen( $optin_id = 0 ) {
	$config_optin = json_encode( array(
		'optin'  => $optin_id,
		'color'  => 'orange',
		'size'   => 'medium',
		'text'   => 'Subscribe Now',
		'layout' => 'vertical'
	) );
	$images_dir   = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/video_lead_gen.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_homepage( $optin_id = 0 ) {
	$config_optin = json_encode( array(
		'optin'  => $optin_id,
		'color'  => 'red',
		'size'   => 'small',
		'text'   => 'CONNECT WITH US!',
		'layout' => 'horizontal'
	) );
	//
	$config_post_grid = json_encode( array(
		"tve_lb_type"    => "tve_post_grid",
		"text_type"      => "summary",
		"post_types"     => array(
			"post"              => "true",
			"page"              => "false",
			"attachment"        => "false",
			"product"           => "false",
			"product_variation" => "false",
			"shop_order"        => "false",
			"shop_order_refund" => "false",
			"shop_coupon"       => "false",
			"shop_webhook"      => "false"
		),
		"posts_per_page" => "6",
		"posts_start"    => 0,
		"orderby"        => "date",
		"order"          => "DESC",
		"recent_days"    => "0",
		"filters"        => array( "category" => "", "tag" => "", "tax" => "", "author" => "", "posts" => "" ),
		"columns"        => "3",
		"display"        => "grid",
		"layout"         => array( "featured_image", "title", "text" ),
		"security"       => "194c4b3392",
		"action"         => "tve_do_post_grid_shortcode",
		"exclude"        => "2313",
		"teaser_layout"  => array(
			"featured_image" => "true",
			"title"          => "true",
			"text"           => "true",
			"read_more"      => "true"
		),
	) );
	$images_dir       = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/homepage.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_sales() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/sales.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_download_page() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/download_page.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}
