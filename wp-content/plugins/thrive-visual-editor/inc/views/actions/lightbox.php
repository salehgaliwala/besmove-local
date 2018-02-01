<div id="lb-container"></div>

<select class="tcb-dark" id="lb-animation">
	<?php foreach ( $data as $k => $s ) : ?>
		<option value="<?php echo esc_attr( $k ) ?>"><?php echo esc_html( $s ) ?></option>
	<?php endforeach ?>
</select>
