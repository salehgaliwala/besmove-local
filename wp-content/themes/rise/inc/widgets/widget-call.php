<?php

class Thrive_Call_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_thrive_call',
			'description' => __( 'Attention grabbing message with a linked button.', 'thrive' )
		);
		parent::__construct( 'widget_thrive_call', __( 'Thrive Call-To-Action Widget', 'thrive' ), $widget_ops );
		$this->alt_option_name = 'widget_thrive_call';

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
		$action_link_target     = ( $instance['link_new_tab'] == 1 ) ? "_blank" : "_self";
		if ( empty( $instance['custom_image'] ) ) {
			$instance['custom_image'] = get_template_directory_uri() . "/images/defaultpic.jpg";
		}
		$widget_style = ( isset( $instance['widget_style'] ) && ! empty( $instance['widget_style'] ) ) ? $instance['widget_style'] : 1;
		?>
		<section class="widget cta_widget" id="<?php echo $args['widget_id']; ?>">
			<!--todo trebuie sa fie 3-->
			<div class="opt opt-<?php echo $widget_style; ?> <?php echo $widget_container_class; ?>"
			     style="background-image: url('<?php echo $instance['custom_image']; ?>')">
				<div class="opt-h">
					<h3><?php echo $instance['headline_text'] ?></h3>
				</div>
				<div class="opt-c">
					<p><?php echo $instance['body_text'] ?></p>
					<a href="<?php echo $instance['button_link'] ?>" target="<?php echo $action_link_target; ?>"
					   class="btn full small <?php echo $btn_color_class; ?>"><span><?php echo $instance['button_text'] ?></span></a>
				</div>
			</div>
		</section>

		<?php if ( isset( $args['id'] ) && $args['id'] == "sidebar-1" ): ?>
		<?php endif; ?>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance['title']         = strip_tags( $new_instance['title'] );
		$instance['color']         = strip_tags( $new_instance['color'] );
		$instance['headline_text'] = strip_tags( $new_instance['headline_text'] );
		$instance['body_text']     = strip_tags( $new_instance['body_text'] );
		$instance['button_text']   = strip_tags( $new_instance['button_text'] );
		$instance['button_link']   = strip_tags( $new_instance['button_link'] );
		$instance['link_new_tab']  = (int) $new_instance['link_new_tab'];
		$instance['custom_image']  = strip_tags( $new_instance['custom_image'] );
		$instance['widget_style']  = (int) $new_instance['widget_style'];
		$instance['button_color']  = strip_tags( $new_instance['button_color'] );

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_thrive_call'] ) ) {
			delete_option( 'widget_thrive_call' );
		}

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_thrive_call', 'widget' );
	}

	function form( $instance ) {
		$title         = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$color         = isset( $instance['color'] ) ? esc_attr( $instance['color'] ) : '';
		$headline_text = isset( $instance['headline_text'] ) ? esc_attr( $instance['headline_text'] ) : '';
		$body_text     = isset( $instance['body_text'] ) ? esc_attr( $instance['body_text'] ) : '';
		$button_text   = isset( $instance['button_text'] ) ? esc_attr( $instance['button_text'] ) : '';
		$button_link   = isset( $instance['button_link'] ) ? esc_attr( $instance['button_link'] ) : '';
		$link_new_tab  = isset( $instance['link_new_tab'] ) ? absint( $instance['link_new_tab'] ) : 0;
		$custom_image  = isset( $instance['custom_image'] ) ? esc_attr( $instance['custom_image'] ) : '';
		$widget_style  = isset( $instance['widget_style'] ) ? absint( $instance['widget_style'] ) : 1;
		$button_color  = isset( $instance['button_color'] ) ? esc_attr( $instance['button_color'] ) : '';

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
			<input class="widefat thrive_call_widget_txt_image"
			       id="<?php echo esc_attr( $this->get_field_id( 'custom_image' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'custom_image' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $custom_image ); ?>"/>
			<input type='button' class="thrive_call_widget_btn_upload"
			       id='<?php echo esc_attr( $this->get_field_id( 'custom_image' ) ); ?>_btn_upload'
			       value='<?php _e( 'Upload', 'thrive' ); ?>'/>

		</p>

		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php _e( 'Button text:', 'thrive' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $button_text ); ?>"/></p>

		<p><label
				for="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"><?php _e( 'Button link:', 'thrive' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'button_link' ) ); ?>" type="text"
			       value="<?php echo esc_attr( $button_link ); ?>"/></p>


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

		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'link_new_tab' ) ); ?>"><?php _e( 'Open Link in', 'thrive' ); ?></label>
			<?php _e( 'Same tab', 'thrive' ); ?>
			<input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'link_new_tab' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'link_new_tab' ) ); ?>"
			       <?php if ( $link_new_tab == 0 ): ?>checked<?php endif ?> value="0"/>
			<?php _e( 'New tab', 'thrive' ); ?>
			<input type="radio" name="<?php echo esc_attr( $this->get_field_name( 'link_new_tab' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'link_new_tab' ) ); ?>"
			       <?php if ( $link_new_tab == 1 ): ?>checked<?php endif ?> value="1"/>

		</p>

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