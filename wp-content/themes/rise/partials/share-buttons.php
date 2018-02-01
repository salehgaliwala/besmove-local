<?php

if ( strpos( $options['social_display_location'], get_post_type( get_the_ID() ) ) !== false ):

	$theme_options = thrive_get_theme_options();
	if ( empty( $theme_options['url'] ) ) {
		$theme_options['url'] = get_the_permalink();
	}

	$theme_options['share_count'] = _thrive_get_share_count_for_post( get_the_ID() );
	?>

	<div class="fln">
		<div class="wrp clearfix">
			<?php if ( ! empty( $theme_options['logo'] ) ): ?>
				<?php if ( get_theme_mod( 'thrivetheme_header_logo' ) != 'hide' && $options['logo_type'] == "text" ): ?>
					<div class="fl-l">
						<div id="text-logo"
						     class="<?php echo $options['logo_color'] == "default" ? $options['color_scheme'] : $options['logo_color']; ?>">
							<a href="<?php echo home_url( '/' ); ?>"><?php echo $options['logo_text']; ?></a>
						</div>
					</div>
				<?php else : ?>
					<a class="fl-l" href="<?php echo home_url( '/' ); ?>">
						<img src="<?php echo $theme_options['logo']; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					</a>
				<?php endif; ?>
			<?php endif; ?>
			<div class="fl-s clearfix">
				<?php if ( $theme_options['social_attention_grabber'] == "cta" ): ?>
					<div class="cou" data-id="<?php echo get_the_ID() ?>">
						<?php echo $theme_options['social_cta_text']; ?>
					</div>
				<?php endif; ?>
				<?php if ( $theme_options['social_attention_grabber'] == "count" && ( ! empty( $options['enable_facebook_button'] ) || ! empty( $options['enable_google_button'] ) || ! empty( $options['enable_linkedin_button'] ) ) ): ?>
					<div class="cou thive-share-count thive-share-cnt-<?php echo get_the_ID() ?>"
					     data-id="<?php echo get_the_ID(); ?>">
						<span
							class="share-no"><?php echo $theme_options['share_count']->total; ?></span> <?php echo _n( "Share", "Shares", $theme_options['share_count']->total, "thrive" ); ?>
					</div>
				<?php endif; ?>
				<?php $post_id_js = json_encode( get_the_ID() ); ?>
				<ul>
					<?php if ( $theme_options['enable_facebook_button'] == 1 ): ?>
						<li class="fb"><a
								href="//www.facebook.com/sharer/sharer.php?u=<?php echo $theme_options['url']; ?>"
								onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"><span><?php _e( 'Share', 'thrive' ); ?></span></a>
						</li>
					<?php endif; ?>
					<?php if ( $theme_options['enable_twitter_button'] == 1 ): ?>
						<li class="tw"><a
								href="https://twitter.com/share?text=<?php echo wp_strip_all_tags( get_the_title() ); ?>:&url=<?php echo $theme_options['url']; ?>"
								onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"><span><?php _e( 'Tweet', 'thrive' ); ?></span></a>
						</li>
					<?php endif; ?>
					<?php if ( $theme_options['enable_linkedin_button'] == 1 ): ?>
						<li class="lk"><a
								href="https://www.linkedin.com/cws/share?url=<?php echo $theme_options['url']; ?>"
								onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"><span><?php _e( 'Share', 'thrive' ); ?></span></a>
						</li>
					<?php endif; ?>
					<?php if ( $theme_options['enable_google_button'] == 1 ): ?>
						<li class="gg"><a href="https://plus.google.com/share?url=<?php echo $theme_options['url']; ?>"
						                  onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"><span><?php _e( 'Share', 'thrive' ); ?></span></a>
						</li>
					<?php endif; ?>
					<?php if ( $theme_options['enable_pinterest_button'] == 1 ): ?>
						<li class="pt"><a data-pin-do="none"
						                  href="http://pinterest.com/pin/create/button/?url=<?php echo $theme_options['url']; ?>&media=<?php echo _thrive_get_pinterest_media_param( get_the_ID() ); ?>"
						                  onclick="return ThriveApp.open_share_popup(this.href, 545, 433, <?php echo $post_id_js ?>);"><span><?php _e( 'Pin', 'thrive' ); ?></span></a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>

<?php endif; ?>