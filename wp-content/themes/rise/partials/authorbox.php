<?php
$fname         = get_the_author_meta( 'first_name' );
$lname         = get_the_author_meta( 'last_name' );
$desc          = get_the_author_meta( 'description' );
$thrive_social = array_filter( array(
	"tw" => get_the_author_meta( 'twitter' ),
	"fb" => get_the_author_meta( 'facebook' ),
	"gg" => get_the_author_meta( 'gplus' ),
	"lk" => get_the_author_meta( 'linkedin' ),
	"xi" => get_the_author_meta( 'xing' )
) );

$show_social_profiles = explode( ',', get_the_author_meta( 'show_social_profiles' ) );
$show_social_profiles = array_filter( $show_social_profiles );
if ( empty( $show_social_profiles ) ) { // back-compatibility
	$show_social_profiles = array( 'e', 'fb', 'tw', 'gg' );
}
$author_name     = get_the_author_meta( 'display_name' );
$author_image    = get_the_author_meta( 'tt_authorbox_image' );
$author_gravatar = _thrive_get_avatar_url( get_avatar( get_the_author_meta( 'user_email' ), 180 ) );
$display_name    = empty( $author_name ) ? $fname . " " . $lname : $author_name;
?>

<div class="aut">
	<div class="aut-t">
		<h3>
			<?php _e( "About the Author", 'thrive' ); ?>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo $display_name; ?></a>
		</h3>

		<p><?php echo $desc; ?></p>

		<?php if ( ! empty( $thrive_social['tw'] ) || ! empty( $thrive_social['fb'] ) || ! empty( $thrive_social['gg'] ) || ! empty( $thrive_social['lk'] ) || ! empty( $thrive_social['xing'] ) ): ?>
			<div class="aut-s">
				<span class="aut-f"><?php _e( "follow me on", 'thrive' ); ?>:</span>

				<div class="ss">
					<?php foreach ( $thrive_social as $service => $url ): ?>
						<?php if ( in_array( $service, $show_social_profiles ) || empty( $show_social_profiles[0] ) ) { ?>
							<?php $url = _thrive_get_social_link( $url, $service ); ?>
							<a href="<?php echo $url; ?>" class="<?php echo $service; ?>" target="_blank"></a>
						<?php } ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<div class="aut-i">
		<div class="aui"
		     style="background-image: url('<?php echo ! empty( $author_image ) && strpos( $author_image, "TT_DEFAULT_AUTHORBOX_IMAGE" ) === false ? $author_image : $author_gravatar ?>')"></div>
	</div>
</div>