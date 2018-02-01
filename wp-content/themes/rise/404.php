<?php
$options = thrive_get_theme_options();

$main_content_class = ( $options['sidebar_alignement'] == "right" ) ? "main_content" : "right_main_content";

$next_page_link = get_next_posts_link();
$prev_page_link = get_previous_posts_link();
?>
<?php get_header(); ?>
<div class="lost">
	<div class="wrp cnt">
		<section class="bSe fullWidth">
			<div class="awr">
				<div class="csc">
					<div class="colm tth hl">
						<h1>
							<?php _e( "404", 'thrive' ); ?>
						</h1>
					</div>
					<div class="colm thc lst">
						<h3>
                            <span>
                                <?php _e( "Sorry!", 'thrive' ); ?>
                            </span>
							<?php _e( "We can’t find the page you were looking for.", 'thrive' ); ?>
						</h3>
						<h4>
							<?php _e( "Try searching instead!", 'thrive' ); ?>
						</h4>
						<form method="get" action="<?php echo home_url( '/' ); ?>" class="frm">
							<input type="text" placeholder="" class="search-field" name="s"/>

							<div class="btn <?php echo $options['color_scheme'] ?> small search-button">
								<input type="submit" value="Search"/>
							</div>
							<div class="clear"></div>
						</form>
					</div>
					<div class="clear"></div>
					<?php if ( ! empty( $options['404_custom_text'] ) ): ?>
						<div><?php echo nl2br( do_shortcode( $options['404_custom_text'] ) ); ?></div>
					<?php endif; ?>
					<?php
					if ( isset( $options['404_display_sitemap'] ) && $options['404_display_sitemap'] == "on" ):
						$categories = get_categories( array( 'parent' => 0 ) );
						$pages = get_pages();
						?>
						<div class="csc">
							<div class="colm thc">
								<h3><?php _e( "Categories", 'thrive' ); ?></h3>
								<ul class="tt_sitemap_list">
									<?php foreach ( $categories as $cat ): ?>
										<li>
											<a href='<?php echo get_category_link( $cat->term_id ); ?>'><?php echo $cat->name; ?></a>
											<?php
											$subcats = get_categories( array( 'child_of' => $cat->term_id ) );
											if ( count( $subcats ) > 0 ):
												?>
												<ul>
													<?php foreach ( $subcats as $subcat ): ?>
													<li>
														<a href='<?php echo get_category_link( $subcat->term_id ); ?>'><?php echo $subcat->name; ?></a>
														<?php endforeach; ?>
												</ul>
											<?php endif; ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="colm thc">
								<h3><?php _e( "Archives", 'thrive' ); ?></h3>
								<ul>
									<?php wp_get_archives(); ?>
								</ul>
							</div>
							<div class="colm thc lst">
								<h3><?php _e( "Pages", 'thrive' ); ?></h3>
								<ul class="tt_sitemap_list">
									<?php foreach ( $pages as $page ): ?>
										<li>
											<a href='<?php echo get_page_link( $page->ID ); ?>'><?php echo get_the_title( $page->ID ); ?></a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="clear"></div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
	</div>
</div>
<?php get_footer(); ?>
