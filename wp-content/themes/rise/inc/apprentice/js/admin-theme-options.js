ThriveApprOptions = {};
jQuery(document).ready(function () {


    jQuery("#thrive_theme_options_appr_featured_title_bg_img_default_src_btn").on('click', ThriveThemeOptions.handle_file_upload);

    jQuery(".thrive_appr_featured_title_bg_type").click(ThriveApprOptions.display_featured_image_title_bg_type);
    ThriveApprOptions.display_featured_image_title_bg_type();


    ThriveApprOptions.display_header_color_options();

    jQuery("#thrive_custom_appr_featured_title_bg_img_trans").wpColorPicker({
        change: function (event, ui) {
            jQuery("#thrive_hidden_aprr_featured_title_bg_img_trans").val(jQuery("#thrive_custom_appr_featured_title_bg_img_trans").val());
        }
    });

    jQuery("#thrive_theme_options_appr_featured_title_bg_solid_color").wpColorPicker();

    jQuery("#thrive_theme_options_appr_featured_title_bg_solid_color_reset").click(function () {
        jQuery("#thrive_theme_options_appr_featured_title_bg_solid_color").wpColorPicker('color', "#ffffff");
    });


    jQuery("#thrive_select_appr_featured_title_bg_img_trans").change(function () {
        if (jQuery(this).val() == "none") {
            jQuery("#thrive_hidden_appr_featured_title_bg_img_trans").val("");
            jQuery('#thrive_custom_appr_featured_title_bg_img_trans_container').hide();
        } else if (jQuery(this).val() == "theme") {
            jQuery("#thrive_hidden_appr_featured_title_bg_img_trans").val(jQuery("#thrive_hidden_theme_color").val());
            jQuery('#thrive_custom_appr_featured_title_bg_img_trans_container').hide();
        } else if (jQuery(this).val() == "custom") {
            jQuery("#thrive_hidden_appr_featured_title_bg_img_trans").val(jQuery("#thrive_custom_appr_featured_title_bg_img_trans").val());
            jQuery('#thrive_custom_appr_featured_title_bg_img_trans_container').show();
        } else {
            jQuery("#thrive_hidden_appr_featured_title_bg_img_trans").val(jQuery(this).val());
            jQuery('#thrive_custom_appr_featured_title_bg_img_trans_container').hide();
        }
    });

    jQuery("#theme_options_enable_apprentice").click(function () {
        jQuery("#theme_options_hidden_appr_enable_feature").val(1);
        jQuery("#tt-submit-button").trigger("click");
    });

    jQuery("#theme_options_disable_apprentice").click(function () {
        jQuery("#theme_options_hidden_appr_enable_feature").val(0);
        jQuery("#tt-submit-button").trigger("click");
    });

    jQuery("#appr_logo_type_image").click(ThriveApprOptions.display_appr_logo_fields);
    jQuery("#appr_logo_type_text").click(ThriveApprOptions.display_appr_logo_fields);
    jQuery("#appr_different_logo_on").click(ThriveApprOptions.display_appr_logo_fields);
    jQuery("#appr_different_logo_off").click(ThriveApprOptions.display_appr_logo_fields);
    ThriveApprOptions.display_appr_logo_fields();

});


ThriveApprOptions.display_featured_image_title_bg_type = function () {
    var _selected_bg_val = jQuery(".thrive_appr_featured_title_bg_type:checked").val();
    if (_selected_bg_val == "image") {
        jQuery("#thrive_theme_options_appr_featured_title_bg_solid_color").parents("tr").hide();
        jQuery("#thrive_theme_options_appr_featured_title_bg_img_default_src").parents("tr").show();
        jQuery("#thrive_select_appr_featured_title_bg_img_trans").parents("tr").show();

    } else {
        jQuery("#thrive_theme_options_appr_featured_title_bg_solid_color").parents("tr").show();
        jQuery("#thrive_theme_options_appr_featured_title_bg_img_default_src").parents("tr").hide();
        jQuery("#thrive_select_appr_featured_title_bg_img_trans").parents("tr").hide();
    }
};


ThriveApprOptions.display_header_color_options = function () {

    var _bg_img_trans_color = jQuery("#thrive_hidden_appr_featured_title_bg_img_trans").val();

    var _is_theme_color = (jQuery("#thrive_hidden_theme_color").val() == _bg_img_trans_color);

    if (_is_theme_color) {
        jQuery('#thrive_select_appr_featured_title_bg_img_trans').val("theme");
    } else if (_bg_img_trans_color == "" || _bg_img_trans_color == "none") {
        jQuery('#thrive_select_appr_featured_title_bg_img_trans').val("none");
    } else if (_bg_img_trans_color == "dots" || _bg_img_trans_color == "blur") {
        jQuery('#thrive_select_appr_featured_title_bg_img_trans').val(_bg_img_trans_color);
        jQuery('#thrive_custom_appr_featured_title_bg_img_trans_container').hide();
    } else {
        jQuery('#thrive_select_appr_featured_title_bg_img_trans').val("custom");
        jQuery('#thrive_custom_appr_featured_title_bg_img_trans_container').show();
    }

};


ThriveApprOptions.display_appr_logo_fields = function () {
    var _use_different_logo = jQuery("#appr_different_logo_on:checked").val();

    if (!_use_different_logo) {
        jQuery("#appr_logo_position_image").parents("tr").hide();
        jQuery("#thrive_theme_options_appr_logo").parents("tr").hide();
        jQuery("#thrive_theme_options_appr_logo_text").parents("tr").hide();
        jQuery("#thrive_theme_options_appr_logo_color").parents("tr").hide();
        jQuery("#appr_logo_type_image").parents("tr").hide();
    } else {
        jQuery("#appr_logo_type_image").parents("tr").show();
        var _selected_appr_logo_val = jQuery("#appr_logo_type_image:checked").val();
        if (!_selected_appr_logo_val) {
            _selected_appr_logo_val = jQuery("#appr_logo_type_text:checked").val();
        }
        if (_selected_appr_logo_val == "text") {
            jQuery("#thrive_theme_options_appr_logo").parents("tr").hide();
            jQuery("#thrive_theme_options_appr_logo_text").parents("tr").show();
            jQuery("#thrive_theme_options_appr_logo_color").parents("tr").show();
        } else {
            jQuery("#thrive_theme_options_appr_logo").parents("tr").show();
            jQuery("#thrive_theme_options_appr_logo_text").parents("tr").hide();
            jQuery("#thrive_theme_options_appr_logo_color").parents("tr").hide();
        }
    }

};
