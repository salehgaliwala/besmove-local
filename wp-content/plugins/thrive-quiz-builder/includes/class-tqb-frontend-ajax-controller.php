<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

/**
 * Class TQB_Frontend_Ajax_Controller
 *
 * Ajax controller to handle frontend ajax requests
 * Specially built for backbone models
 */
class TQB_Frontend_Ajax_Controller {

	/**
	 * @var TQB_Frontend_Ajax_Controller $instance
	 */
	protected static $instance;

	/**
	 * TQB_Frontend_Ajax_Controller constructor.
	 * Protected constructor because we want to use it as singleton
	 */
	protected function __construct() {
	}

	/**
	 * Gets the SingleTone's instance
	 *
	 * @return TQB_Frontend_Ajax_Controller
	 */
	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new TQB_Frontend_Ajax_Controller();
		}

		return self::$instance;
	}

	/**
	 * Sets the request's header with server protocol and status
	 * Sets the request's body with specified $message
	 *
	 * @param string $message the error message.
	 * @param string $status the error status.
	 */
	protected function error( $message, $status = '404 Not Found' ) {
		header( $_SERVER['SERVER_PROTOCOL'] . ' ' . $status );
		echo esc_attr( $message );
		wp_die();
	}

	/**
	 * Returns the params from $_POST or $_REQUEST
	 *
	 * @param int $key the parameter kew.
	 * @param null $default the default value.
	 *
	 * @return mixed|null|$default
	 */
	protected function param( $key, $default = null ) {
		return isset( $_POST[ $key ] ) ? $_POST[ $key ] : ( isset( $_REQUEST[ $key ] ) ? $_REQUEST[ $key ] : $default );
	}

	/**
	 * Entry-point for each ajax request
	 * This should dispatch the request to the appropriate method based on the "route" parameter
	 *
	 * @return array|object
	 */
	public function handle() {
		if ( ! check_ajax_referer( 'tqb_frontend_ajax_request', '_nonce', false ) ) {
			$this->error( sprintf( __( 'Invalid request.', Thrive_Quiz_Builder::T ) ) );
		}

		$route = $this->param( 'route' );

		$route       = preg_replace( '#([^a-zA-Z0-9-])#', '', $route );
		$method_name = $route . '_action';

		if ( ! method_exists( $this, $method_name ) ) {
			$this->error( sprintf( __( 'Method %s not implemented', Thrive_Quiz_Builder::T ), $method_name ) );
		}

		return $this->{$method_name}();
	}

	/**
	 * Performs actions for Quiz based on request's method and model
	 * Dies with error if the operation was not executed
	 *
	 * @return mixed
	 */
	protected function shortcode_action() {
		$method = empty( $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] ) ? 'GET' : $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];

		$custom = $this->param( 'custom_action' );
		if ( ! empty( $custom ) ) {
			if ( $custom === 'log_social_share_conversion' ) {
				do_action( 'tqb_register_social_media_conversion', $_POST );

				return true;
			} elseif ( $custom === 'save_user_custom_social_share_badge' ) {

				if ( ! isset( $_FILES['user_badge'] ) ) {
					$this->error( __( 'Share Badge not available', Thrive_Quiz_Builder::T ) );
				}

				if ( ! class_exists( 'TQB_Badge' ) ) {
					require_once dirname( __FILE__ ) . '/class-tqb-badge.php';
				}

				$result  = $this->param( 'result' );
				$quiz_id = $this->param( 'quiz_id' );

				$badge = new TQB_Badge( $result, $quiz_id );
				$url   = $badge->save( $_FILES['user_badge'] );

				if ( empty( $url ) ) {
					$this->error( __( 'Badge could not be generated', Thrive_Quiz_Builder::T ) );
				}

				do_action( 'tqb_generate_user_social_badge_link', $_REQUEST['user_id'], $url );

				return $url . '?' . rand();
			}
		}

		switch ( $method ) {
			case 'POST':
				break;
			case 'PUT':
			case 'PATCH':
				break;
			case 'DELETE':
				break;
			case 'GET':
				$quiz_id         = $this->param( 'quiz_id' );
				$page_type       = $this->param( 'page_type' );
				$answer_id       = $this->param( 'answer_id' );
				$user_unique     = $this->param( 'user_unique' );
				$variation       = $this->param( 'variation' );
				$post_id         = $this->param( 'tqb-post-id' );
				$in_tcb_editor   = $this->param( 'tqb_in_tcb_editor', null );
				$data            = TQB_Quiz_Manager::get_shortcode_content( $quiz_id, $page_type, $answer_id, $user_unique, $variation, $post_id );
				$data['quiz_id'] = $quiz_id;
				if ( empty( $data ) ) {
					$this->error( __( 'You have nothing', Thrive_Quiz_Builder::T ) );
				}

				if ( $in_tcb_editor === 'inside_tcb' ) {
					$html = tqb_render_shortcode( array( 'quiz_id' => $quiz_id, 'in_tcb_editor' => $in_tcb_editor ) );

					return $html;
				}

				return $data;
				break;
		}
	}
}
