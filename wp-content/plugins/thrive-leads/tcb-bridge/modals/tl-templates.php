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

<h2 class="tcb-modal-title"><?php echo __( 'Choose the template you would like to use for this form', 'thrive-leads' ) ?></h2>

<div class="tve-templates-wrapper">
	<div class="tve-header-tabs">
		<div class="tab-item active" data-content="default"><?php echo __( 'OptIn Templates', 'thrive-leads' ); ?></div>
		<div class="tab-item" data-content="saved"><?php echo __( 'Saved Templates', 'thrive-leads' ); ?></div>
	</div>
	<div class="tve-tabs-content">
		<div class="tve-tab-content active" data-content="default">
			<div class="tve-default-templates-list expanded-set"></div>
		</div>
		<div class="tve-tab-content" data-content="saved">
			<p><?php echo __( 'Choose from your saved templates', 'thrive-leads' ) ?></p>
			<label>
				<input id="tl-filter-current-templates" class="click" data-fn="render_saved_templates" type="checkbox">
				<?php echo __( 'Show only saved versions of the current template', 'thrive-leads' ) ?>
			</label>
			<div class="tve-saved-templates-list expanded-set"></div>
		</div>
	</div>
</div>

<div class="tcb-modal-footer clearfix padding-top-20 row end-xs">
	<div class="col col-xs-12">
		<button type="button" class="tcb-right tve-button medium green tcb-modal-save">
			<?php echo __( 'Choose Template', 'thrive-leads' ) ?>
		</button>
	</div>
</div>
