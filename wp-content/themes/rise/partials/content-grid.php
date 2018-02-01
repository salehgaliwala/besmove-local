<?php
$options                          = thrive_get_theme_options();
$GLOBALS['thrive_theme_options']  = $options;
$options['enable_social_buttons'] = false;

switch ( _thrive_get_post_format() ) {
	case 'audio':
		$image_class = 'aa';
		break;
	case 'video':
		$image_class = 'vv';
		break;

	default:
		$image_class = '';
}

?>
<div class="gr-i">

	<?php if ( has_post_thumbnail() ): ?>
		<a class="fwit <?php echo $image_class; ?>" href="<?php the_permalink(); ?>"
		   style="background-image: url('<?php echo _thrive_get_featured_image_src( null, get_the_ID(), "large" ); ?>')"></a>
	<?php else: ?>
		<a class="fwit i-nf" href="<?php the_permalink(); ?>"
		   style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/default_featured.jpg')"></a>
	<?php endif; ?>

	<div class="awr">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<?php _thrive_render_default_meta_partial( get_the_ID(), $options ); ?>

		<p>
			<?php if ( has_excerpt() ): ?>
				<?php echo _thrive_get_post_text_content_excerpt( get_the_excerpt(), get_the_ID(), 200 ); ?>
			<?php else: ?>
				<?php echo _thrive_get_post_text_content_excerpt( get_the_content(), get_the_ID(), 200 ); ?>
			<?php endif; ?>
		</p>

		<?php $read_more_text = ( $options['other_read_more_text'] != "" ) ? $options['other_read_more_text'] : __( "Read more", 'thrive' ); ?>

		<a class="mrb" href="<?php the_permalink(); ?>">
			<span><?php echo $read_more_text; ?></span>
		</a>
	</div>

</div>