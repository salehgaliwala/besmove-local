<?php
/*
  Template Name: Full Width
 */
?>
<?php
$options = thrive_get_options_for_post( get_the_ID() );
?>
<?php get_header(); ?>

<?php if ( have_posts() ): ?>
	<?php
	while ( have_posts() ):
		?>
		<?php the_post(); ?>

		<?php get_template_part( 'partials/breadcrumbs' ); ?>

		<div class="wrp cnt">


			<section class="bSe fullWidth">
				<?php get_template_part( "partials/content-single" ); ?>
			</section>


		</div>
		<div class="clear"></div>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>