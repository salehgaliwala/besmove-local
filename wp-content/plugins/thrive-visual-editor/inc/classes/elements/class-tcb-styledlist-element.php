<?php
/**
 * Created by PhpStorm.
 * User: Ovidiu
 * Date: 5/9/2017
 * Time: 8:58 AM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

/**
 * Class TCB_Styledlist_Element
 */
class TCB_Styledlist_Element extends TCB_Element_Abstract {

	/**
	 * Name of the element
	 *
	 * @return string
	 */
	public function name() {
		return __( 'Styled List', 'thrive-cb' );
	}

	/**
	 * Return icon class needed for display in menu
	 *
	 * @return string
	 */
	public function icon() {
		return 'styled_list';
	}

	/**
	 * Styled List element identifier
	 *
	 * @return string
	 */
	public function identifier() {
		return ' .thrv-styled_list';
	}


	/**
	 * The HTML is generated from js
	 *
	 * @return string
	 */
	protected function html() {
		return '';
	}


	/**
	 * Component and control config
	 *
	 * @return array
	 */
	public function own_components() {
		return array(
			'styledlist' => array(
				'config' => array(
					'item_spacing' => array(
						'css_suffix' => ' > ul > li',
						'css_prefix' => '#tve_editor ',
						'config'     => array(
							'default' => '20',
							'min'     => '1',
							'max'     => '100',
							'label'   => __( 'List Item Spacing', 'thrive-cb' ),
							'um'      => array( 'px', 'em' ),
							'css'     => 'margin-bottom',
						),
						'extends'    => 'Slider',
					),
					'ModalPicker'  => array(
						'config' => array(
							'label' => __( 'Change all icons', 'thrive-cb' ),
						),
					),
					'icons_color'  => array(
						'config'  => array(
							'label' => __( 'Icons color', 'thrive-cb' ),
						),
						'extends' => 'ColorPicker',
					),
					'preview'      => array(
						'config' => array(
							'sortable' => true,
						),
					),
					'icons_size'   => array(
						'config'  => array(
							'default' => '18',
							'min'     => '8',
							'max'     => '200',
							'label'   => __( 'Icon size', 'thrive-cb' ),
							'um'      => array( 'px' ),
							'css'     => 'fontSize',
						),
						'extends' => 'Slider',
					),
				),
			),
			'typography' => array(
				'disabled_controls' => array(
					'LineHeight',
					'p_spacing',
					'h1_spacing',
					'h2_spacing',
					'h3_spacing',
				),
				'config'            => array(
					'TextAlign' => array(
						'css_suffix'   => ' .thrv-styled-list-item',
						'property'     => 'justify-content',
						'property_val' => array(
							'left'    => 'flex-start',
							'center'  => 'center',
							'right'   => 'flex-end',
							'justify' => 'space-evenly',
						),
					),
				),
			),
		);
	}

	/**
	 * Element category that will be displayed in the sidebar
	 * @return string
	 */
	public function category() {
		return $this->get_thrive_advanced_label();
	}
}
