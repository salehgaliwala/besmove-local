<?php
$options = thrive_get_options_for_post( get_the_ID() );
if ( $options['sidebar_alignement'] == "right" ) {
	$main_content_class = "left";
} elseif ( $options['sidebar_alignement'] == "left" ) {
	$main_content_class = "right";
} else {
	$main_content_class = "fullWidth";
}
$sidebar_is_active = _thrive_is_active_sidebar( $options );
if ( ! $sidebar_is_active ) {
	$main_content_class = "fullWidth";
}

get_header();

if ( have_posts() ):
	while ( have_posts() ):

		the_post();

		get_template_part( 'partials/breadcrumbs' ); ?>

		<div class="wrp cnt">

			<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active ): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

			<?php if ( _thrive_is_active_sidebar( $options ) ): ?>
			<div class="bSeCont"><?php endif; ?>

				<section class="bSe <?php echo $main_content_class; ?>">
					<?php get_template_part( "partials/content-single" ); ?>
				</section>

				<?php if ( _thrive_is_active_sidebar( $options ) ): ?></div><?php endif; ?>
			<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active ): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

		</div>
		<div class="clear"></div>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>