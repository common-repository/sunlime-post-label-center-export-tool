<?php
	
	add_action( 'wp_ajax_splc_add_packets_row_ajax', 'splc_add_packets_row_ajax' );
	function splc_add_packets_row_ajax(): void
  {
		wp_verify_nonce( 'splc_add_repeater_row' );
		ob_start();
		if ( isset( $_POST['name'] ) ) {
			splc_get_packets_row( sanitize_text_field($_POST['name'] ));
		}
		$content = ob_get_clean();
		wp_send_json_success( array( 'html' => $content ) );
		die();
	}
	
	