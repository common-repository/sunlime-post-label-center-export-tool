<?php
	/*
	 * Initialize Settings Page
	 *
	 * Initializes the settings page by adding all necessary option fields and sections
	 *
	 */
	function splc_settings_init() {
		register_setting( 'splc', 'splc_options' );
		add_settings_section( 'splc_section_sender', __( 'Shipper Data', 'splc' ), 'splc_section_sender_cb', 'splc' );
		add_settings_field( 'splc_field_name', __( 'Name*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_sender', [
			'label_for'       => 'splc_field_name',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'Name', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		add_settings_field( 'splc_field_street', __( 'Street*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_sender', [
			'label_for'       => 'splc_field_street',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'Street', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		add_settings_field( 'splc_field_housenumber', __( 'House number*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_sender', [
			'label_for'       => 'splc_field_housenumber',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'House number', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		add_settings_field( 'splc_field_postcode', __( 'Postcode*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_sender', [
			'label_for'       => 'splc_field_postcode',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'Postcode', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		add_settings_field( 'splc_field_city', __( 'City*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_sender', [
			'label_for'       => 'splc_field_city',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'City', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		add_settings_field( 'splc_field_country', __( 'Country*', 'splc' ), 'splc_dropdown_field_cb', 'splc', 'splc_section_sender', [
			'label_for'       => 'splc_field_country',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'Country', 'splc' ),
			'splc_custom_data' => 'custom',
			'array'           => splc_get_woocommerce_countries()
		] );
		add_settings_field( 'splc_field_phone', __( 'Phone*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_sender', [
			'label_for'       => 'splc_field_phone',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'Phone', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		
		add_settings_section( 'splc_section_splc_data', __( 'PLC Data', 'splc' ), 'splc_section_splc_data_cb', 'splc' );
		add_settings_field( 'splc_field_soap_url', __( 'WSDL Endpoint*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_splc_data', [
			'label_for'       => 'splc_field_soap_url',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'WSDL Endpoint', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		add_settings_field( 'splc_field_client_id', __( 'ClientID*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_splc_data', [
			'label_for'       => 'splc_field_client_id',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'ClientID', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		add_settings_field( 'splc_field_org_unit_id', __( 'OrgUnitID*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_splc_data', [
			'label_for'       => 'splc_field_org_unit_id',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'OrgUnitID', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		add_settings_field( 'splc_field_org_unit_guid', __( 'OrgUnitGUID*', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_splc_data', [
			'label_for'       => 'splc_field_org_unit_guid',
			'class'           => 'splc_row',
			'required'        => true,
			'placeholder'     => __( 'OrgUnitGUID', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		
		add_settings_field( 'splc_field_standard_packets', __( 'Standard Packets', 'splc' ), 'splc_standard_packets_cb', 'splc', 'splc_section_splc_data', [
			'label_for'       => 'splc_field_standard_packets',
			'class'           => 'splc_row',
			'placeholder'     => __( 'Standard Packets', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
		add_settings_field( 'splc_field_standard_unit', __( 'Standard Unit', 'splc' ), 'splc_dropdown_field_cb', 'splc', 'splc_section_splc_data', [
			'label_for'       => 'splc_field_standard_unit',
			'class'           => 'splc_row',
			'placeholder'     => __( 'Standard Unit', 'splc' ),
			'splc_custom_data' => 'custom',
			'array'           => splc_get_units()
		] );
		add_settings_field( 'splc_field_standard_customs_option', __( 'Standard Customs Option', 'splc' ), 'splc_dropdown_field_cb', 'splc', 'splc_section_splc_data', [
			'label_for'       => 'splc_field_standard_customs_option',
			'class'           => 'splc_row',
			'placeholder'     => __( 'Standard Customs Option', 'splc' ),
			'splc_custom_data' => 'custom',
			'array'           => splc_get_customs_options()
		] );
		add_settings_field( 'splc_field_standard_country_of_origin', __( 'Standard Country of Origin', 'splc' ), 'splc_dropdown_field_cb', 'splc', 'splc_section_splc_data', [
			'label_for'       => 'splc_field_standard_country_of_origin',
			'class'           => 'splc_row',
			'placeholder'     => __( 'Standard Country of Origin', 'splc' ),
			'splc_custom_data' => 'custom',
			'array'           => splc_get_woocommerce_countries()
		] );
		add_settings_field( 'splc_field_standard_customs_number', __( 'Standard Customs Number', 'splc' ), 'splc_text_field_cb', 'splc', 'splc_section_splc_data', [
			'label_for'       => 'splc_field_standard_customs_number',
			'class'           => 'splc_row',
			'placeholder'     => __( 'Standard Customs Number', 'splc' ),
			'splc_custom_data' => 'custom',
		] );
    add_settings_field( 'splc_field_automatic_complete_order', __( 'Set Order automatically completed', 'splc' ), 'splc_checkbox_field_cb', 'splc', 'splc_section_splc_data', [
      'label_for'       => 'splc_field_automatic_complete_order',
      'label'     => __( 'If set the order will be automatically completed, if it has been successfully added to plc.', 'splc'),
      'class'           => 'splc_row',
      'splc_custom_data' => 'custom',
    ] );
	}
	
	add_action( 'admin_init', 'splc_settings_init' );
	
	function splc_section_sender_cb( $args ) {
	}
	
	function splc_section_splc_data_cb( $args ) {
	}
	
	function splc_standard_packets_cb( $args ) {
		?>
    <div class="c-splc__info">
      <div class="c-splc__info-text">
				<?php _e( 'Here you can select for each country the according packet, which has to be used in the export', 'splc' ); ?>
      </div>
    </div>
    <div class="c-splc__fields js-splc__repeater">
			<?php
				$options = get_option( 'splc_options' );
				splc_add_packet_rows( $args, $options );
			?>
    </div>
    <div class="o-button js-splc__add-entry o-button--with-loader" data-name="<?php echo $args['label_for']; ?>"
         data-nonce="<?php wp_create_nonce( 'splc_add_repeater_row' ); ?>"><?php _e( 'Add entry', 'splc' ); ?></div>
		<?php
	}
	
	function splc_dropdown_field_cb( $args ) {
		$options = get_option( 'splc_options' );
		$array   = $args['array'];
		?>
    <select name="splc_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['splc_custom_data'] ); ?>"
			<?php echo isset( $args['required'] ) && $args['required'] ? 'required' : ''; ?>
    >
			<?php foreach ( $array as $key => $value ): ?>
        <option
          value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], $key, false ) ) : ( '' ); ?>>
					<?php echo esc_attr( $value ); ?>
        </option>
			<?php endforeach; ?>
    </select>
		<?php
	}

  function splc_checkbox_field_cb( $args ) {
    $options = get_option( 'splc_options' );
    ?>
    <input type="checkbox"
           value="true"
           name="splc_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           id="<?php echo esc_attr( $args['label_for'] ); ?>"
           data-custom="<?php echo esc_attr( $args['splc_custom_data'] ); ?> "
      <?php echo isset( $args['required'] ) && $args['required'] ? 'required' : ''; ?>
      <?php echo isset( $options[ $args['label_for'] ] ) && $options[ $args['label_for'] ] ? 'checked' : ''; ?>

    />
    <label for="<?php echo esc_attr( $args['label_for'] ); ?>"><?php echo esc_attr( $args['label'] ); ?></label>
    <?php
  }
	
	function splc_text_field_cb( $args ) {
		$options = get_option( 'splc_options' );
		?>
    <input type="text"
           value="<?php echo isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : ''; ?>"
           name="splc_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           id="<?php echo esc_attr( $args['label_for'] ); ?>"
           placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
           data-custom="<?php echo esc_attr( $args['splc_custom_data'] ); ?> "
			<?php echo isset( $args['required'] ) && $args['required'] ? 'required' : ''; ?>/>
		<?php
	}
	
	function splc_options_page() {
		add_menu_page( 'Post Label Center Export', __( 'PLC Options', 'splc' ), 'manage_options', 'splc', 'splc_options_page_html', plugin_dir_url( __FILE__ ) . '../assets/images/splc_post_logo.svg' );
	}
	
	add_action( 'admin_menu', 'splc_options_page' );
	
	function splc_options_page_html() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'splc_messages', 'splc_message', __( 'Settings saved', 'splc' ), 'updated' );
		}
		settings_errors( 'splc_messages' );
		?>
    <div class="c-plc">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
				<?php
					settings_fields( 'splc' );
					do_settings_sections( 'splc' );
					submit_button( __( 'Save Settings', 'splc' ) );
				?>
      </form>
    </div>
		<?php
	}
	
	
