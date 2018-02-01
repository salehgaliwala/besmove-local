<?php
$options = thrive_get_options_for_post( get_the_ID() );
$post_template = _thrive_get_item_template( get_the_ID() );
$style_options = _thrive_get_header_style_options( $options );
?><!DOCTYPE html>
<?php tha_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
	<?php tha_head_top(); ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri() ?>/js/html5/dist/html5shiv.js"></script>
	<script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/ie8.css"/>
	<![endif]-->
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/ie7.css"/>
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( $options['favicon'] && ! empty( $options['favicon'] ) ): ?>
		<link rel="shortcut icon" href="<?php echo $options['favicon']; ?>"/>
	<?php endif; ?>

	<?php if ( isset( $options['analytics_header_script'] ) && ! empty( $options['analytics_header_script'] ) ): ?>
		<?php echo $options['analytics_header_script']; ?>
	<?php endif; ?>

	<?php thrive_enqueue_head_fonts(); ?>
	<?php wp_head(); ?>
	<?php if ( isset( $options['custom_css'] ) && $options['custom_css'] != "" ): ?>
		<style type="text/css"><?php echo $options['custom_css']; ?></style>
	<?php endif; ?>
	<?php tha_head_bottom(); ?>

</head>
<body <?php body_class(); ?>>
<?php if ( isset( $options['analytics_body_script_top'] ) && ! empty( $options['analytics_body_script_top'] ) ): ?>
	<?php echo $options['analytics_body_script_top']; ?>
<?php endif; ?>
<div class="theme-wrapper">
	<?php _thrive_render_top_fb_script(); ?>

	<?php tha_body_top(); ?>

	<?php tha_header_before(); ?>

	<?php require get_template_directory() . "/partials/share-buttons.php"; ?>

	<div class="<?php echo $style_options['header_class']; ?>">
		<div id="floating_menu" data-float="<?php echo $options['navigation_type']; ?>"
		     data-social='<?php echo $options['enable_social_buttons']; ?>'>
			<header class="<?php echo $style_options['logo_pos_class']; ?>"
			        style="<?php echo $style_options['header_style']; ?>">
				<?php echo $style_options['header_extra']; ?>
				<div class="h-i">
					<div class="wrp">
						<?php
						if ( get_theme_mod( 'thrivetheme_header_logo' ) != 'hide' ):
							$thrive_logo = false;
							if ( $options['logo_type'] == "text" ):
								if ( get_theme_mod( 'thrivetheme_header_logo' ) != 'hide' ):
									?>
									<div id="text-logo" <?php echo $style_options['logo_style']; ?>
									     class="<?php if ( $options['logo_color'] == "default" ): ?><?php echo $options['color_scheme'] ?><?php else: ?><?php echo $options['logo_color'] ?><?php endif; ?> ">
										<a href="<?php echo home_url( '/' ); ?>"><?php echo $options['logo_text']; ?></a>
									</div>
								<?php endif; ?>
							<?php elseif ( $options['logo'] && $options['logo'] != "" ): $thrive_logo = true; ?>
								<div id="logo" <?php echo $style_options['logo_style']; ?>>
									<a href="<?php echo home_url( '/' ); ?>">
										<img src="<?php echo $options['logo']; ?>"
										     alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
								</div>
								<?php
							endif;
						endif;
						?>
						<?php if ( $post_template != "Landing Page" ): ?>
							<div class="m-s">
								<div class="hsm"></div>
								<div class="m-si">
									<?php if ( $options['header_phone'] == 1 ): ?>
										<div
											class="phone phone_mobile <?php if ( $options['header_phone_btn_color'] == "default" ): ?><?php echo $options['color_scheme']; ?><?php else: ?><?php echo $options['header_phone_btn_color']; ?><?php endif; ?>">
											<a href="tel:<?php echo $options['header_phone_no']; ?>">
												<div class="phr">
                                                <span
	                                                class="mphr"><?php echo $options['header_phone_text_mobile']; ?></span>
													<span class="apnr"><?php echo $options['header_phone_no']; ?></span>
												</div>
											</a>
										</div>
									<?php endif; ?>
									<?php if ( has_nav_menu( "primary" ) ): ?>
										<?php wp_nav_menu( array(
											'container'      => 'nav',
											'depth'          => 0,
											'theme_location' => 'primary',
											'menu_class'     => 'menu',
											'walker'         => new thrive_custom_menu_walker()
										) ); ?>
										<?php require_once get_template_directory() . '/inc/templates/woocommerce-navbar-mini-cart.php'; ?>
									<?php else: ?>
										<div class="dfm">
											<?php _e( "Assign a 'primary' menu", 'thrive' ); ?>
										</div>
									<?php endif; ?>

									<?php if ( $options['header_phone'] == 1 ): ?>
										<div
											class="phone phone_full <?php if ( $options['header_phone_btn_color'] == "default" ): ?><?php echo $options['color_scheme']; ?><?php else: ?><?php echo $options['header_phone_btn_color']; ?><?php endif; ?>">
											<a href="tel:<?php echo $options['header_phone_no']; ?>">
												<div class="phr">
													<span
														class="fphr"><?php echo $options['header_phone_text']; ?></span>
													<span class="apnr"><?php echo $options['header_phone_no']; ?></span>
												</div>
											</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

					</div>
				</div>

			</header>
		</div>
	</div>

	<?php tha_content_before( $options ); ?>

	<?php tha_content_top(); ?>

	<?php
	$_is_any_grid = strpos( $options['blog_layout'], 'masonry' ) !== false || strpos( $options['blog_layout'], 'grid' ) !== false;
	?>

	<?php if ( thrive_check_top_focus_area() ): ?>
		<?php thrive_render_top_focus_area(); ?>
	<?php elseif ( is_home() && _thrive_check_focus_area_for_pages( "blog", "top" ) && ! $_is_any_grid ) : ?>
		<?php thrive_render_top_focus_area( "top", "blog" ); ?>
	<?php elseif ( ( is_archive() || is_search() ) && _thrive_check_focus_area_for_pages( "archive", "top" ) && ! $_is_any_grid ) : ?>
		<?php thrive_render_top_focus_area( "top", "blog" ); ?>
	<?php endif; ?>
