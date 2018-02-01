<?php
$config = array(
	'email'    => 'Please enter a valid email address',
	'phone'    => 'Please enter a valid phone number',
	'required' => 'Please fill in the required fields',
)
?>
<div class="thrv_wrapper tve-tqb-page-type tqb-result-template-2 tve_editor_main_content" style="<?php echo $main_content_style; ?>">
	<div class="thrv_wrapper thrv_heading tve-draggable tve-droppable" data-css="tve-u-15d9cf3d12a">
		<h2 data-default="Your Heading Here">
			<span style="font-size: 47px;">Congratulations!</span>
		</h2>
	</div>
	<div class="thrv_wrapper thrv_text_element tve-draggable tve-droppable tve_empty_dropzone">
		<p class="tve-droppable" data-default="Enter your text here..." data-css="tve-u-15d9cf46613">
			<span style="font-size: 19px;">You achieved the following result:</span>
		</p>
	</div>
	<div class="thrv_wrapper thrv_contentbox_shortcode thrv-content-box tve-draggable tve-droppable" data-css="tve-u-15d9cfa5375">
		<div class="tve-content-box-background" data-css="tve-u-15d9cf56168"></div>
		<div class="tve-cb tve_empty_dropzone">
			<div class="thrv_wrapper thrv_text_element tve-draggable tve-droppable">
				<p class="tve-droppable" data-default="Enter your text here..." data-css="tve-u-15d9cf7c493">
					<strong>%result%</strong>
				</p>
			</div>
		</div>
	</div>
	<div class="thrv_wrapper thrv_contentbox_shortcode thrv-content-box tve-draggable tve-droppable" data-css="tve-u-15d9d485f0a">
		<div class="tve-content-box-background" data-css="tve-u-15d9d49ce6b"></div>
		<div class="tve-cb tve_empty_dropzone">
			<div class="thrv_wrapper thrv_text_element tve-draggable tve-droppable">
				<p class="tve-droppable" data-default="Enter your text here..." data-css="tve-u-15d9d47e72b">
					<span><strong>GET YOUR DETAILED RESULTS</strong></span>
				</p>
				<p class="tve-droppable" data-default="Enter your text here..." data-css="tve-u-15d9d88f49c">To get more detailed results use the form below:</p>
			</div>
			<div class="thrv_wrapper thrv_lead_generation tve-draggable tve-droppable" data-connection="api" data-css="tve-u-15d9d4d1def">
				<input type="hidden" class="tve-lg-err-msg" value="{&quot;email&quot;:&quot;Email address invalid&quot;,&quot;phone&quot;:&quot;Phone number invalid&quot;,&quot;password&quot;:&quot;Password invalid&quot;,&quot;passwordmismatch&quot;:&quot;Password mismatch error&quot;,&quot;required&quot;:&quot;Required field missing&quot;}">
				<div class="thrv_lead_generation_container tve_clearfix">
					<form action="#" method="post" novalidate="novalidate">
						<div class="tve_lead_generated_inputs_container tve_clearfix tve_empty_dropzone">
							<div class="tve_lg_input_container tve_lg_input tve-draggable tve-droppable" data-css="tve-u-15d9d4b698f">
								<input type="text" data-field="name" name="name" placeholder="Your name" data-placeholder="Your name">
							</div>
							<div class="tve_lg_input_container tve_lg_input tve-draggable tve-droppable" data-css="tve-u-15d9d4b698c">
								<input type="email" data-field="email" data-required="1" data-validation="email" name="email" placeholder="your_name@domain.com" data-placeholder="your_name@domain.com">
							</div>

							<div class="tve_lg_input_container tve_submit_container tve_lg_submit tve-draggable tve-droppable" data-css="tve-u-15d9d4bd1a0">
								<button type="submit">
									<span>Send me my detailed results</span>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="thrv_wrapper thrv_text_element tve-draggable tve-droppable tve_empty_dropzone">
				<p class="tve-droppable" data-default="Enter your text here...">&#8203;</p>
			</div>
		</div>
	</div>
</div>
