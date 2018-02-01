<?php
/**
 * Created by PhpStorm.
 * User: Ovidiu
 * Date: 10/24/2017
 * Time: 4:06 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden!
}
?>

<div id="tve-lp-text-typography-component" class="tve-component" data-view="LpTextTypography">
	<div class="dropdown-header" data-prop="docked">
		<div class="group-description"><?php echo __( 'Typography', 'thrive-cb' ) ?></div>
		<i></i>
	</div>
	<div class="dropdown-content">
		<div class="tve-control tcb-hidden" data-view="ButtonGroup" data-key="LinkStates"></div>

		<div class="tve-control lp-text-hide-states" data-view="FontSize"></div>
		<hr class="lp-text-hide-states">

		<div class="tve-control" data-view="FontColor"></div>
		<hr>
		<div class="row">
			<div class="tve-control col-xs-6 lp-text-hide-states" data-view="TextAlign"></div>
			<div class="tve-control col-xs-6" data-view="TextStyle"></div>
		</div>
		<div class="row margin-top-10">
			<div class="col-xs-1 blue-text"><?php tcb_icon( 'info' ); ?></div>
			<div class="col-xs-11 info-text"><?php echo __( 'Notice: Due to some CSS limitations Underline and Strikethrough can not be removed inline.', 'thrive-cb' ); ?></div>
		</div>
		<hr class="lp-text-hide-states">
		<div class="row middle-xs lp-text-hide-states">
			<div class="tve-control col-xs-12" data-view="TextTransform"></div>
		</div>
		<hr class="lp-text-hide-states">
		<div class="row tve-control lp-text-hide-states" data-view="FontFace">
			<div class="col-xs-12">
				<span class="input-label"><?php echo __( 'Font Face', 'thrive-cb' ); ?></span>
			</div>
			<div class="col-xs-12 tcb-input-button-wrapper">
				<div class="col-sep click" data-fn="openFonts"></div>
				<input type="text" class="font-face-input click" data-fn="openFonts" readonly>
				<?php tcb_icon( 'edit', false, 'sidebar', 'tcb-input-button click', array( 'data-fn' => 'openFonts' ) ) ?>
			</div>
		</div>
		<hr class="lp-text-hide-states">
		<div class="tve-control lp-text-hide-states" data-view="LineHeight"></div>
		<div class="tve-advanced-controls extend-grey lp-text-hide-states">
			<div class="dropdown-header" data-prop="advanced">
				<span>
					<?php echo __( 'Advanced', 'thrive-cb' ); ?>
				</span>
				<i></i>
			</div>

			<div class="dropdown-content clear-top">
				<div class="tve-control" data-view="LetterSpacing"></div>
				<hr>
				<div class="text-shadow-component margin-bottom-10">
					<div class="row middle-xs tcb-shadow-row margin-bottom-10">
						<div class="col-xs-6">
							<span class="input-label"><?php echo __( 'Text Shadow', 'thrive-cb' ); ?></span>
						</div>
						<div class="col-xs-6">
							<div class="row">
								<div class="blue tve-button click" data-fn="add_shadow"><?php echo __( 'Add Shadow', 'thrive-cb' ); ?></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div id="tcb-text-shadow-list" class="tcb-relative"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="tcb-text-center">
				<span class="click tcb-text-uppercase clear-format" data-fn="clear_landing_page_text_formatting">
					<?php tcb_icon( 'close2' ) ?>&nbsp;<?php echo __( 'Clear formatting', 'thrive-cb' ) ?>
				</span>
		</div>

	</div>
</div>

<div id="tve-lp-text-layout-component" class="tve-component" data-view="LpTextLayout"></div>

<div id="tve-lp-text-background-component" class="tve-component" data-view="LpTextBackground">
	<div class="dropdown-header" data-prop="docked">
		<div class="group-description"><?php echo __( 'Background Style', 'thrive-cb' ) ?></div>
		<i></i>
	</div>
	<div class="dropdown-content">
		<div class="gradient-layers"></div>
		<div class="tve-control" data-view="PreviewList"></div>
		<div class="v-sep"></div>
		<div class="tve-control" data-view="ColorPicker" data-show-gradient="0"></div>
		<div class="tve-control video-bg" data-key="video" data-initializer="video"></div>
	</div>
</div>

<div id="tve-lp-text-borders-component" class="tve-component" data-view="Borders">
	<div class="borders-options action-group">
		<div class="dropdown-header" data-prop="docked">
			<div class="group-description">
				<?php echo __( 'Borders & Corners', 'thrive-cb' ); ?>
			</div>
			<i></i>
		</div>
		<div class="dropdown-content">
			<div class="tve-control" data-view="LpTextBorders"></div>
			<hr>
			<div class="tve-control" data-view="LpTextCorners"></div>
		</div>
	</div>
</div>

<div id="tve-lp-text-shadow-component" class="tve-component" data-view="LpTextShadow">
	<div class="borders-options action-group">
		<div class="dropdown-header" data-prop="docked">
			<div class="group-description">
				<?php echo __( 'Shadow', 'thrive-cb' ); ?>
			</div>
			<i></i>
		</div>
		<div class="dropdown-content">
			<div class="tve-shadow" id="tcb-shadow-buttons"></div>
			<div id="tcb-box-shadow-list" class="tcb-relative"></div>
		</div>
	</div>

</div>
