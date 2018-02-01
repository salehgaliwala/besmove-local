<?php global $variation;
if (empty( $is_ajax_render )) : /** if AJAX-rendering the contents, we need to only output the html part, and do not include any of the custom css / fonts etc needed - used in the state manager */
do_action( 'get_header' ) ?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<?php
include plugin_dir_path( __FILE__ ) . 'head.php';
$state_manager_collapsed = ! empty( $_COOKIE['tve_leads_state_collapse'] );
?>
<body <?php body_class( $state_manager_collapsed ? 'tl-state-collapse' : '' ) ?>>
<div style="display: none" class="bSe"></div>
<?php endif ?>

<?php
/** the following section is always rendered */
$key       = '';
$hide_form = tve_leads_check_variation_visibility( $variation );
if ( ! empty( $variation[ TVE_LEADS_FIELD_TEMPLATE ] ) ) {
	list( $type, $key ) = explode( '|', $variation[ TVE_LEADS_FIELD_TEMPLATE ] );
	$key = preg_replace( '#_v(.+)$#', '', $key );
} ?>
<div class="tve-leads-conversion-object">
	<div id="tve-leads-editor-replace">
		<?php include dirname( __FILE__ ) . '/_no_form.php'; ?>
		<div class="tve-leads-greedy-ribbon" <?php if ( $hide_form ): ?>style="display: none;"<?php endif; ?>>
			<div class="tl-style" id="tve_<?php echo $key ?>" data-state="<?php echo $variation['key'] ?>">
				<?php echo apply_filters( 'tve_editor_custom_content', null ) ?>
			</div>
			<?php echo apply_filters( 'tve_leads_variation_append_states', '', $variation ); ?>
		</div>
	</div>
</div>
<?php if ( empty( $is_ajax_render ) ) : ?>
<div id="tve_page_loader" class="tve_page_loader">
	<div class="tve_loader_inner"><img src="<?php echo tve_editor_css() ?>/images/loader.gif" alt=""/></div>
</div>
<?php do_action( 'get_footer' ) ?>
<?php wp_footer() ?>
</body>
</html>
<?php endif ?>