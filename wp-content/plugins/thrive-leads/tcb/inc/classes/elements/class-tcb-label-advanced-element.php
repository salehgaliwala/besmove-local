<?php
/**
 * Created by PhpStorm.
 * User: Ovidiu
 * Date: 11/6/2017
 * Time: 5:27 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

require_once 'class-tcb-label-element.php';

/**
 * Class TCB_Label_Advanced_Element
 *
 * Basically is the label element with more features unlocked such as: layout, borders, background
 */
class TCB_Label_Advanced_Element extends TCB_Label_Element {

	/**
	 * Section element identifier
	 *
	 * @return string
	 */
	public function identifier() {
		return '.thrv-advanced-inline-text';
	}

	/**
	 * Removes the unnecessary components from the element json string
	 *
	 * @return array
	 */
	protected function general_components() {
		$general_components = parent::general_components();

		if ( isset( $general_components['typography'] ) ) {
			unset( $general_components['typography'] );
		}
		if ( isset( $general_components['animation'] ) ) {
			unset( $general_components['animation'] );
		}
		if ( isset( $general_components['shadow'] ) ) {
			unset( $general_components['shadow'] );
		}
		if ( isset( $general_components['responsive'] ) ) {
			unset( $general_components['responsive'] );
		}
		if ( isset( $general_components['styles-templates'] ) ) {
			unset( $general_components['styles-templates'] );
		}

		return $general_components;
	}

	/**
	 * Component and control config
	 *
	 * @return array
	 */
	public function own_components() {
		$components = parent::own_components();

		$components['layout'] = array(
			'disabled_controls' => array(
				'MaxWidth',
				'Alignment',
				'.tve-advanced-controls',
				'hr',
			),
			'config'            => array(),
		);

		/**
		 * We remove all this indexes from the components array.
		 * The functionality from here will be handled in general_components function
		 * Reason: not to be added in the element json string
		 */
		if ( isset( $components['typography'] ) ) {
			unset( $components['typography'] );
		}
		if ( isset( $components['borders'] ) ) {
			unset( $components['borders'] );
		}
		if ( isset( $components['animation'] ) ) {
			unset( $components['animation'] );
		}
		if ( isset( $components['background'] ) ) {
			unset( $components['background'] );
		}

		if ( isset( $components['responsive'] ) ) {
			unset( $components['responsive'] );
		}

		if ( isset( $components['styles-templates'] ) ) {
			unset( $components['styles-templates'] );
		}

		if ( isset( $components['shadow'] ) ) {
			unset( $components['shadow'] );
		}

		return $components;
	}
}
