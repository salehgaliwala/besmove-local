<?php
$focus_area_class     = $current_attrs['_thrive_meta_focus_color'][0];
$section_position     = ( $position == "bottom" ) ? "fab" : "fat";
$form_container_class = ( count( $optinFieldsArray ) <= 4 ) ? "i" . count( $optinFieldsArray ) : "i4";
?>
<div class="far fab f4 <?php echo $current_attrs['_thrive_meta_focus_color'][0]; ?>">
	<div class="fab-i">
		<div class="fl">
			<?php if ( ! empty( $current_attrs['_thrive_meta_focus_image'][0] ) ): ?>
				<img src="<?php echo $current_attrs['_thrive_meta_focus_image'][0]; ?>" alt=""/>
			<?php endif; ?>
		</div>
		<div class="fr">
			<h3><?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?></h3>

			<p><?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?></p>
		</div>
	</div>
	<div class="frm <?php echo $form_container_class; ?>">
		<form action="<?php echo $optinFormAction; ?>" method="<?php echo $optinFormMethod ?>">

			<?php echo $optinHiddenInputs; ?>

			<?php echo $optinNotVisibleInputs; ?>

			<?php if ( $optinFieldsArray ): ?>
				<?php foreach ( $optinFieldsArray as $name_attr => $field_label ): ?>
					<?php echo Thrive_OptIn::getInstance()->getInputHtml( $name_attr, $field_label ); ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="btn <?php echo strtolower( $current_attrs['_thrive_meta_focus_button_color'][0] ); ?> small">
				<input type="submit" value="<?php echo $current_attrs['_thrive_meta_focus_button_text'][0]; ?>"/>
				<?php echo $optinHiddenInputs; ?>
			</div>
		</form>
	</div>
</div>