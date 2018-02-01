<?php tha_content_bottom(); ?>
<?php
$options        = thrive_get_options_for_post( get_the_ID() );
$active_footers = _thrive_get_footer_active_widget_areas();

$f_class  = _thrive_get_footer_col_class( count( $active_footers ) );
$num_cols = count( $active_footers );

$post_template = _thrive_get_item_template( get_the_ID() );
?>

<?php tha_content_after(); ?>
<?php tha_footer_before(); ?>

<footer>
	<?php tha_footer_top(); ?>
	<?php if ( $num_cols > 0 && $post_template != "Landing Page" ): ?>
		<div class="fmw">
			<div class="wrp">
				<?php
				$num = 0;
				foreach ( $active_footers as $name ):
					$num ++;
					?>
					<div class="<?php echo $f_class; ?> <?php echo ( $num == $num_cols ) ? 'lst' : ''; ?>">
						<?php dynamic_sidebar( $name ); ?>
					</div>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>
		</div>
	<?php endif; ?>
	<div class="fmm">
		<div class="wrp">
			<div class="ft-m">
				<?php if ( has_nav_menu( "footer" ) ): ?>
					<?php wp_nav_menu( array(
						'theme_location' => 'footer',
						'depth'          => 1,
						'menu_class'     => 'footer_menu'
					) ); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="wrp">
			<div class="ft-c">
				<p>
					<?php if ( isset( $options['footer_copyright'] ) && $options['footer_copyright'] ): ?>
						<?php echo str_replace( '{Y}', date( 'Y' ), $options['footer_copyright'] ); ?>
					<?php endif; ?>
					<?php if ( isset( $options['footer_copyright_links'] ) && $options['footer_copyright_links'] == 1 ): ?>
						&nbsp;&nbsp;-&nbsp;&nbsp;Designed by <a href="//www.thrivethemes.com" target="_blank"
						                                        style="text-decoration: underline;">Thrive
							Themes</a>
						| Powered by <a style="text-decoration: underline;" href="//www.wordpress.org"
						                target="_blank">WordPress</a>
					<?php endif; ?>
				</p>
			</div>
			<div class="ft-s">
				<?php
					if (str_replace( " ", "", $options['social_linkedin'] ) != "" ||
						str_replace( " ", "", $options['social_facebook'] ) != "" ||
						str_replace( " ", "", $options['social_twitter'] ) != "" ||
						str_replace( " ", "", $options['social_gplus'] ) != "" ||
						str_replace( " ", "", $options['social_youtube'] ) != "" ||
						str_replace( " ", "", $options['social_pinterest'] ) != ""
					){
						$dst = true;
					}
				?>
				<?php if ( isset( $dst ) && $dst ): ?>
					<span><?php _e( "Connect With Me", 'thrive' ); ?>:</span>
				<?php endif; ?>
				<ul>
					<?php if ( str_replace( " ", "", $options['social_linkedin'] ) != "" ): $dst = true; ?>
						<li class="lk">
							<a href="<?php echo $options['social_linkedin']; ?>" target="_blank"></a>
						</li>
					<?php endif; ?>
					<?php if ( str_replace( " ", "", $options['social_facebook'] ) != "" ): $dst = true; ?>
						<li class="fb">
							<a href="<?php echo $options['social_facebook']; ?>" target="_blank"></a>
						</li>
					<?php endif; ?>
					<?php if ( str_replace( " ", "", $options['social_twitter'] ) != "" ): $dst = true; ?>
						<li class="tw">
							<a href="<?php echo _thrive_get_twitter_link( $options['social_twitter'] ); ?>"
							   target="_blank"></a>
						</li>
					<?php endif; ?>
					<?php if ( str_replace( " ", "", $options['social_gplus'] ) != "" ): $dst = true; ?>
						<li class="gg">
							<a href="<?php echo $options['social_gplus']; ?>" target="_blank"></a>
						</li>
					<?php endif; ?>
					<?php if ( str_replace( " ", "", $options['social_youtube'] ) != "" ): $dst = true; ?>
						<li class="yt">
							<a href="<?php echo $options['social_youtube']; ?>" target="_blank"></a>
						</li>
					<?php endif; ?>
					<?php if ( str_replace( " ", "", $options['social_pinterest'] ) != "" ): $dst = true; ?>
						<li class="pt">
							<a href="<?php echo $options['social_pinterest']; ?>" target="_blank"></a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php tha_footer_bottom(); ?>
</footer>

<?php tha_footer_after(); ?>

<?php if ( isset( $options['analytics_body_script'] ) && $options['analytics_body_script'] != "" ): ?>
	<?php echo $options['analytics_body_script']; ?>
<?php endif; ?>
<?php wp_footer(); ?>
<?php tha_body_bottom(); ?>
</div>
</body>
</html>