<div class="hru" data-count="<?php echo count( $thrive_gallery_ids ); ?>">
	<div class="hui" id="thrive-gallery-header-<?php echo get_the_ID(); ?>"
	     style="background: url('<?php echo $first_img_url; ?>');"
	     data-index="0" data-count="<?php echo count( $thrive_gallery_ids ); ?>" data-carousel="0">
		<img id="thive-gallery-dummy" class="tt-dmy gallery-dmy" src="<?php echo $first_img_url; ?>" alt="">
	</div>
	<div class="gnav clearfix">
		<div class="gwrp">
			<a class="gprev" href=""></a>
			<div class="g-ov">
				<ul class="g-ul clearfix">
					<?php
					foreach ( $thrive_gallery_ids as $key => $id ):
						$img_url = wp_get_attachment_url( $id );
						if ( $img_url ):
							?>
							<li id="li-thrive-gallery-item-<?php echo $key; ?>">
								<a class="thrive-gallery-item" href=""
								   style="background-image: url('<?php echo $img_url; ?>');"
								   data-src="<?php echo $img_url; ?>"
								   data-index="<?php echo $key; ?>">

								</a>
							</li>
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</div>
			<a class="gnext" href=""></a>
		</div>
	</div>
</div>