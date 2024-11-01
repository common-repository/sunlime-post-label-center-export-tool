<?php
	
	function splc_get_shipper_address() {
		$options        = get_option( 'splc_options' );
		$shipperAddress = new SPLCAddressRow( $options['splc_field_name'], $options['splc_field_street'], $options['splc_field_housenumber'],$options['splc_field_postcode'], $options['splc_field_country'], $options['splc_field_city'], $options['splc_field_phone'] );
		
		return $shipperAddress;
	}
	
	function splc_get_recipient_address( $order_id ) {
		$order            = wc_get_order( $order_id );
		$recipientAddress = new SPLCAddressRow( $order->get_shipping_company() ? $order->get_shipping_company() : $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name(), $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2(),'', $order->get_shipping_postcode(), $order->get_shipping_country(), $order->get_shipping_city(), $order->get_billing_phone(), $order->get_billing_email(), $order->get_shipping_company() ? $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name() : '' );
		
		return $recipientAddress;
	}
	
	function splc_get_article_lists( $order_id ) {
		$order            = wc_get_order( $order_id );
		$line_items       = $order->get_items();
		$countryID        = $order->get_shipping_country();
		$currency         = $order->get_currency();
		$options          = get_option( 'splc_options' );
		$all_customs_options_set = true;
		$required_customs_options = array('splc_field_standard_customs_option', 'splc_field_standard_unit', 'splc_field_standard_customs_number', 'splc_field_standard_country_of_origin');
		foreach($required_customs_options as $required_customs_option) {
			if(!isset($options[$required_customs_option]) || !$options[$required_customs_option]){
				$all_customs_options_set = false;
			}
		}
		$colloArticleLists = array();
		$post_products = splc_get_post_products();
		$deliveryServiceThirdPartyID = array_key_exists( $countryID, $post_products ) ? $post_products[ $countryID ] : $post_products['default'];
		
		foreach ( $line_items as $line_item ):
			$parent_prod           = wc_get_product( $line_item->get_product_id() );
			$product               = $line_item->get_product();
			$articleName           = $line_item->get_name();
			$quantity              = $line_item->get_quantity();
			$packet                = $parent_prod->get_meta( 'splc_packet' ) ? $parent_prod->get_meta( 'splc_packet' ) : $deliveryServiceThirdPartyID;
			
			if($all_customs_options_set):
				$customsOptionId       = $parent_prod->get_meta( 'splc_customs_option' ) ? $parent_prod->get_meta( 'splc_customs_option' ) : $options['splc_field_standard_customs_option'];
				$unitId                = $parent_prod->get_meta( 'splc_unit' ) ? $parent_prod->get_meta( 'splc_unit' ) : $options['splc_field_standard_unit'];
				$hsTariffNumber        = $parent_prod->get_meta( 'splc_customs_number' ) ? $parent_prod->get_meta( 'splc_customs_number' ) : $options['splc_field_standard_customs_number'];
				$countryOfOriginId     = $parent_prod->get_meta( 'splc_origin_country' ) ? $parent_prod->get_meta( 'splc_origin_country' ) : $options['splc_field_standard_country_of_origin'];
			endif;
			
			$articleNumber         = $product->get_sku();
			$consumerUnitNetWeight = $product->get_weight() ? $product->get_weight() : 0;
			$valueOfGoodsPerUnit   = $product->get_price();
			if ( ! $product->is_virtual() ) {
				$colloArticleRow    = new SPLCColloArticleRow( $articleNumber, $articleName, $quantity, $unitId, $hsTariffNumber, $countryOfOriginId, $valueOfGoodsPerUnit, $currency, $consumerUnitNetWeight, $customsOptionId );
				if(!array_key_exists($packet, $colloArticleLists)){
					$colloArticleLists[$packet] = array();
				}
				$colloArticleLists[$packet][] = $colloArticleRow;
			}
		endforeach;
		
		return $colloArticleLists;
	}
	
	function splc_get_post_products(){
		$options       = get_option( 'splc_options' );
		$post_products = array( 'default' => '45', );
		if ( isset( $options['splc_field_standard_packets_country'] ) && isset( $options['splc_field_standard_packets_packet'] ) && is_array( $options['splc_field_standard_packets_country'] ) && is_array( $options['splc_field_standard_packets_packet'] ) && count( $options['splc_field_standard_packets_country'] ) === count( $options['splc_field_standard_packets_packet'] ) ) {
			foreach ( $options['splc_field_standard_packets_country'] as $idx => $country ) {
				if ( $country === '' ) {
					$country = 'default';
				}
				$post_products[ $country ] = $options['splc_field_standard_packets_packet'][ $idx ];
			}
		}
		return $post_products;
	}
	
	function splc_send_order_to_plc( $order_id ) {
		$order         = wc_get_order( $order_id );
		$already_sent  = get_post_meta( $order_id, '_sent_to_plc', true );
		$options       = get_option( 'splc_options' );
		$soap_url         = trim($options['splc_field_soap_url']);
		$clientID         = trim($options['splc_field_client_id']);
		$orgUnitGuid      = trim($options['splc_field_org_unit_guid']);
		$orgUnitID        = trim($options['splc_field_org_unit_id']);
		$countryID        = $order->get_shipping_country();
    $setToCompleted = isset($options['splc_field_automatic_complete_order']) && $options['splc_field_automatic_complete_order'];
    $success = true;
		$colloArticleLists = splc_get_article_lists( $order_id );
		$importShipmentResults = [];
		foreach( $colloArticleLists as $deliveryServiceThirdPartyID => $colloArticleList ) {
			$colloRow         = new SPLCColloRow( $colloArticleList );
			$colloList        = array();
			$colloList[]      = $colloRow;
			$shipperAddress   = splc_get_shipper_address();
			$recipientAddress = splc_get_recipient_address( $order_id );
			if ( ! $already_sent ) {
				$client = new SoapClient( $soap_url, array(
					'soap_version' => 'SOAP_1_1',
					'trace' => 1,
					'stream_context' => stream_context_create(array(
						                                          'ssl' => array(
							                                          'crypto_method' =>  STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
						                                          )
					                                          )
					)
				));
				$data   = array(
					'row' => array(
						'ClientID'                    => $clientID,
						'OrgUnitGuid'                 => $orgUnitGuid,
						'OrgUnitID'                   => $orgUnitID,
						'DeliveryServiceThirdPartyID' => $deliveryServiceThirdPartyID,
						'OURecipientAddress'          => $recipientAddress,
						'OUShipperAddress'            => $shipperAddress,
						'ColloList'                   => $colloList
					)
				);
				
				$response = $client->ImportShipment( $data );
				if ( $response->errorCode ) {
					$order->add_order_note( $response->errorCode );
          $success = false;
				}
				
				if ( $response->ImportShipmentResult ) {
					$importShipmentResults[] = $response->ImportShipmentResult;
				}
			}
		}
		update_post_meta( $order_id, '_splc_shipping_data', $importShipmentResults );
    if($success && $setToCompleted) {
      $order->update_status('completed', __('Order was completed through PLC plugin', 'splc'));
    }
	}