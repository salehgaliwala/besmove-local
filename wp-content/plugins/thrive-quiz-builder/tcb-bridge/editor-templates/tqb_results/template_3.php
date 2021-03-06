<?php
if ( empty( $tie_image_url ) ) {
	$tie_image_url = tqb()->plugin_url( 'tcb-bridge/assets/images/share-badge-default.png' );
}
?>
<div class="thrv_wrapper tve-tqb-page-type tqb-result-template-3 tve_editor_main_content" style="<?php echo $main_content_style; ?>">
	<h2>Congratulations!</h2>
	<div class="tqb-social-share-badge-container tcb-no-url thrv_wrapper thrv_social">
		<div class="tve_social_items tve_social_custom tve_social_itb tqb-social-share-buttons tve_style_1" id="tqb-set-2" data-value="set_02">
			<div class="tve_s_item tve_s_fb_share" data-s="fb_share" data-href="{tcb_post_url}"
				 data-image="<?php echo $tie_image_url ?>"
				 data-description="<?php echo Thrive_Quiz_Builder::QUIZ_RESULT_SOCIAL_MEDIA_MSG; ?>">
				<a href="javascript:void(0)" class="tve_s_link">
					<span class="tve_s_icon"></span>
					<span class="tve_s_text">Share</span>
					<span class="tve_s_count">0</span>
				</a>
			</div>
			<div class="tve_s_item tve_s_t_share" data-s="t_share" data-href="{tcb_post_url}"
				 data-tweet="<?php echo Thrive_Quiz_Builder::QUIZ_RESULT_SOCIAL_MEDIA_MSG; ?>">
				<a href="javascript:void(0)" class="tve_s_link">
					<span class="tve_s_icon"></span>
					<span class="tve_s_text">Tweet</span>
					<span class="tve_s_count">0</span>
				</a>
			</div>
			<div class="tve_s_item tve_s_g_share" data-s="g_share" data-href="{tcb_post_url}">
				<a href="javascript:void(0)" class="tve_s_link">
					<span class="tve_s_icon"></span>
					<span class="tve_s_text">Share +1</span>
					<span class="tve_s_count">0</span>
				</a>
			</div>
		</div>
		<img src="<?php echo $tie_image_url ?>">

		<div class="tve_social_overlay"></div>
	</div>
</div>
