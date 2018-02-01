<?php
$options = thrive_get_theme_options();
if ( isset( $options['meta_author_name'] ) && $options['meta_author_name'] == 1 ) {
	$author_info = _thrive_get_author_info( get_the_author_meta( 'ID' ) );
}
$post_format         = _thrive_get_post_format();
$post_format_options = _thrive_get_post_format_fields( $post_format, get_the_ID() );

$featured_image_src = _thrive_get_featured_image_src( $options['featured_image_style'], get_the_ID() );

$featured_image_data  = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] );
$featured_image       = $featured_image_data['image_src'];
$featured_image_alt   = $featured_image_data['image_alt'];
$featured_image_title = $featured_image_data['image_title'];
?>
<?php if ( $post_format == "image" && $featured_image_src ): ?>
	<div class="awr imp">
		<a class="im-i" href="<?php the_permalink(); ?>"
		   style="background-image: url('<?php echo $featured_image_src; ?>');">
			<div class="im-t">
				<h2 class="entry-title"><?php the_title(); ?></h2>
			</div>
		</a>
	</div>
<?php elseif ( $post_format == "quote" ): ?>
	<div class="awr nbr">
		<a class="quo" href="<?php the_permalink(); ?>">
			<?php if ( $featured_image_src ): ?>
				<div class="qui" style="background-image: url('<?php echo $featured_image_src; ?>')"></div>
			<?php endif; ?>
			<div class="qut">
				<h4><?php echo $post_format_options['quote_text']; ?></h4>
				<?php if ( ! empty( $post_format_options['quote_author'] ) ): ?>
					<h6><strong><?php echo $post_format_options['quote_author']; ?></strong></h6>
				<?php endif; ?>
			</div>
		</a>
	</div>
<?php else: ?>
	<div class="awr">
		<?php if ( $featured_image_src && $options['featured_image_style'] == "wide" && $post_format == "standard" ): ?>
			<a class="fwit" href="<?php the_permalink(); ?>"
			   style="background-image: url('<?php echo $featured_image_src; ?>')">
				<img src="<?php echo $featured_image_src; ?>" alt="<?php echo $featured_image_alt; ?>"
				     title="<?php echo $featured_image_title; ?>"/>
			</a>
		<?php endif; ?>

		<?php if ( $post_format == "audio" && $featured_image_src ): ?>
			<div class="fwit ha" style="background-image: url('<?php echo $featured_image_src; ?>');">
				<div class="ap">
					<?php if ( $post_format_options['audio_type'] != "soundcloud" ): ?>
						<?php echo do_shortcode( "[audio src='" . $post_format_options['audio_file'] . "'][/audio]" ); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $post_format == "video" ): ?>
			<?php if ( ! empty( $post_format_options['video_code'] ) ): ?>
				<div
					class="<?php if ( $post_format_options['video_type'] != "custom" && $post_format_options['video_type'] != "custom_embed" ): ?>rve<?php endif; ?> pv vt fwit">
					<?php echo $post_format_options['video_code']; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<?php _thrive_render_default_meta_partial( get_the_ID(), $options ); ?>

		<?php if ( $post_format == "gallery" ): ?>
			<?php _thrive_render_gallery_format_partial( get_the_ID() ); ?>
		<?php endif; ?>

		<?php if ( ( $post_format == "audio" && ! $featured_image_src ) || ( $post_format == "audio" && $post_format_options['audio_type'] == "soundcloud" ) ): ?>
			<div class="ap">
				<?php if ( $post_format_options['audio_type'] != "soundcloud" ): ?>
					<?php echo do_shortcode( "[audio src='" . $post_format_options['audio_file'] . "'][/audio]" ); ?>
				<?php else: ?>
					<?php echo $post_format_options['audio_soundcloud_embed_code']; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $featured_image_src && $options['featured_image_style'] == "thumbnail" && $post_format == "standard" ): ?>
			<a class="thi" href="<?php the_permalink(); ?>">
				<img src="<?php echo $featured_image_src; ?>" alt="<?php echo $featured_image_alt; ?>"
				     title="<?php echo $featured_image_title; ?>"/>
			</a>
		<?php endif; ?>

		<?php if ( $options['other_show_excerpt'] != 1 ): ?>
			<?php the_content(); ?>
		<?php else: ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>

		<?php if ( $options['other_show_excerpt'] == 1 || $post_format == "quote" ): ?>
			<?php $read_more_text = ( $options['other_read_more_text'] != "" ) ? $options['other_read_more_text'] : "Read more"; ?>
			<?php if ( $options['other_read_more_type'] == "button" ): ?>
				<a href="<?php the_permalink(); ?>"
				   class="mrb <?php echo $options['color_scheme'] ?>"><span><?php echo $read_more_text ?></span></a>
			<?php else: ?>
				<a href='<?php the_permalink(); ?>' class='mre'><?php echo $read_more_text ?></a>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php endif; ?>