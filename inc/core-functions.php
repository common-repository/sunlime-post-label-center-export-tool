<?php
	
	function splc_get_units(): array {
		return array(
			''    => '---',
			'BE'  => __( 'Bunch', 'splc' ),
			'BL'  => __( 'Bale, compacted', 'splc' ),
			'BN'  => __( 'Bale, compressed', 'splc' ),
			'BO'  => __( 'Cylindrical bottle', 'splc' ),
			'BR'  => __( 'Beam', 'splc' ),
			'BX'  => __( 'Box', 'splc' ),
			'DMT' => __( 'Decimeter', 'splc' ),
			'FTQ' => __( 'Squaare foot', 'splc' ),
			'GRM' => __( 'Gram', 'splc' ),
			'KGM' => __( 'Kilogram', 'splc' ),
			'KTM' => __( 'Kilometer', 'splc' ),
			'MTQ' => __( 'Cubic meter', 'splc' ),
			'MTR' => __( 'Meter', 'splc' ),
			'PCE' => __( 'Piece', 'splc' ),
			'SA'  => __( 'Bag', 'splc' ),
		);
	}
	
	function splc_get_customs_options(): array {
		return array(
			'' => '---',
			1  => __( 'Sale of goods', 'splc' ),
			2  => __( 'Gift', 'splc' ),
			3  => __( 'Documents', 'splc' ),
			4  => __( 'Samples', 'splc' ),
			5  => __( 'Returns', 'splc' ),
			6  => __( 'Other', 'splc' ),
		);
	}
	
	function splc_get_woocommerce_countries(): array {
		$countries_obj = new WC_Countries();
		$countries     = $countries_obj->__get( 'countries' );
		return array( '' => '---' ) + $countries;
  }
	
	function splc_get_packets(): array {
		return array(
			'' => '---',
			28 => __( 'Return packet', 'splc' ),
			63 => __( 'Return packet international', 'splc' ),
			14 => __( 'Premium light', 'splc' ),
			30 => __( 'Premium Select', 'splc' ),
			12 => __( 'Small packet', 'splc' ),
			64 => __( 'Same Day', 'splc' ),
			65 => __( 'Next Day', 'splc' ),
			10 => __( 'Packet Austria', 'splc' ),
			45 => __( 'Packet Premium International', 'splc' ),
			47 => __( 'Combi-freight Austria', 'splc' ),
			49 => __( 'Combi-freight International', 'splc' ),
			31 => __( 'Packet Premium Austria B2B', 'splc' ),
			01 => __( 'EMS Austria', 'splc' ),
			46 => __( 'EMS International', 'splc' ),
			78 => __( 'Packet size M with shipment tracking', 'splc' ),
			70 => __( 'Packet Plus Int. Outbound', 'splc' ),
			69 => __( 'Packet Light Int. non boxable Outbound', 'splc' ),
			66 => __( 'Return packet international standard', 'splc' )
		);
	}
	
	function splc_get_packets_row( $name, $selected_country_key = '', $selected_packet_key = '' ) {
		$countries = splc_get_woocommerce_countries();
		$packets   = splc_get_packets();
		?>
    <div class="c-splc__row">
      <select name="splc_options[<?php echo esc_attr( $name ); ?>_country][]">
				<?php foreach ( $countries as $key => $value ): ?>
					<?php if ( $key === '' ) {
						$value = __( 'Any country', 'splc' );
					} ?>
          <option
            value="<?php echo esc_attr( $key ); ?>"
						<?php echo $selected_country_key ? ( selected( $selected_country_key, $key, false ) ) : ( '' ); ?>>
						<?php echo esc_attr( $value ); ?>
          </option>
				<?php endforeach; ?>
      </select>
      <select name="splc_options[<?php echo esc_attr( $name ); ?>_packet][]">
				<?php foreach ( $packets as $key => $value ): ?>
          <option
            value="<?php echo esc_attr( $key ); ?>"
						<?php echo $selected_packet_key ? ( selected( $selected_packet_key, $key, false ) ) : ( '' ); ?>>
						<?php echo esc_attr( $value ); ?>
          </option>
				<?php endforeach; ?>
      </select>
      <div class="o-button js-splc__remove-entry"><?php _e( 'Remove entry', 'splc' ); ?></div>
    </div>
		<?php
	}
	
	function splc_add_packet_rows( $args, $options = null ) {
		$name = $args['label_for'];
		if ( $options && isset( $options[ $name . '_country' ] ) && isset( $options[ $name . '_packet' ] ) && count( $options[ $name . '_country' ] ) > 0 && count( $options[ $name . '_packet' ] ) > 0 && count( $options[ $name . '_country' ] ) === count( $options[ $name . '_packet' ] ) ) {
			foreach ( $options[ $name . '_country' ] as $idx => $key ) {
				$country_key = $key;
				$packet_key  = $options[ $name . '_packet' ][ $idx ];
				splc_get_packets_row( $name, $country_key, $packet_key );
			}
		}
	}
	
	function splc_check_required_fields(): bool {
		$options    = get_option( 'splc_options' );
		$req_fields = array(
			'splc_field_name',
			'splc_field_street',
			'splc_field_housenumber',
			'splc_field_postcode',
			'splc_field_city',
			'splc_field_country',
			'splc_field_soap_url',
			'splc_field_client_id',
			'splc_field_org_unit_id',
			'splc_field_org_unit_guid',
		);
		
		if(is_array($options)):
			foreach ( $req_fields as $req_field ):
				if ( ! array_key_exists( $req_field, $options ) || empty( $options[ $req_field ] ) ) {
					return false;
				}
			endforeach;
		else:
			return false;
		endif;
		
		return true;
	}