<?php
$r = new WP_Query( array(
	'order'               => 'DESC',
	'orderby'             => 'comment_count',
	'posts_per_page'      => 4,
	'ignore_sticky_posts' => 1
) );

$popular_posts = $r->get_posts();
?>

<div class="rpb">
	<div class="wrp">
		<h4><?php _e( 'Popular posts', 'thrive' ); ?></h4>

		<div class="csc">
			<?php foreach ( $popular_posts as $key => $p ): ?>
				<div class="colm foc <?php echo $key == count( $popular_posts ) - 1 ? 'lst' : ''; ?>">
					<div class="rpi-i">
						<a href="<?php echo get_permalink( $p->ID ); ?>">
							<div class="rpi" <?php
							if ( has_post_thumbnail( $p->ID ) ) {
								$featured_img_data = thrive_get_post_featured_image( $p->ID, "tt_related_posts" );
								$featured_img      = $featured_img_data['image_src'];
								echo ' style="background-image: url(\'' . $featured_img . '\')"';
							} else {
								echo ' style="background-image: url(\'' . get_template_directory_uri() . "/images/default_featured.jpg" . '\')"';
							}
							?>></div>
							<h5><?php echo get_the_title( $p->ID ) ?></h5>
						</a>
						<?php $categories = get_the_category( $p->ID ); ?>
						<?php foreach ( $categories as $c ): ?>
							<a href="<?php echo get_category_link( $c->term_id ); ?> " class="cat">
								<?php echo $c->cat_name; ?>
							</a>
						<?php endforeach; ?>
						<div class="date"><?php echo get_the_date( 'M d, Y', $p->ID ); ?></div>
					</div>
				</div>
			<?php endforeach; ?>
			<div class="clear"></div>
		</div>
	</div>
</div>