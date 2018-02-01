<?php
$adminCreateNewOptinUrl = 'post-new.php?post_type=thrive_optin';
?>
<input type="hidden" id="thrive_focus_template" name="thrive_meta_focus_template"
       value="<?php echo $meta_fields_values['thrive_meta_focus_template']; ?>">
<div class="opt_in_template_wrapper">
	<?php
	$selected_template_int = filter_var( $meta_fields_values['thrive_meta_focus_template'], FILTER_SANITIZE_NUMBER_INT );

	foreach ( $focus_templates as $key => $tpl_name ):
		$int             = filter_var( $key, FILTER_SANITIZE_NUMBER_INT );
		$active_template = ( $selected_template_int == $int ) ? 1 : 0;
		if ( $int !== false ):
			echo '<div class="opt_in_template' .
			     ( ( $active_template == 1 ) ? ' selected"><div class="tick"></div>' : '">' ) .
			     '<img src="' . get_template_directory_uri() . '/inc/images/focus_template_' . intval( $int ) . '.png" class="template_image"><input type="hidden" class="this_template" value="' .
			     $int . '"></div>';
		endif;
	endforeach
	?>
</div>

<div class="thrive_options_panel">

	<div id='container-optin' class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="thrive_focus_color"
				       class="thrive_form_label"><?php _e( "Connect to a Mailing List", 'thrive' ); ?></label>
			</th>
			<td>
				<select name='thrive_meta_focus_optin' id="thrive_meta_focus_optin">
					<option value='0'></option>
					<?php foreach ( $queryOptins->get_posts() as $p ): ?>
						<option value='<?php echo $p->ID ?>'
						        <?php if ( $meta_fields_values['thrive_meta_focus_optin'] == $p->ID ): ?>selected<?php endif; ?>><?php echo $p->post_title; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<button class="button button-primary" id="add_mailing_list"
				        href="<?php echo $adminCreateNewOptinUrl; ?>"><?php _e( "Connect to a New Mailing List", 'thrive' ); ?></button>
			</td>
		</table>
	</div>

	<div id="container-focus-color" class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="thrive_focus_color" class="thrive_form_label"> <?php _e( "Color", 'thrive' ); ?></label>
			</th>
			<td>
				<select id='thrive_focus_color' name='thrive_meta_focus_color'>
					<?php foreach ( $focus_colors as $key => $color ): ?>
						<?php
						$selected = ( $key == $meta_fields_values['thrive_meta_focus_color'] ) ? "selected" : "";
						echo "<option value='" . $key . "' " . $selected . ">" . $color . "</option>";
						?>
					<?php endforeach ?>
				</select>
			</td>
		</table>
	</div>

	<div id='container-heading-text' class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="" class="thrive_form_label"><?php _e( "Heading text", 'thrive' ) ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo $meta_fields_values['thrive_meta_focus_heading_text']; ?>"
				       name="thrive_meta_focus_heading_text"
				       id="thrive_meta_focus_heading_text"/>
			</td>
		</table>
	</div>
	<br/>
	<div id='container-subheading-text' class="thrive_option_container">
		<!-- <input type="text" value="<?php // echo $value_focus_subheading_text;    ?>" name="thrive_meta_focus_subheading_text"
               id="thrive_meta_focus_subheading_text"/> -->

		<?php wp_editor( $meta_fields_values['thrive_meta_focus_subheading_text'], "thrive_meta_focus_subheading_text" ); ?>

		<br/><br/>
	</div>
	<div id='container-button-text' class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="" class="thrive_form_label"><?php _e( "Button Text", 'thrive' ) ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo $meta_fields_values['thrive_meta_focus_button_text']; ?>"
				       name="thrive_meta_focus_button_text"
				       id="thrive_meta_focus_button_text"/>
			</td>
		</table>

	</div>
	<div id='container-button-color' class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="" class="thrive_form_label"><?php _e( "Button Color", 'thrive' ) ?></label>
			</th>
			<td>
				<select id="thrive_meta_focus_button_color" name="thrive_meta_focus_button_color">
					<?php foreach ( $button_colors as $key => $c ): ?>
						<option value="<?php echo $key; ?>"
						        <?php if ( $key == $meta_fields_values['thrive_meta_focus_button_color'] ): ?>selected<?php endif; ?>><?php echo $c; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</table>

	</div>
	<div id='container-spam-disclaimer' class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="" class="thrive_form_label"><?php _e( "Spam Disclaimer", 'thrive' ) ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo $meta_fields_values['thrive_meta_focus_spam_text']; ?>"
				       name="thrive_meta_focus_spam_text"
				       id="thrive_meta_focus_spam_text"/>
			</td>
		</table>
	</div>
	<div id='container-focus-image' class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="" class="thrive_form_label"><?php _e( "Focus Image", 'thrive' ) ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo $meta_fields_values['thrive_meta_focus_image']; ?>"
				       name="thrive_meta_focus_image_txt"
				       id="thrive_meta_focus_image"/>
				<br/>
				<input type="hidden" name="thrive_meta_focus_image" id="thrive_meta_focus_image_hidden"
				       value="<?php echo $meta_fields_values['thrive_meta_focus_image']; ?>"/>
				<p class="imgButtons">
					<input class="pure-button upload " type='button' id='thrieve_btn_focus_image' value='Upload'/>
					<a class="pure-button remove"
					   id='thrieve_btn_focus_clear_image'><?php _e( "Remove image", 'thrive' ) ?></a>
				</p>
			</td>
		</table>
	</div>

	<div id='container-focus-image2' class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="" class="thrive_form_label"><?php _e( "Focus Background Image", 'thrive' ) ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo $meta_fields_values['thrive_meta_focus_image2']; ?>"
				       name="thrive_meta_focus_image2_txt"
				       id="thrive_meta_focus_image2"/>
				<br/>
				<input type="hidden" name="thrive_meta_focus_image2" id="thrive_meta_focus_image2_hidden"
				       value="<?php echo $meta_fields_values['thrive_meta_focus_image2']; ?>"/>
				<p class="imgButtons">
					<input class="pure-button upload " type='button' id='thrieve_btn_focus_image2' value='Upload'
					       style="width: 100px;"/>
					<a class="pure-button remove"
					   id='thrieve_btn_focus_clear_image2'><?php _e( "Remove image", 'thrive' ) ?></a>
				</p>
			</td>
		</table>
	</div>

	<div id='container-button-link' class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="" class="thrive_form_label"><?php _e( "Link URL", 'thrive' ) ?></label>
			</th>
			<td>
				<input type="text" value="<?php echo $meta_fields_values['thrive_meta_focus_button_link']; ?>"
				       name="thrive_meta_focus_button_link"
				       id="thrive_meta_focus_button_link"/>
			</td>
		</table>
	</div>

	<?php
	do_action( 'thrive_admin_focus_area_form', $meta_fields_values );
	?>

	<div id='container-new-tab' class="thrive_option_container">
		<table class="form-table focusEdit">
			<th scope="row">
				<label for="" class="thrive_form_label"><?php _e( "Open in a New Tab", 'thrive' ) ?></label>
			</th>
			<td>
				<div>
					<input class='toggle toggle-left' type='radio' id='thrive_meta_focus_new_tab_true'
					       name='thrive_meta_focus_new_tab' value='1'
					       <?php if ( $meta_fields_values['thrive_meta_focus_new_tab'] == 1 ): ?>checked<?php endif ?> />
					<label for='thrive_meta_focus_new_tab_true' class='btn'><?php _e( "Yes", 'thrive' ); ?></label>
					<input class='toggle toggle-right' type='radio' id='thrive_meta_focus_new_tab_false'
					       name='thrive_meta_focus_new_tab' value='0'
					       <?php if ( $meta_fields_values['thrive_meta_focus_new_tab'] == 0 ): ?>checked<?php endif ?> />
					<label for='thrive_meta_focus_new_tab_false' class='btn'><?php _e( "No", 'thrive' ); ?></label>
				</div>
			</td>
		</table>
	</div>
	<br/><br/><br/>
	<a class="button button-primary"
	   id="thrive-link-focus-preview"><?php _e( "Update Preview", 'thrive' ); ?></a>
</div>
<br/>
<div id="container-focus-preview">
</div>