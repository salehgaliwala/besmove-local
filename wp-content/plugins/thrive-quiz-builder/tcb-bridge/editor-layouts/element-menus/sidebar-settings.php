<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

global $variation;
if ( empty( $variation ) ) {
	$variation = tqb_get_variation( $_REQUEST[ Thrive_Quiz_Builder::VARIATION_QUERY_KEY_NAME ] );
}
$page_type_name = tqb()->get_style_page_name( $variation['post_type'] );
?>

<div class="settings-list col-xs-12" data-list="templates" style="display: none;">
	<div class="setting-item click" data-fn="setting" data-setting="tqb_choose_template">
		<?php tcb_icon( 'change_lp' ); ?>
		<?php echo sprintf( __( 'Change %s Template', Thrive_Quiz_Builder::T ), $page_type_name ); ?>
	</div>
	<div class="setting-item click" data-fn="setting" data-setting="tqb_save_template">
		<?php tcb_icon( 'save_usertemp' ); ?>
		<?php echo sprintf( __( 'Save %s Template', Thrive_Quiz_Builder::T ), $page_type_name ); ?>
	</div>
	<div class="setting-item click" data-fn="setting" data-setting="tqb_reset_template">
		<?php tcb_icon( 'revert2theme' ); ?>
		<?php echo sprintf( __( 'Reset %s Template', Thrive_Quiz_Builder::T ), $page_type_name ); ?>
	</div>
</div>
