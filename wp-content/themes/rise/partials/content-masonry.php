<?php
$options                          = thrive_get_theme_options();
$GLOBALS['thrive_theme_options']  = $options;
$options['enable_social_buttons'] = false;
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
	<div class="mry-i">
		<div class="awr-e qt">
			<div class="awr imp">
				<a class="im-i" href="<?php the_permalink(); ?>"
				   style="background-image: url('<?php echo $featured_image_src; ?>');">
					<div class="im-t">
						<h2 class="entry-title"><?php the_title(); ?></h2>
					</div>
				</a>
			</div>
		</div>
	</div>
<?php elseif ( $post_format == "quote" ): ?>
	<div class="mry-i">
		<div class="awr-e qt">
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
	</div>
<?php else: ?>
	<div class="mry-i">
		<div class="awr-e">

			<?php if ( $post_format == "video" ): ?>
				<?php if ( ! empty( $post_format_options['video_code'] ) ): ?>
					<div
						class="<?php if ( $post_format_options['video_type'] != "custom" && $post_format_options['video_type'] != "custom_embed" ): ?>rve<?php endif; ?> pv vt">
						<?php echo $post_format_options['video_code']; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( $post_format == "gallery" ): ?>
				<?php _thrive_render_gallery_format_partial( get_the_ID() ); ?>
			<?php endif; ?>

			<?php if ( $featured_image_src && $post_format == "standard" ): ?>
				<a class="fwit" style="background-image: url('<?php echo $featured_image_src; ?>')"
				   href="<?php the_permalink() ?>">
					<img src="<?php echo $featured_image_src; ?>" alt="<?php echo $featured_image_alt; ?>"
					     title="<?php echo $featured_image_title; ?>"/>
				</a>
			<?php endif; ?>

			<?php if ( $post_format == "audio" && $featured_image_src ): ?>
				<div class="fwit ha" style="background-image: url('<?php echo $featured_image_src; ?>');">
					<?php if ( $post_format_options['audio_type'] != "soundcloud" ): ?>
						<div class="ap">
							<?php echo do_shortcode( "[audio src='" . $post_format_options['audio_file'] . "'][/audio]" ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="awr">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

				<?php _thrive_render_default_meta_partial( get_the_ID(), $options ); ?>

				<?php if ( ( $post_format == "audio" && ! $featured_image_src ) || ( $post_format == "audio" && $post_format_options['audio_type'] == "soundcloud" ) ): ?>
					<div class="ap">
						<?php if ( $post_format_options['audio_type'] != "soundcloud" ): ?>
							<?php echo do_shortcode( "[audio src='" . $post_format_options['audio_file'] . "'][/audio]" ); ?>
						<?php else: ?>
							<?php echo $post_format_options['audio_soundcloud_embed_code']; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

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
	</div>
<?php endif; ?>