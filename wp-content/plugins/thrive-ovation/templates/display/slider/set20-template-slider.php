<div
		class="tvo-testimonials-display tvo-testimonials-display-slider tvo-set20-template tve_red">
	<div id="<?php echo $unique_id; ?>">
		<div class="thrlider-slider">
			<?php foreach ( $testimonials as $testimonial ) : ?>
				<?php if ( ! empty( $testimonial ) ) : ?>
					<div class="thrlider-slide">
						<div class="tvo-testimonial-display-item">
							<div class="tvo-testimonial-content tvo-apply-background">
								<?php if ( ! empty( $config['show_title'] ) ) : ?>
									<h4>
										<?php echo $testimonial['title'] ?>
									</h4>
								<?php endif; ?>
								<div class="tvo-relative">
									<div class="tvo-testimonial-quote"></div>
									<?php echo $testimonial['content'] ?>
								</div>
							</div>
							<div class="tvo-image-wrapper tvo-bubbles">
								<div class="tvo-testimonial-image-cover" style="background-image: url(<?php echo $testimonial['picture_url'] ?>)">
									<img src="<?php echo $testimonial['picture_url'] ?>"
										 class="tvo-testimonial-image tvo-dummy-image" alt="profile-pic">
								</div>
							</div>
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
				<?php endif; ?>
			<?php endforeach ?>
		</div>
		<span class="thrlider-prev"></span>
		<span class="thrlider-next"></span>
	</div>
</div>
<script type="text/javascript">
	jQuery( document ).ready( function () {
		setTimeout( function () {
			jQuery( '#<?php echo $unique_id; ?>' ).thrlider( {
				nav: true,
				maxSlides: 3,
				activeSlidePosition: 2
			} );
		}, 200 );
	} );
</script>
