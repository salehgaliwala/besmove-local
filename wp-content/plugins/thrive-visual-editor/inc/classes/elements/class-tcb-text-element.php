<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-visual-editor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}

/**
 * Class TCB_Text_Element
 */
class TCB_Text_Element extends TCB_Element_Abstract {

	/**
	 * Name of the element
	 *
	 * @return string
	 */
	public function name() {
		return __( 'Paragraph / Text', 'thrive-cb' );
	}

	/**
	 * Return icon class needed for display in menu
	 *
	 * @return string
	 */
	public function icon() {
		return 'text';
	}

	/**
	 * Text element identifier
	 *
	 * @return string
	 */
	public function identifier() {
		return '.thrv_wrapper.thrv_text_element';
	}

	/**
	 * Component and control config
	 *
	 * @return array
	 */
	public function own_components() {
		return array(
			'text'       => array(
				'config' => array(
					'FontSize'       => array(
						'config'  => array(
							'default' => '16',
							'min'     => '1',
							'max'     => '100',
							'label'   => __( 'Font Size', 'thrive-cb' ),
							'um'      => array( 'px', 'em' ),
							'css'     => 'fontSize',
						),
						'extends' => 'Slider',
					),
					'LineHeight'     => array(
						'config'  => array(
							'default' => '1',
							'min'     => '1',
							'max'     => '200',
							'label'   => __( 'Line Height', 'thrive-cb' ),
							'um'      => array( 'em', 'px' ),
							'css'     => 'lineHeight',
						),
						'extends' => 'Slider',
					),
					'LetterSpacing'  => array(
						'config'  => array(
							'default' => 'auto',
							'min'     => '0',
							'max'     => '100',
							'label'   => __( 'Letter Spacing', 'thrive-cb' ),
							'um'      => array( 'px' ),
							'css'     => 'letterSpacing',
						),
						'extends' => 'Slider',
					),
					'FontColor'      => array(
						'config'  => array(
							'default' => '000',
							'label'   => __( 'Font Color', 'thrive-cb' ),
							'options' => array(
								'output' => 'object',
							),
						),
						'extends' => 'ColorPicker',
					),
					'FontBackground' => array(
						'config'  => array(
							'default' => '000',
							'label'   => __( 'Font Highlight', 'thrive-cb' ),
							'options' => array(
								'output' => 'object',
							),
						),
						'extends' => 'ColorPicker',
					),
					'FontFace'       => array(
						'config'  => array(
							'template' => 'controls/font-manager',
							'tinymce'  => true,
						),
						'extends' => 'FontManager',
					),
					'TextTransform'  => array(
						'config'  => array(
							'name'    => 'Text Transform',
							'buttons' => array(
								array(
									'icon'    => 'none',
									'text'    => '',
									'value'   => 'none',
									'default' => true,
								),
								array(
									'icon'  => 'format-all-caps',
									'text'  => '',
									'value' => 'uppercase',
								),
								array(
									'icon'  => 'format-capital',
									'text'  => '',
									'value' => 'capitalize',
								),
								array(
									'icon'  => 'format-lowercase',
									'text'  => '',
									'value' => 'lowercase',
								),
							),
						),
						'extends' => 'ButtonGroup',
					),
				),
			),
			'layout'     => array(
				'config' => array(
					'MarginAndPadding' => array(),
					'MaxWidth'         => array(),
					'Position'         => array(
						'important' => true,
					),
				),
			),
			'borders'    => array(
				'config' => array(
					'Borders' => array(
						'important' => true,
					),
					'Corners' => array(
						'important' => true,
					),
				),
			),
			'shadow'     => array(
				'config' => array(
					'css_attribute' => 'box-shadow',
					'important'     => true,
				),
			),
			'typography' => array(
				'hidden' => true,
			),
			'animation'  => array(
				'disabled_controls' => array(
					'.btn-inline:not(.anim-animation)',
				),
			),
		);
	}

	/**
	 * Element category that will be displayed in the sidebar
	 *
	 * @return string
	 */
	public function category() {
		return $this->get_thrive_basic_label();
	}
}
