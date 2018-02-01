<?php  if ( ! empty( $options['meta_author_name'] ) ) {
	$author_info = _thrive_get_author_info( get_the_author_meta( 'ID' ) );
}
if ( $options['enable_social_buttons'] ||
     $options['meta_post_date'] == 1 ||
     ( isset( $options['meta_post_category'] ) && $options['meta_post_category'] == 1 ) ||
     ( $options['meta_comment_count'] == 1 && get_comments_number() > 0 )
): ?>
	<div class="met">
		<ul class="meta">
			<?php if ( $options['meta_post_date'] == 1 ): ?>
				<li>
					<?php if ( $options['relative_time'] == 1 ): ?>
						<?php echo thrive_human_time( get_the_time( 'U' ) ); ?>
					<?php else: ?>
						<?php echo get_the_date(); ?>
					<?php endif; ?>
				</li>
			<?php endif; ?>
			<?php if ( isset( $options['meta_post_category'] ) && $options['meta_post_category'] == 1 ): ?>
				<?php
				$categories = get_the_category();
				if ( $categories && count( $categories ) > 0 ):
					?>
					<li>
						<?php if ( $options['meta_post_date'] == 1 ): ?>
							/
						<?php endif; ?>
						<?php foreach ( $categories as $key => $cat ): ?>
							<a href="<?php echo get_category_link( $cat->term_id ); ?>">
								<?php echo $cat->cat_name; ?>
							</a>
							<?php if ( $key != count( $categories ) - 1 && isset( $categories[ $key + 1 ] ) ): ?>&nbsp;&nbsp;&nbsp;<?php endif; ?>

						<?php endforeach; ?>
					</li>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ( ! empty( $author_info ) ) : ?>
				<li>
					<?php if ( ( $options['meta_post_date'] == 1 ) || ( ( isset( $categories ) && count( $categories ) > 0 ) )  ): ?>
						/
					<?php endif; ?>
					<?php _e( "By", 'thrive' ); ?>
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
						<?php echo $author_info['display_name']; ?>
					</a>
				</li>
			<?php endif ?>
			<?php $comments_number = get_comments_number(); ?>
			<?php if ( $options['meta_comment_count'] == 1 && $comments_number > 0 ): ?>
				<li>
					<?php if ( ( ( isset( $categories ) && count( $categories ) > 0 ) || ( ! empty( $author_info ) ) ) ): ?>
						/
					<?php endif; ?>
					<a href="<?php the_permalink(); ?>#comments">
						<?php echo $comments_number; ?>
						<?php echo _n( 'COMMENT', 'COMMENTS', $comments_number, 'thrive' ); ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>

		<?php if ( $options['enable_social_buttons'] ): ?>
			<?php $post_id_js = json_encode( get_the_ID() ) ?>
			<div class="mets">
				<?php if ( $options['social_attention_grabber'] == "count" && ( ! empty( $options['enable_facebook_button'] ) || ! empty( $options['enable_google_button'] ) || ! empty( $options['enable_linkedin_button'] ) ) ): ?>
					<span class="cou thive-share-cnt-<?php echo get_the_ID() ?>"
					      data-id="<?php echo get_the_ID(); ?>"><span
							class="share-no"><?php echo $options['share_count']->total; ?></span> <?php echo _n( "Share", "Shares", $options['share_count']->total, "thrive" ); ?></span>
				<?php endif; ?>
				<div class="ss">
					<?php if ( $options['enable_facebook_button'] == 1 ): ?>
						<a class="fb" href="//www.facebook.com/sharer/sharer.php?u=<?php echo $options['url']; ?>"
						   onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"></a>
					<?php endif; ?>
					<?php if ( $options['enable_twitter_button'] == 1 ): ?>
						<a class="tw"
						   href="https://twitter.com/share?text=<?php echo rawurlencode( wp_strip_all_tags( get_the_title() ) ); ?>:&url=<?php echo $options['url']; ?>"
						   onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"></a>
					<?php endif; ?>
					<?php if ( $options['enable_linkedin_button'] == 1 ): ?>
						<a class="lk" href="https://www.linkedin.com/cws/share?url=<?php echo $options['url']; ?>"
						   onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"></a>
					<?php endif; ?>
					<?php if ( $options['enable_google_button'] == 1 ): ?>
						<a class="gg" href="https://plus.google.com/share?url=<?php echo $options['url']; ?>"
						   onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"></a>
					<?php endif; ?>
					<?php if ( $options['enable_pinterest_button'] == 1 ): ?>
						<a class="pt" data-pin-do="none"
						   href="http://pinterest.com/pin/create/button/?url=<?php echo $options['url']; ?>&media=<?php echo _thrive_get_pinterest_media_param( get_the_ID() ); ?>"
						   onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"></a>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>