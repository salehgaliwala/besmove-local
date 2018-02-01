<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package thrive-visual-editor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden
} ?>

<div id="tve-text-component" class="tve-component" data-view="Text">
	<div class="text-options action-group">
		<div class="dropdown-header" data-prop="docked">
			<div class="group-description">
				<?php echo __( 'Text Options', 'thrive-cb' ); ?>
			</div>
			<i></i>
		</div>
		<div class="dropdown-content">
			<div class="tve-control margin-bottom-10" data-view="FontColor"></div>

			<div class="tve-control margin-bottom-10" data-view="FontBackground"></div>

			<hr>

			<div class="row tve-control" data-view="FontFace">
				<div class="col-xs-12">
					<span class="input-label"><?php echo __( 'Font Face', 'thrive-cb' ); ?></span>
				</div>
				<div class="col-xs-12 tcb-input-button-wrapper">
					<div class="col-sep click" data-fn="openFonts"></div>
					<input type="text" class="font-face-input click" data-fn="openFonts" readonly>
					<?php tcb_icon( 'edit', false, 'sidebar', 'tcb-input-button click', array( 'data-fn' => 'openFonts' ) ) ?>
				</div>

			</div>

			<hr>

			<div class="tve-control" data-view="FontSize"></div>

			<hr>

			<div class="tve-control" data-view="LineHeight"></div>

			<hr>

			<div class="row middle-xs">
				<div class="tve-control col-xs-12" data-view="TextTransform"></div>
			</div>
			<hr>

			<div class="tve-advanced-controls extend-grey">
				<div class="dropdown-header" data-prop="advanced">
				<span>
					<?php echo __( 'Advanced', 'thrive-cb' ); ?>
				</span>
					<i></i>
				</div>

				<div class="dropdown-content clear-top">
					<div class="tve-control" data-view="LetterSpacing"></div>
					<hr>
					<div class="tve-control" data-key="typefocus" data-initializer="typefocus_control"></div>
					<hr>
					<div class="text-shadow-component">
						<div class="row middle-xs tcb-shadow-row margin-bottom-10">
							<div class="col-xs-6">
								<span class="input-label"><?php echo __( 'Text Shadow', 'thrive-cb' ); ?></span>
							</div>
							<div class="col-xs-6 tcb-text-right">
								<div class="blue tve-button click" data-fn="add_shadow"><?php echo __( 'Add Shadow', 'thrive-cb' ); ?></div>
							</div>
						</div>
						<div id="tcb-text-shadow-list" class="tcb-relative"></div>
					</div>

				</div>
			</div>

			<hr>
			<div class="tcb-text-center">
				<span class="click tcb-text-uppercase clear-format" data-fn="clear_formatting">
					<?php tcb_icon( 'close2' ) ?>&nbsp;<?php echo __( 'Clear formatting', 'thrive-cb' ) ?>
				</span>
			</div>

		</div>
	</div>
</div>