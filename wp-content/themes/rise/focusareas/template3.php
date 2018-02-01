<?php
$action_link_target = ( isset( $current_attrs['_thrive_meta_focus_new_tab'] ) && $current_attrs['_thrive_meta_focus_new_tab'][0] == 1 ) ? "_blank" : "_self";
?>

<div class="far fab f1 <?php echo $current_attrs['_thrive_meta_focus_color'][0]; ?>">
	<div class="fab-i">
		<div class="fl">
			<h3><?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?></h3>

			<p><?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?></p>
		</div>
		<div class="fr">
			<?php if ( ! empty( $current_attrs['_thrive_meta_focus_image'][0] ) ): ?>
				<img src="<?php echo $current_attrs['_thrive_meta_focus_image'][0]; ?>" alt="">
			<?php endif; ?>
			<a href="<?php echo $current_attrs['_thrive_meta_focus_button_link'][0]; ?>"
			   target="<?php echo $action_link_target; ?>"
			   class="btn small aligncenter <?php echo $current_attrs['_thrive_meta_focus_button_color'][0]; ?>">
				<span><?php echo $current_attrs['_thrive_meta_focus_button_text'][0]; ?></span>
			</a>
		</div>
	</div>
</div>