<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-leads
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
}
?>
<div class="setting-item click" data-fn="tl_template_chooser">
	<?php tcb_icon( 'change_lp' ); ?>
	<?php echo __( 'Choose Opt-In Template', 'thrive-leads' ); ?>
</div>

<div class="setting-item click" data-fn="setting" data-setting="tl_template_save">
	<?php tcb_icon( 'save_usertemp' ); ?>
	<?php echo __( 'Save Template', 'thrive-cb' ); ?>
</div>

<div class="setting-item click" data-fn="tl_template_reset">
	<?php tcb_icon( 'reset_2default' ); ?>
	<?php echo __( 'Reset to default content', 'thrive-leads' ); ?>
</div>
