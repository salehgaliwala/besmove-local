<div class="row middle-xs tve-header-tabs">
	<div class="col-xs-6 tve-tab active click" data-fn="tab_click" data-list="settings">
		<span>
			<?php echo __( 'Settings', 'thrive-cb' ); ?>
		</span>
	</div>
	<?php if ( tcb_editor()->has_templates_tab() ) : ?>
		<div class="col-xs-6 tve-tab click" data-fn="tab_click" data-list="templates">
			<span>
				<?php echo apply_filters( 'tcb_templates_tab_name', __( 'Template Setup', 'thrive-cb' ) ); ?>
			</span>
		</div>
	<?php endif ?>
</div>

<div class="tabs-content row">
	<div class="settings-list col-xs-12" data-list="settings">
		<?php if ( TCB_Editor::instance()->can_use_page_events() ) : ?>
			<div class="setting-item click" data-fn="setting" data-setting="page_events">
				<?php tcb_icon( 'event_manager' ); ?>
				<?php echo __( 'Setup Page Events', 'thrive-cb' ); ?>
			</div>
		<?php endif ?>
		<div class="setting-item click" data-fn="setting" data-setting="edit_html">
			<?php tcb_icon( 'custom_html2' ); ?>
			<?php echo __( 'Edit HTML', 'thrive-cb' ); ?>
		</div>
		<div class="setting-item click" data-fn="setting" data-setting="custom_css">
			<?php tcb_icon( 'css' ); ?>
			<?php echo __( 'Custom CSS', 'thrive-cb' ); ?>
		</div>
		<div class="setting-item click" data-fn="setting" data-setting="reminders">
			<?php tcb_icon( 'notif_off' ); ?>
			<?php echo __( 'Turn ', 'thrive-cb' ) . '<span></span>' . __( ' Save Reminders', 'thrive-cb' ); ?>
		</div>
		<div class="setting-item click" data-fn="setting" data-setting="editor_side">
			<?php tcb_icon( 'switch_side' ); ?>
			<?php echo __( 'Switch Editor Side', 'thrive-cb' ); ?>
		</div>
	</div>
	<div class="settings-list col-xs-12" data-list="templates" style="display: none;">
		<?php if ( tcb_editor()->can_use_landing_pages() ) : ?>
			<div class="setting-item click lp-only" data-fn="setting" data-setting="lp_settings">
				<?php tcb_icon( 'lp_settings' ); ?>
				<?php echo __( 'Landing Page Settings', 'thrive-cb' ); ?>
			</div>
			<div class="setting-item click lp-only" data-fn="setting" data-setting="save_template_lp">
				<?php tcb_icon( 'save_usertemp' ); ?>
				<?php echo __( 'Save Landing Page', 'thrive-cb' ); ?>
			</div>
			<div class="setting-item click" data-fn="setting" data-setting="change_lp">
				<?php tcb_icon( 'change_lp' ); ?>
				<?php echo __( 'Change Landing Page Template', 'thrive-cb' ); ?>
			</div>
			<div class="setting-item click" data-fn="setting" data-setting="import_lp">
				<?php tcb_icon( 'import_lp' ); ?>
				<?php echo __( 'Import Landing Page', 'thrive-cb' ); ?>
			</div>
			<div class="setting-item click lp-only" data-fn="setting" data-setting="export_lp">
				<?php tcb_icon( 'export_lp' ); ?>
				<?php echo __( 'Export Landing Page', 'thrive-cb' ); ?>
			</div>
			<div class="setting-item click lp-only" data-fn="setting" data-setting="revert">
				<?php tcb_icon( 'revert2theme' ); ?>
				<?php echo __( 'Revert to Theme', 'thrive-cb' ); ?>
			</div>
			<div class="setting-item click lp-only" data-fn="setting" data-setting="reset">
				<?php tcb_icon( 'reset_2default' ); ?>
				<?php echo __( 'Reset to Default', 'thrive-cb' ); ?>
			</div>
		<?php endif ?>
		<?php if ( tcb_editor()->is_lightbox() ) : ?>
			<div class="setting-item click" data-fn="lightbox_settings">
				<?php tcb_icon( 'lp_settings' ); ?>
				<?php echo __( 'Thrive Lightbox Settings', 'thrive-cb' ); ?>
			</div>
		<?php endif ?>
		<div class="setting-item click not-lp" data-fn="save_template">
			<?php tcb_icon( 'content_templates' ); ?>
			<?php echo __( 'Save Content as Template', 'thrive-cb' ); ?>
		</div>
		<?php
		/**
		 * Action hook. Allows injecting custom menu options under the "Templates Setup" tab
		 */
		do_action( 'tcb_templates_setup_menu_items' )
		?>
	</div>
</div>

<div class="tve-custom-code-wrapper">
	<pre id="tve-custom-css-code"></pre>
	<div class="code-expand"><?php tcb_icon( 'a_up' ); ?></div>
	<div class="code-close"><?php tcb_icon( 'close' ); ?></div>
</div>
<div class="tve-editor-html-wrapper full-width">
	<pre id="tve-custom-html-code"></pre>
	<div class="tve-code-buttons-wrapper">
		<div class="code-button-check"><?php tcb_icon( 'check' ); ?></div>
		<div class="code-button-close"><?php tcb_icon( 'close' ); ?></div>
	</div>
</div>
