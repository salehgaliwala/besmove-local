<?php

function thrive_settings_field_header_phone( $value ) {
	$checked_on  = ( $value == 1 ) ? "checked" : "";
	$checked_off = ( $value == 0 ) ? "checked" : "";
	echo "<input class='toggle toggle-left thrive_header_phone_chk' type='radio' id='header_phone_true' name='thrive_theme_options[header_phone]' value='1' $checked_on />
    <label for='header_phone_true' class='btn'>" . __( 'On', 'thrive' ) . "</label>";
	echo "<input class='toggle toggle-right thrive_header_phone_chk' type='radio' id='header_phone_false' name='thrive_theme_options[header_phone]' value='0' $checked_off />
    <label for='header_phone_false' class='btn'>" . __( 'Off', 'thrive' ) . "</label>";
}

function thrive_settings_field_header_phone_no( $value ) {
	echo "<input type='text' name='thrive_theme_options[header_phone_no]' id='thrive_theme_options_header_phone_no' value='" . esc_attr( $value ) . "' />";
}

function thrive_settings_field_header_phone_text( $value ) {
	echo "<input value='" . esc_attr( $value ) . "' type='text' name='thrive_theme_options[header_phone_text]' id='thrive_theme_options_header_phone_text' />";
}

function thrive_settings_field_header_phone_text_mobile( $value ) {
	echo "<input value='" . esc_attr( $value ) . "' type='text' name='thrive_theme_options[header_phone_text_mobile]' id='thrive_theme_options_header_phone_text_mobile' />";
}


function thrive_settings_field_header_phone_btn_color( $value ) {
	$colors = _thrive_get_color_scheme_options();
	$colors = array_merge( array( 'default' => __( "Default", 'thrive' ) ), $colors );
	echo "<select name='thrive_theme_options[header_phone_btn_color]' id='thrive_theme_options_header_phone_btn_color'>";
	foreach ( $colors as $key => $c ) {
		$is_selected = ( $key == $value ) ? " selected" : "";
		echo "<option value='" . $key . "'" . $is_selected . ">" . $c . "</option>";
	}
}

function thrive_settings_field_featured_title_bg_type( $value ) {
	$checked_img   = ( $value == "image" ) ? "checked" : "";
	$checked_color = ( $value == "color" ) ? "checked" : "";

	echo "<input class='toggle toggle-left thrive_featured_title_bg_type' type='radio' id='featured_title_bg_type_image' name='thrive_theme_options[featured_title_bg_type]' value='image' $checked_img />
    <label for='featured_title_bg_type_image' class='btn'>" . __( 'Image', 'thrive' ) . "</label>";
	echo "<input class='toggle toggle-right thrive_featured_title_bg_type' type='radio' id='featured_title_bg_type_color' name='thrive_theme_options[featured_title_bg_type]' value='color' $checked_color />
    <label for='featured_title_bg_type_color' class='btn'>" . __( 'Color', 'thrive' ) . "</label>";
}

function thrive_settings_field_featured_title_bg_img_static( $value ) {
	$checked_default = ( $value != 'static' ) ? "checked" : "";
	$checked_static  = ( $value == 'static' ) ? "checked" : "";
	echo "<input class='thrive_featured_title_bg_img_static' type='radio' name='thrive_theme_options[featured_title_bg_img_static]' value='default' $checked_default /> " . __( 'Default', 'thrive' ) . "";
	echo "<input class='thrive_featured_title_bg_img_static' type='radio' name='thrive_theme_options[featured_title_bg_img_static]' value='static' $checked_static /> " . __( 'Static', 'thrive' ) . "";
}

function thrive_settings_field_featured_title_bg_img_full_height( $value ) {
	$checked_off = ( $value != 'on' ) ? "checked" : "";
	$checked_on  = ( $value == 'on' ) ? "checked" : "";
	echo "<input class='thrive_featured_title_bg_img_full_height' type='radio' name='thrive_theme_options[featured_title_bg_img_full_height]' value='off' $checked_off /> " . __( 'Off', 'thrive' ) . "";
	echo "<input class='thrive_featured_title_bg_img_full_height' type='radio' name='thrive_theme_options[featured_title_bg_img_full_height]' value='on' $checked_on /> " . __( 'On', 'thrive' ) . "";
}

function thrive_settings_field_featured_title_bg_img_trans( $value ) {
	$scheme_options = thrive_get_default_customizer_options();
	echo "<input type='hidden' name='thrive_theme_options[featured_title_bg_img_trans]' value='" . $value . "' id='thrive_hidden_featured_title_bg_img_trans' />";
	echo "<input type='hidden' id='thrive_hidden_theme_color' value='" . $scheme_options['thrivetheme_link_color'] . "' />";
	echo "<select id='thrive_select_featured_title_bg_img_trans'>";
	echo "<option value='none'>" . __( "None", 'thrive' ) . "</option>";
	echo "<option value='theme'>" . __( "Theme color", 'thrive' ) . "</option>";
	echo "<option value='custom'>" . __( "Custom color", 'thrive' ) . "</option>";
	echo "<option value='dots'>" . __( "Dots Wide", 'thrive' ) . "</option>";
	echo "<option value='dots_narrow'>" . __( "Dots Narrow", 'thrive' ) . "</option>";
	echo "<option value='blur'>" . __( "Blur", 'thrive' ) . "</option>";
	echo "</select>";
	echo "<div style='display:none;' id='thrive_custom_featured_title_bg_img_trans_container'><input type='text' id='thrive_custom_featured_title_bg_img_trans' value='" . esc_attr( $value ) . "'/></div>";

}

function thrive_settings_field_featured_title_bg_solid_color( $value ) {
	$scheme_options = thrive_get_default_customizer_options();
	echo "<input type='text' name='thrive_theme_options[featured_title_bg_solid_color]' id='thrive_theme_options_featured_title_bg_solid_color'
        value='" . esc_attr( $value ) . "' data-default-color='" . $scheme_options['thrivetheme_link_color'] . "' />";
	echo "<input class='thrive_options pure-button clear-field remove' type='button' id='thrive_theme_options_featured_title_bg_solid_color_reset' value='" . __( "Clear", 'thrive' ) . "' />";
}

function thrive_settings_field_featured_title_bg_img_default_src( $value ) {
	echo "<input class='thrive_options' type='text' name='thrive_theme_options[featured_title_bg_img_default_src]' id='thrive_theme_options_featured_title_bg_img_default_src' value='" . esc_attr( $value ) . "' /><br/>";
	echo "<input class='thrive_options pure-button upload' type='button' id='thrive_theme_options_featured_title_bg_img_default_src_btn' value=' " . __( "Upload" ) . " ' />";
	echo "<input class='thrive_options pure-button clear-field remove' type='button' id='thrieve_theme_btn_delete_featured_title_bg_img_default_src' value=' " . __( "Remove" ) . " ' />";
}

function thrive_settings_field_featured_title_bg_color_type( $value ) {

	$checked_light = ( $value == "light" ) ? "checked" : "";
	$checked_dark  = ( $value == "dark" ) ? "checked" : "";

	echo "<input class='toggle toggle-left thrive_featured_title_bg_color_type' type='radio' id='featured_title_bg_color_type_light' name='thrive_theme_options[featured_title_bg_color_type]' value='light' $checked_light />
    <label for='featured_title_bg_color_type_light' class='btn'>" . __( 'Light', 'thrive' ) . "</label>";
	echo "<input class='toggle toggle-right featured_title_bg_color_type' type='radio' id='featured_title_bg_color_type_dark' name='thrive_theme_options[featured_title_bg_color_type]' value='dark' $checked_dark />
    <label for='featured_title_bg_color_type_dark' class='btn'>" . __( 'Dark', 'thrive' ) . "</label>";
}

function thrive_settings_field_404_custom_text( $value ) {
	wp_editor( $value, 'thrive_theme_options_404_custom_text', array( 'textarea_name' => 'thrive_theme_options[404_custom_text]' ) );
}

function thrive_settings_field_404_display_sitemap( $value ) {
	$checked_off = ( $value != 'on' ) ? "checked" : "";
	$checked_on  = ( $value == 'on' ) ? "checked" : "";
	echo "<input class='thrive_404_display_sitemap' type='radio' name='thrive_theme_options[404_display_sitemap]' value='off' $checked_off /> " . __( 'Off', 'thrive' ) . "";
	echo "<input class='thrive_404_display_sitemap' type='radio' name='thrive_theme_options[404_display_sitemap]' value='on' $checked_on /> " . __( 'On', 'thrive' ) . "";
}


function thrive_settings_field_related_no_text( $value ) {
	echo "<input value='" . esc_attr( $value ) . "' type='text' name='thrive_theme_options[related_no_text]' id='thrive_theme_options_related_no_text' />";
}

function thrive_settings_field_related_number_posts( $value ) {
	echo "<select id='thrive_theme_options_related_number_posts' name='thrive_theme_options[related_number_posts]'>";
	for ( $index = 5; $index <= 20; $index ++ ) {
		$selected_txt = ( $value == $index ) ? " selected" : "";
		echo "<option" . $selected_txt . ">" . $index . "</option>";
	}
	echo "</select>";
}


function thrive_settings_field_related_ignore_cats( $value ) {
	$all_categories   = get_categories();
	$categories_array = array();

	foreach ( $all_categories as $cat ) {
		array_push( $categories_array, array( 'id' => $cat->cat_ID, 'name' => $cat->cat_name ) );
	}

	$values       = json_decode( $value );
	$values_array = ! empty( $values ) ? $values : array();
	echo "<select id='sel_thrive_theme_options_related_ignore_cats' style='width:300px;' multiple>";
	foreach ( $categories_array as $cat ) {
		$selected_txt = ( in_array( $cat['id'], $values_array ) ) ? " selected" : "";
		echo "<option value='" . $cat['id'] . "'" . $selected_txt . ">" . $cat['name'] . "</option>";
	}
	echo "</selected>";
	echo "<input type='hidden' id='thrive_theme_options_related_ignore_cats' name='thrive_theme_options[related_ignore_cats]' value='" . $value . "' />";
}

function thrive_settings_field_related_ignore_tags( $value ) {
	$all_tags   = get_tags();
	$tags_array = array();

	foreach ( $all_tags as $tag ) {
		array_push( $tags_array, array( 'id' => $tag->term_id, 'name' => $tag->name ) );
	}
	$values       = json_decode( $value );
	$values_array = ! empty( $values ) ? $values : array();
	echo "<select id='sel_thrive_theme_options_related_ignore_tags' style='width:300px;' multiple>";
	foreach ( $tags_array as $tag ) {
		$selected_txt = ( in_array( $tag['id'], $values_array ) ) ? " selected" : "";
		echo "<option value='" . $tag['id'] . "'" . $selected_txt . ">" . $tag['name'] . "</option>";
	}
	echo "</selected>";
	echo "<input type='hidden' id='thrive_theme_options_related_ignore_tags' name='thrive_theme_options[related_ignore_tags]' value='" . $value . "' />";
}


function thrive_settings_field_blog_layout( $options ) {
	if ( ! isset( $options['blog_layout'] ) ) {
		$options['blog_layout'] = "default";
	}
	$checked_1 = ( $options['blog_layout'] == 'default' ) ? "checked" : "";
	$checked_2 = ( $options['blog_layout'] == 'full_width' ) ? "checked" : "";
	$checked_3 = ( $options['blog_layout'] == 'grid_full_width' ) ? "checked" : "";
	$checked_4 = ( $options['blog_layout'] == 'grid_sidebar' ) ? "checked" : "";
	$checked_5 = ( $options['blog_layout'] == 'masonry_full_width' ) ? "checked" : "";
	$checked_6 = ( $options['blog_layout'] == 'masonry_sidebar' ) ? "checked" : "";
	$checked_7 = ( $options['blog_layout'] == 'narrow' ) ? "checked" : "";

	echo "<input type='radio' name='thrive_theme_options[blog_layout]' class='thrive_theme_options_blog_layout_radio' value='default' $checked_1 /> " . __( 'Default', 'thrive' ) . "";
	echo "<input type='radio' name='thrive_theme_options[blog_layout]' class='thrive_theme_options_blog_layout_radio' value='full_width' $checked_2 /> " . __( 'Full Width', 'thrive' ) . "";
	echo "<input type='radio' name='thrive_theme_options[blog_layout]' class='thrive_theme_options_blog_layout_radio' value='narrow' $checked_7 /> " . __( 'Narrow', 'thrive' ) . "";
	echo "<input type='radio' name='thrive_theme_options[blog_layout]' class='thrive_theme_options_blog_layout_radio' value='grid_full_width' $checked_3 /> " . __( 'Grid Full Width', 'thrive' ) . "";
	echo "<input type='radio' name='thrive_theme_options[blog_layout]' class='thrive_theme_options_blog_layout_radio' value='grid_sidebar' $checked_4 /> " . __( 'Grid Sidebar', 'thrive' ) . "";
	echo "<input type='radio' name='thrive_theme_options[blog_layout]' class='thrive_theme_options_blog_layout_radio' value='masonry_full_width' $checked_5 /> " . __( 'Masonry Full Width', 'thrive' ) . "";
	echo "<input type='radio' name='thrive_theme_options[blog_layout]' class='thrive_theme_options_blog_layout_radio' value='masonry_sidebar' $checked_6 /> " . __( 'Masonry Sidebar', 'thrive' ) . "";
}

?>