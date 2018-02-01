<?php

class Thrive_Optin_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_thrive_optin',
			'description' => __( 'Get more subscribers for your newsletter/mailing list.', 'thrive' )
		);
		parent::__construct( 'widget_thrive_optin', __( 'Thrive Opt-in Widget', 'thrive' ), $widget_ops );
		$this->alt_option_name = 'widget_thrive_optin';

		add_action( 'save_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = "widget-thrive" . rand( 0, 999 );
		}

		$widget_container_class = strtolower( $instance['color'] );
		$btn_color_class        = ( isset( $instance['button_color'] ) ) ? strtolower( $instance['button_color'] ) : "blue";

		if ( ! isset( $instance['optin'] ) || ( isset( $instance['optin'] ) && ! get_post( $instance['optin'] ) ) ) {
			echo "There are some problems with the configuration of the opt-in widget";

			return;
		}

		//form action
		$optinFormAction = get_post_meta( $instance['optin'], '_thrive_meta_optin_form_action', true );

		//form method
		$optinFormMethod = get_post_meta( $instance['optin'], '_thrive_meta_optin_form_method', true );
		$optinFormMethod = strtolower( $optinFormMethod );
		$optinFormMethod = $optinFormMethod === 'post' || $optinFormMethod === 'get' ? $optinFormMethod : 'post';

		//form hidden inputs
		$optinHiddenInputs = get_post_meta( $instance['optin'], '_thrive_meta_optin_hidden_inputs', true );

		//form fields
		$optinFieldsJson  = get_post_meta( $instance['optin'], '_thrive_meta_optin_fields_array', true );
		$optinFieldsArray = json_decode( $optinFieldsJson, true );

		//form not visible inputs
		$optinNotVisibleInputs = get_post_meta( $instance['optin'], '_thrive_meta_optin_not_visible_inputs', true );

		if ( empty( $instance['custom_image'] ) ) {
			$instance['custom_image'] = get_template_directory_uri() . "/images/defaultpic.jpg";
		}
		$widget_style = ( isset( $instance['widget_style'] ) && ! empty( $instance['widget_style'] ) ) ? $instance['widget_style'] : 1;

		if ( ! is_array( $optinFieldsArray ) ) {
			echo "There are some problems with the configuration of the opt-in widget";

			return;
		}
		?>
		<section class="widget" id="<?php echo $args['widget_id']; ?>">
			<div class="opt opt-<?php echo $widget_style; ?> <?php echo $widget_container_class; ?>"
			     style="background-image: url('<?php echo $instance['custom_image']; ?>')">
				<div class="opt-h">
					<h3><?php echo $instance['headline_text'] ?></h3>
				</div>
				<div class="opt-c">
					<p>
						<?php echo $instance['body_text'] ?>
					</p>
					<form class="ofr" action="<?php echo $optinFormAction; ?>" method="<?php echo $optinFormMethod ?>">

						<?php echo $optinHiddenInputs; ?>

						<?php echo $optinNotVisibleInputs; ?>

						<?php foreach ( $optinFieldsArray as $name_attr => $field_label ): ?>
							<?php echo Thrive_OptIn::getInstance()->getInputHtml( $name_attr, $field_label, array( 'optin_email' ) ) ?>
						<?php endforeach; ?>

						<div class="btn full small <?php echo $btn_color_class; ?>">
							<button type="submit"><?php echo $instance['button_text']; ?></button>
						</div>
					</form>
				</div>
			</div>
		</section>


		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance['title']         = strip_tags( $new_instance['title'] );
		$instance['color']         = strip_tags( $new_instance['color'] );
		$instance['headline_text'] = strip_tags( $new_instance['headline_text'] );
		$instance['body_text']     = strip_tags( $new_instance['body_text'] );
		$instance['button_text']   = strip_tags( $new_instance['button_text'] );
		$instance['custom_image']  = strip_tags( $new_instance['custom_image'] );
		$instance['optin']         = (int) $new_instance['optin'];
		$instance['widget_style']  = strip_tags( $new_instance['widget_style'] );
		$instance['button_color']  = strip_tags( $new_instance['button_color'] );

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_thrive_optin'] ) ) {
			delete_option( 'widget_thrive_optin' );
		}

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_thrive_optin', 'widget' );
	}

	function form( $instance ) {
		$title         = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$color         = isset( $instance['color'] ) ? esc_attr( $instance['color'] ) : '';
		$headline_text = isset( $instance['headline_text'] ) ? esc_attr( $instance['headline_text'] ) : '';
		$body_text     = isset( $instance['body_text'] ) ? esc_attr( $instance['body_text'] ) : '';
		$button_text   = isset( $instance['button_text'] ) ? esc_attr( $instance['button_text'] ) : '';
		$custom_image  = isset( $instance['custom_image'] ) ? esc_attr( $instance['custom_image'] ) : '';
		$optin         = isset( $instance['optin'] ) ? absint( $instance['optin'] ) : 0;
		$widget_style  = isset( $instance['widget_style'] ) ? absint( $instance['widget_style'] ) : 1;
		$button_color  = isset( $instance['button_color'] ) ? esc_attr( $instance['button_color'] ) : '';

		$queryOptins = new WP_Query(array(
			'post_type' => 'thrive_optin',
			'posts_per_page' => -1,
			'order' => 'ASC',
			'post_status' => 'publish'
		));

		$all_colors = _thrive_get_color_scheme_options( "optin" );
		?>
		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'thrive' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/></p>

		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>"><?php _e( 'Color', 'thrive' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>">
				<?php foreach ( $all_colors as $key => $c ): ?>
					<option value="<?php echo $key; ?>"
					        <?php if ( $color == $key ): ?>selected<?php endif ?>><?php echo $c; ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'headline_text' ) ); ?>"><?php _e( 'Headline text:', 'thrive' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'headline_text' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'headline_text' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $headline_text ); ?>"/></p>

		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'body_text' ) ); ?>"><?php _e( 'Text:', 'thrive' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'body_text' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'body_text' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $body_text ); ?>"/></p>

		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'custom_image' ) ); ?>"><?php _e( 'Custom image:', 'thrive' ); ?></label>
			<input class="widefat thrive_optin_widget_txt_image"
			       id="<?php echo esc_attr( $this->get_field_id( 'custom_image' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'custom_image' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $custom_image ); ?>"/>
			<input type='button' class="thrive_optin_widget_btn_upload"
			       id='<?php echo esc_attr( $this->get_field_id( 'custom_image' ) ); ?>_btn_upload'
			       value='<?php _e( 'Upload', 'thrive' ); ?>'/>
		</p>


		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'button_color' ) ); ?>"><?php _e( 'Button Color', 'thrive' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'button_color' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'button_color' ) ); ?>">
				<?php foreach ( $all_colors as $key => $c ): ?>
					<option value="<?php echo $key; ?>"
					        <?php if ( $button_color == $key ): ?>selected<?php endif ?>><?php echo $c; ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php _e( 'Button text:', 'thrive' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $button_text ); ?>"/></p>

		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'optin' ) ); ?>"><?php _e( 'Opt-In Integration', 'thrive' ); ?></label>
			<select name='<?php echo esc_attr( $this->get_field_name( 'optin' ) ); ?>'>
				<option value='0'></option>
				<?php foreach ( $queryOptins->get_posts() as $p ): ?>
					<option value='<?php echo $p->ID ?>'
					        <?php if ( $optin == $p->ID ): ?>selected<?php endif; ?>><?php echo $p->post_title; ?></option>
				<?php endforeach; ?>
			</select></p>

		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'widget_style' ) ); ?>"><?php _e( 'Widget Style', 'thrive' ); ?></label>
			<br/>
			<img src="<?php echo get_template_directory_uri() . '/inc/images/cta1.jpg' ?>" alt=""/>
			<input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'widget_style' ) ); ?>" class=""
			       value="1" <?php if ( $widget_style != 2 && $widget_style != 3 ): ?>checked<?php endif ?> />
			<img src="<?php echo get_template_directory_uri() . '/inc/images/cta2.jpg' ?>" alt=""/>
			<input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'widget_style' ) ); ?>" class=""
			       value="2" <?php if ( $widget_style == 2 ): ?>checked<?php endif ?> />
			<img src="<?php echo get_template_directory_uri() . '/inc/images/cta3.jpg' ?>" alt=""/>
			<input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'widget_style' ) ); ?>" class=""
			       value="3" <?php if ( $widget_style == 3 ): ?>checked<?php endif ?> />
		</p>

		<script type="text/javascript">
			if ( ThriveWidgetsOptions.controls_binded === 0 ) {
				ThriveWidgetsOptions.bind_handlers();
			}
		</script>

		<?php
	}

}