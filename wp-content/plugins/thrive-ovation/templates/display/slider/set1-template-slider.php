<div
		class="tvo-testimonials-display tvo-testimonials-display-slider tvo-set1-template tve_blue tvo-apply-background">
	<div id="<?php echo $unique_id; ?>">
		<div class="thrlider-slider">
			<?php foreach ( $testimonials as $testimonial ) : ?>
				<?php if ( ! empty( $testimonial ) ) : ?>
					<div class="thrlider-slide">
						<div class="tvo-testimonial-display-item">
							<div class="tvo-image-wrapper">
								<div class="tvo-testimonial-image-cover" style="background-image: url(<?php echo $testimonial['picture_url'] ?>)">
									<img src="<?php echo $testimonial['picture_url'] ?>"
										 class="tvo-testimonial-image tvo-dummy-image" alt="profile-pic">
								</div>
							</div>
							<div class="tvo-relative tvo-testimonial-content">
								<div class="tvo-testimonial-quote"></div>
								<?php if ( ! empty( $config['show_title'] ) ) : ?>
									<h4>
										<?php echo $testimonial['title'] ?>
									</h4>
								<?php endif; ?>
								<?php echo $testimonial['content'] ?>
								<div class="tvo-testimonial-info">
									<span class="tvo-testimonial-name">
										<?php echo $testimonial['name'] ?>
									</span>
									<?php if ( ! empty( $config['show_role'] ) ) : ?>
										<span class="tvo-testimonial-role">
												<?php $role_wrap_before = empty( $config['show_site'] ) || empty( $testimonial['website_url'] ) ? '' : '<a href="' . $testimonial['website_url'] . '">';
												$role_wrap_after        = empty( $config['show_site'] ) || empty( $testimonial['website_url'] ) ? '' : '</a>';
												echo $role_wrap_before . $testimonial['role'] . $role_wrap_after; ?>
											</span>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach ?>
		</div>
		<span class="thrlider-prev"></span>
		<span class="thrlider-next"></span>
		<div class="thrlider-nav">
			<?php foreach ( $testimonials as $key => $testimonial ) : ?>
				<?php if ( ! empty( $testimonial ) ) : ?>
					<span class="thrlider-navItem" data-nav="<?php echo $key; ?>">
						<svg height="100%" width="100%" viewBox="0 0 18 18">
							<circle cx="7" cy="7" r="6"></circle>
						</svg>
					</span>
				<?php endif; ?>
			<?php endforeach ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery( document ).ready( function () {
		setTimeout( function () {
			jQuery( '#<?php echo $unique_id; ?>' ).thrlider( {
				nav: true
			} );
		}, 200 );
	} );
</script>
