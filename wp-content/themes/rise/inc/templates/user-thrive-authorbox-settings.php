<h3><?php _e( 'Thrive Author Box Social Settings', 'thrive' ); ?></h3>

<table class="form-table">
	<tr>
		<th><label for="thrive_author_website"><?php _e( "Author website", 'thrive' ); ?></label></th>
		<td>
			<input type="text" name="thrive_author_website" id="thrive_author_website"
			       value="<?php echo esc_attr( get_the_author_meta( 'thrive_author_website', $user->ID ) ); ?>"
			       class="regular-text"/><br/>
		</td>
	</tr>
	<tr>
		<th><label for="facebook"><?php _e( "Facebook Page URL", 'thrive' ); ?></label></th>
		<td>
			<input type="text" name="facebook" id="facebook"
			       value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>"
			       class="regular-text"/><br/>
		</td>
	</tr>
	<tr>
		<th><label for="twitter"><?php _e( "Twitter Username", 'thrive' ); ?></label></th>
		<td>
			<input type="text" name="twitter" id="twitter"
			       value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>"
			       class="regular-text"/><br/>
		</td>
	</tr>
	<tr>
		<th><label for="linkedin"><?php _e( "LinkedIn Page URL", 'thrive' ); ?></label></th>
		<td>
			<input type="text" name="linkedin" id="linkedin"
			       value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>"
			       class="regular-text"/><br/>
		</td>
	</tr>
	<tr>
		<th><label for="xing"><?php _e( "XING Page URL", 'thrive' ); ?></label></th>
		<td>
			<input type="text" name="xing" id="xing"
			       value="<?php echo esc_attr( get_the_author_meta( 'xing', $user->ID ) ); ?>"
			       class="regular-text"/><br/>
		</td>
	</tr>
	<tr>
		<th><label for="gplus"><?php _e( "Google+ Profile URL", 'thrive' ); ?></label></th>
		<td>
			<input type="text" name="gplus" id="gplus"
			       value="<?php echo esc_attr( get_the_author_meta( 'gplus', $user->ID ) ); ?>"
			       class="regular-text"/><br/><br/>
			<input type="checkbox"
			       name="gauthor" <?php echo ( get_the_author_meta( 'gauthor', $user->ID ) ) ? "checked" : ""; ?> />
			<label for="gauthor"><?php _e( "Activate Google Authorship", 'thrive' ); ?></label>
			<br/>
                <span class="description"><?php __( "This adds a rel=author tag into your blog post headers, which allows
                        Google to recognize you as the author. Only tick this option if you aren't already using a
                        different Google authorship integration.", 'thrive' ); ?></span>
			<br/>
		</td>
	</tr>
	<tr>
		<th><label for="tt_authorbox_image"><?php _e( "Author Box Image", 'thrive' ); ?></label></th>
		<td>
			<input type="text" name="tt_authorbox_image" id="tt_authorbox_image"
			       value="<?php echo $tt_authorbox_image; ?>"
			       class="regular-text"/><br/>
		</td>
	</tr>
</table>
<?php
$show_social_profiles = explode( ',', get_the_author_meta( 'show_social_profiles', $user->ID ) );
$show_social_profiles = array_filter( $show_social_profiles );
if ( empty( $show_social_profiles ) ) { // back-compatibility
	$show_social_profiles = array( 'e', 'fb', 'tw', 'gg' );
}
?>
<table class="form-table">
	<tr>
		<th><label><?php _e( "Social profiles to show", 'thrive' ); ?></label></th>
		<td>
			<input type="hidden" name="show_social_profiles[]" value="e"/>
			<input id="show_facebook" value="fb" type="checkbox"
			       name="show_social_profiles[]" <?php echo ( in_array( 'fb', $show_social_profiles ) ) ? "checked" : ""; ?> />
			<label for="show_facebook"><?php _e( "Facebook", 'thrive' ); ?></label>
			<input id="show_twitter" value="tw" type="checkbox"
			       name="show_social_profiles[]" <?php echo ( in_array( 'tw', $show_social_profiles ) ) ? "checked" : ""; ?> />
			<label for="show_twitter"><?php _e( "Twitter", 'thrive' ); ?></label>
			<input id="show_linkedin" value="lk" type="checkbox"
			       name="show_social_profiles[]" <?php echo ( in_array( 'lk', $show_social_profiles ) ) ? "checked" : ""; ?> />
			<label for="show_linkedin"><?php _e( "LinkedIn", 'thrive' ); ?></label>
			<input id="show_xing" value="xi" type="checkbox"
			       name="show_social_profiles[]" <?php echo ( in_array( 'xi', $show_social_profiles ) ) ? "checked" : ""; ?> />
			<label for="show_xing"><?php _e( "XING", 'thrive' ); ?></label>
			<input id="show_googleplus" value="gg" type="checkbox"
			       name="show_social_profiles[]" <?php echo ( in_array( 'gg', $show_social_profiles ) ) ? "checked" : ""; ?> />
			<label for="show_googleplus"><?php _e( "Google+", 'thrive' ); ?></label>
			<br>
			<p class="description">A maximum of 3 social pages is allowed.</p>
		</td>
	</tr>
</table>

<script type="text/javascript">

	jQuery( document ).ready( function () {
		jQuery( "#tt_authorbox_image" ).on( 'click', ThriveThemeProfileUploadHandle );

		var limit = 3;

		if ( jQuery( 'input[name="show_social_profiles[]"]:checked' ).length == limit ) {
			jQuery( 'input[name="show_social_profiles[]"]' ).not( ':checked' ).attr( "disabled", "disabled" );
		}

		jQuery( 'input[name="show_social_profiles[]"]' ).on( 'change', function ( e ) {
			var checkedLength = jQuery( 'input[name="show_social_profiles[]"]:checked' ).length;
			if ( checkedLength > limit ) {
				jQuery( this ).prop( 'checked', false );
				jQuery( 'input[name="show_social_profiles[]"]' ).not( ':checked' ).attr( "disabled", "disabled" );
			} else {
				if ( checkedLength == limit ) {
					jQuery( 'input[name="show_social_profiles[]"]' ).not( ':checked' ).attr( "disabled", "disabled" );
				} else {
					jQuery( 'input[name="show_social_profiles[]"]' ).removeAttr( "disabled" )
				}

			}
		} );

	} );

	//deal with the file upload
	var file_frame;
	ThriveThemeProfileUploadHandle = function ( event ) {
		event.preventDefault();
		if ( file_frame ) {
			file_frame.open();
			return;
		}
		file_frame = wp.media.frames.file_frame = wp.media( {
			title: jQuery( this ).data( 'uploader_title' ),
			button: {
				text: jQuery( this ).data( 'uploader_button_text' ),
			},
			multiple: false
		} );
		file_frame.on( 'select', function () {
			attachment = file_frame.state().get( 'selection' ).first().toJSON();
			jQuery( "#tt_authorbox_image" ).val( attachment.url );
		} );
		file_frame.open();
	};
</script>