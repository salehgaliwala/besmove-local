<?php $templates = tvo_get_testimonial_templates( 'display' ); ?>
<div class="tvo-frontend-modal">
	<h4>
		<?php echo __( 'Testimonial Display Templates', TVO_TRANSLATE_DOMAIN ) ?>
	</h4>
	<hr class="tve_lightbox_line">
	<div class="tvo_display_templates tvo-templates">
			<?php foreach ( $templates as $file => $template ) : ?>
				<div class="tvo-template click" data-fn="select" data-value="<?php echo $file; ?>">
					<div class="tvo-template-thumbnail click" style="background-image: url('<?php echo $template['thumbnail'] ?>');"></div>
					<div class="tvo-template-name">
						<?php echo $template['name'] ?>
					</div>
					<div class="selected"></div>
				</div>
			<?php endforeach ?>
	</div>
	<div class="tve-sp"></div>
	<button class="tve-button green click tvd-right tvo-save-template" data-fn="save">
		<?php echo __( 'Save', TVO_TRANSLATE_DOMAIN ); ?>
	</button>
</div>
