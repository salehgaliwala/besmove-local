<?php
$options             = thrive_get_options_for_post( get_the_ID() );
$post_format         = _thrive_get_post_format();
$template_name       = _thrive_get_item_template( get_the_ID() );
$post_format_options = _thrive_get_post_format_fields( $post_format, get_the_ID() );
$featured_image_src  = _thrive_get_featured_image_src( $options['featured_image_style'], get_the_ID() );
if ( isset( $options['meta_author_name'] ) && $options['meta_author_name'] == 1 ) {
	$author_info = _thrive_get_author_info( get_the_author_meta( 'ID' ) );
}

$featured_image_data  = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] );
$featured_image       = $featured_image_data['image_src'];
$featured_image_alt   = $featured_image_data['image_alt'];
$featured_image_title = $featured_image_data['image_title'];
?>

<div class="awr">

	<?php if ( $post_format == "quote" ): ?>
		<a class="quo">
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
	<?php endif; ?>

	<?php if ( $featured_image_src && ( ( $options['featured_image_style'] == "wide" && $post_format == "standard" ) || $post_format == "image" ) ): ?>
		<a class="fwit" style="background-image: url('<?php echo $featured_image_src; ?>')">
			<img src="<?php echo $featured_image_src; ?>" alt="<?php echo $featured_image_alt; ?>"
			     title="<?php echo $featured_image_title; ?>" class="tt-dmy"/>
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
				class="<?php if ( $post_format_options['video_type'] != "custom" && $post_format_options['video_type'] != "custom_embed" ): ?>rve<?php endif; ?> v-p">
				<?php echo $post_format_options['video_code']; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( $options['show_post_title'] != 0 ): ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	<?php endif; ?>
	<?php if ( $template_name != "Landing Page" ) {
		_thrive_render_default_meta_partial( get_the_ID(), $options );
	} ?>

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
		<div class="thi">
			<img src="<?php echo $featured_image_src; ?>" alt="<?php echo $featured_image_alt; ?>"
			     title="<?php echo $featured_image_title; ?>"/>
		</div>
	<?php endif; ?>
	<div class="awr-i">
		<?php the_content(); ?>
	</div>
	<div class="clear"></div>
	<?php
	wp_link_pages( array(
		'before'         => '<br><p class="ctr pgn">',
		'after'          => '</p>',
		'next_or_number' => 'next_and_number',
		'echo'           => 1
	) );
	?>

	<?php if ( isset( $options['bottom_about_author'] ) && $options['bottom_about_author'] == 1 ): ?>
		<?php get_template_part( "partials/authorbox" ); ?>
	<?php endif; ?>

	<?php
	if ( thrive_check_bottom_focus_area() ):
		thrive_render_top_focus_area( "bottom" );
	endif; ?>

	<?php _thrive_render_bottom_related_posts( get_the_ID(), $options ); ?>
	<?php
	$prev_post = get_adjacent_post( false, '', true );
	$next_post = get_adjacent_post( false, '', false );
	if ( isset( $options['bottom_previous_next'] ) && $options['bottom_previous_next'] == 1 && get_permalink( $prev_post ) != "" && get_permalink( $next_post ) != "" ):
		?>
		<div class="pnav">
			<a class="pav left" href="<?php echo get_permalink( $prev_post ); ?>">
				<span><?php _e( "Previous Post", 'thrive' ); ?></span>
				<span><?php echo get_the_title( $prev_post ); ?></span>
			</a>
			<a class="pav right" href="<?php echo get_permalink( $next_post ); ?>">
				<span><?php _e( "Next Post", 'thrive' ); ?></span>
				<span><?php echo get_the_title( $next_post ); ?></span>
			</a>
		</div>
	<?php endif; ?>
</div>

<?php if ( ! post_password_required() && ( ! is_page() || ( is_page() && $options['comments_on_pages'] != 0 ) ) ) : ?>
	<?php comments_template( '', true ); ?>
<?php elseif ( ( ! comments_open() ) && get_comments_number() > 0 ): ?>
	<?php comments_template( '/comments-disabled.php' ); ?>
<?php endif; ?>
