<?php
$options           = thrive_get_theme_options();
$sidebar_is_active = _thrive_is_active_sidebar( $options );
$exclude_woo_pages = array(
	intval( get_option( 'woocommerce_cart_page_id' ) ),
	intval( get_option( 'woocommerce_checkout_page_id' ) ),
	intval( get_option( 'woocommerce_pay_page_id' ) ),
	intval( get_option( 'woocommerce_thanks_page_id' ) ),
	intval( get_option( 'woocommerce_myaccount_page_id' ) ),
	intval( get_option( 'woocommerce_edit_address_page_id' ) ),
	intval( get_option( 'woocommerce_view_order_page_id' ) ),
	intval( get_option( 'woocommerce_terms_page_id' ) )
);
?>
<?php get_header(); ?>

<?php get_template_part( 'partials/breadcrumbs' ); ?>

	<div class="<?php echo _thrive_get_main_wrapper_class( $options ); ?>">
		<div class="ar">
			<h3><?php printf( __( 'Search Results for: %s', 'thrive' ), get_search_query() ); ?></h3>
		</div>
		<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active ): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<?php if ( _thrive_is_active_sidebar( $options ) ): ?>
		<div class="bSeCont"><?php endif; ?>

			<section class="<?php echo _thrive_get_main_section_class( $options ); ?>">

				<?php if ( $options['blog_layout'] == "masonry_full_width" || $options['blog_layout'] == "masonry_sidebar" ): ?>
					<div class="mry-g"></div>
				<?php endif; ?>
				<?php if ( have_posts() ): ?>
					<?php
					$index             = 0;
					$excludePostsArray = array();
					while ( have_posts() ):
						?>
						<?php the_post(); ?>
						<?php if ( in_array( get_the_ID(), $exclude_woo_pages ) ): continue; endif; ?>
						<?php _thrive_render_post_content_template( $options ); ?>

						<?php
						$excludePostsArray[] = get_the_ID();
						?>

						<?php if ( ( $options['blog_layout'] == "default" || $options['blog_layout'] == "full_width" ) && thrive_check_blog_focus_area( $index + 1 ) ):
						?>
						<?php thrive_render_top_focus_area( "between_posts", $index + 1 ); ?>
					<?php endif; ?>

						<?php
						$index ++;
					endwhile;
					?>
					<?php if ( _thrive_check_focus_area_for_pages( "archive", "bottom" ) ): ?>
						<?php if ( strpos( $options['blog_layout'], 'masonry' ) === false && strpos( $options['blog_layout'], 'grid' ) === false ): ?>
							<?php thrive_render_top_focus_area( "bottom", "archive" ); ?>
							<div class="spr"></div>
						<?php endif; ?>
					<?php endif; ?>


					<?php if ( $options['blog_layout'] != "masonry_full_width" && $options['blog_layout'] != "masonry_sidebar" ): ?>
						<div class="clear"></div>
						<div class="pgn clearfix">
							<?php thrive_pagination(); ?>
						</div>

						<div class="clear"></div>
					<?php endif; ?>

				<?php else: ?>
					<!--No contents-->
				<?php endif; ?>
			</section>

			<?php if ( _thrive_is_active_sidebar( $options ) ): ?></div><?php endif; ?>
		<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active ): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<div class="clear"></div>
	</div>


<?php if ( $options['blog_layout'] == "masonry_full_width" || $options['blog_layout'] == "masonry_sidebar" ): ?>
	<div class="clear"></div>
	<div class="pgn clearfix">
		<?php thrive_pagination(); ?>
	</div>

	<div class="clear"></div>
<?php endif; ?>

<?php get_footer(); ?>