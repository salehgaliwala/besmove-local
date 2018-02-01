<?php
/**
 * Created by PhpStorm.
 * User: Ovidiu
 * Date: 6/30/2017
 * Time: 2:19 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

class TCB_Social_Share_Badge_Element extends TCB_Social_Element {

	/**
	 * Name of the element
	 *
	 * @return string
	 */
	public function name() {
		return __( 'Social Share Badge', Thrive_Quiz_Builder::T );
	}

	/**
	 * Return icon class needed for display in menu
	 *
	 * @return string
	 */
	public function icon() {
		return 'social_share_badge';
	}

	/**
	 * Element identifier
	 *
	 * @return string
	 */
	public function identifier() {
		return '.tqb-social-share-badge-container'; //For backwards compatibility
	}

	/**
	 * Element HTML
	 *
	 * @return string
	 */
	public function html() {
		$content = '';
		ob_start();
		include tqb()->plugin_path( 'tcb-bridge/editor-layouts/elements/social-share-badge.php' );
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}


	/**
	 * This is only a placeholder element
	 *
	 * @return bool
	 */
	public function is_placeholder() {
		return false;
	}

	/**
	 * Component and control config
	 *
	 * @return array
	 */
	public function own_components() {

		$components                           = parent::own_components();
		$components['tqb_social_share_badge'] = $components['social'];
		$components['styles-templates']       = array( 'hidden' => true );


		unset( $components['social'] );
//		unset( $components['tqb_social_share_badge']['config']['custom_url'] );
		$components['tqb_social_share_badge']['config']['preview']['config']['settingsIcon'] = false;
		$components['tqb_social_share_badge']['disabled_controls']                           = array(
			'total_share',
			'counts',
		);
		$components['layout']['config']['Alignment']['to']                                   = ' .tve_social_items';


		//total_share
		return $components;
	}

	/**
	 * Element category that will be displayed in the sidebar
	 * @return string
	 */
	public function category() {
		return __( 'Thrive Quiz Builder', Thrive_Quiz_Builder::T );
	}
}
