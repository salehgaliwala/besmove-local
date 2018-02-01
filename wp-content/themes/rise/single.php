<?php
$options            = thrive_get_options_for_post( get_the_ID() );
$main_content_class = ( $options['sidebar_alignement'] == "right" ) ? "left" : "right";
$sidebar_is_active  = is_active_sidebar( 'sidebar-1' );
if ( ! $sidebar_is_active ) {
	$main_content_class = "fullWidth";
}
?>

<?php get_header(); ?>

<?php if ( have_posts() ): ?>
	<?php
	while ( have_posts() ):
		?>
		<?php the_post(); ?>

		<?php get_template_part( 'partials/breadcrumbs' ); ?>

		<div class="wrp cnt">

			<?php if ( $sidebar_is_active ): ?>
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
		<?php if ( isset( $options['footer_popular_posts'] ) && $options['footer_popular_posts'] ): ?>
		<?php get_template_part( "partials/popular-posts" ); ?>
	<?php endif; ?>
		<div class="clear"></div>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>