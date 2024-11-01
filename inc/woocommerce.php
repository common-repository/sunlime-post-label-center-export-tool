<?php

if ( splc_check_required_fields() ) {
  //Filter
  add_filter( 'wc_order_statuses', 'splc_add_order_status' );
  add_filter( 'bulk_actions-edit-shop_order', 'splc_register_bulk_action' );

  //Actions
  add_action( 'admin_action_mark_splc', 'splc_process_bulk_action' );
  add_action( 'woocommerce_order_status_splc', 'splc_send_order_to_plc' );
  add_action( 'add_meta_boxes', 'splc_add_meta_box' );
  add_action( 'init', 'splc_register_order_status' );
} else {
  add_action( 'admin_notices', function() {
    ?>
    <div class="error">
      <p>
        <strong>
          <?php echo sprintf( __( 'Please set all required fields on the %s', 'splc' ), '<a href="' . menu_page_url( 'splc', false ) . '">' . __( 'PLC Options Page', 'splc' ) . '</a>' ); ?>
        </strong>
      </p>
    </div>
    <?php
  } );
}

function splc_register_order_status() {
  register_post_status( 'wc-splc', array(
    'label'                     => 'PLC',
    'public'                    => true,
    'exclude_from_search'       => false,
    'show_in_admin_all_list'    => true,
    'show_in_admin_status_list' => true,
    'label_count'               => _n_noop( 'PLC (%s)', 'PLC (%s)', 'splc' )
  ) );
}

function splc_add_order_status( $order_statuses ) {
  $new_order_statuses = array();
  foreach ( $order_statuses as $key => $status ) {
    $new_order_statuses[ $key ] = $status;
    if ( 'wc-processing' === $key ) {
      $new_order_statuses['wc-splc'] = __( 'PLC', 'splc' );
    }
  }

  return $new_order_statuses;
}

function splc_register_bulk_action( $bulk_actions ) {
  $bulk_actions['mark_splc'] = __( 'Change to status PLC', 'splc' );

  return $bulk_actions;
}

function splc_process_bulk_action() {
  if ( ! isset( $_REQUEST['post'] ) && ! is_array( $_REQUEST['post'] ) ) {
    return;
  }
  $suffix = get_option( 'woocommerce_gzdp_invoice_path_suffix', false );
  foreach ( $_REQUEST['post'] as $order_id ) {
    $order      = new WC_Order( $order_id );
    $order_note = __( 'The order was changed thorugh bulk edit.', 'splc' );
    $order->update_status( 'splc', $order_note, true );
  }
  $location = add_query_arg( array(
    'post_type'   => 'shop_order',
    'marked_plc'  => 1,
    'changed'     => count( $_REQUEST['post'] ),
    'ids'         => esc_html(join( ',', $_REQUEST['post'] )),
    'post_status' => 'all'
  ), 'edit.php' );
  wp_redirect( admin_url( $location ) );
  exit;
}

function splc_add_meta_box() {
  add_meta_box( 'splc_meta_box', __( 'PLC Infos' ), 'splc_meta_box_content', 'shop_order', 'side', 'high' );
}

function splc_meta_box_content() {
  $order_id      = get_the_ID();
  $shipping_data = get_post_meta( $order_id, '_splc_shipping_data', true );
  if( is_array($shipping_data) && count($shipping_data) > 0 ){
    foreach($shipping_data as $single_shipping_data) {
      if ( isset( $single_shipping_data->ColloRow->ColloCodeList->ColloCodeRow ) ) {
        $code_row = $single_shipping_data->ColloRow->ColloCodeList->ColloCodeRow;
        if ( is_array( $code_row ) && count( $code_row ) > 0 ) {
          foreach ( $code_row as $code ) {
            echo '<div class="c-code">' . $code->Code . '</div>';
          }
        } else {
          echo '<div class="c-code">' . $code_row->Code . '</div>';
        }
      } else {
        _e( 'Order has not yet been sent to PLC', 'splc' );
      }
    }
  } else {
    if ( isset( $shipping_data->ColloRow->ColloCodeList->ColloCodeRow ) ) {
      $code_row = $shipping_data->ColloRow->ColloCodeList->ColloCodeRow;
      if ( is_array( $code_row ) && count( $code_row ) > 0 ) {
        foreach ( $code_row as $code ) {
          echo '<div class="c-code">' . $code->Code . '</div>';
        }
      } else {
        echo '<div class="c-code">' . $code_row->Code . '</div>';
      }
    } else {
      _e( 'Order has not yet been sent to PLC', 'splc' );
    }
  }
}

function splc_create_custom_shipping_fields() {
  $packet = array(
    'id'          => 'splc_packet',
    'label'       => __( 'Packet', 'splc' ),
    'desc_tip'    => true,
    'description' => __( 'Choose a packet for that product. If no packet is chosen, the standard packet on the settings page is taken.', 'splc' ),
    'options'     => splc_get_packets()
  );
  woocommerce_wp_select( $packet );

  $customs_number = array(
    'id'          => 'splc_customs_number',
    'label'       => __( 'Customs Number', 'splc' ),
    'desc_tip'    => true,
    'description' => __( 'Enter the customs number for that product. If no number is added the standard number on the settings page is taken.', 'splc' ),
  );
  woocommerce_wp_text_input( $customs_number );

  $unit = array(
    'id'          => 'splc_unit',
    'label'       => __( 'Unit', 'splc' ),
    'desc_tip'    => true,
    'description' => __( 'Choose the unit for that product. If no unit is selected the standard unit on the settings page is taken.', 'splc' ),
    'options'     => splc_get_units()
  );
  woocommerce_wp_select( $unit );

  $customs_option = array(
    'id'          => 'splc_customs_option',
    'label'       => __( 'Customs Option', 'splc' ),
    'desc_tip'    => true,
    'description' => __( 'Choose the customs option for that product. If no customs option is selected the standard customs option on the settings page is taken.', 'splc' ),
    'options'     => splc_get_customs_options()
  );
  woocommerce_wp_select( $customs_option );

  $country = array(
    'id'          => 'splc_origin_country',
    'label'       => __( 'Country of Origin', 'splc' ),
    'desc_tip'    => true,
    'description' => __( 'Choose the country of origin for that product. If no country of origin is selected the standard country of origin on the settings page is taken.', 'splc' ),
    'options'     => splc_get_woocommerce_countries()
  );
  woocommerce_wp_select( $country );


}

add_action( 'woocommerce_product_options_shipping', 'splc_create_custom_shipping_fields' );

function splc_save_custom_shipping_fields( $post_id ) {
  $product        = wc_get_product( $post_id );
  $packet         = isset( $_POST['splc_packet'] ) ? sanitize_text_field( $_POST['splc_packet']  ) : '';
  $customs_number = isset( $_POST['splc_customs_number'] ) ? sanitize_text_field( $_POST['splc_customs_number']  ) : '';
  $unit           = isset( $_POST['splc_unit'] ) ? sanitize_text_field(  $_POST['splc_unit']  ) : '';
  $country        = isset( $_POST['splc_origin_country'] ) ? sanitize_text_field(  $_POST['splc_origin_country']  ) : '';
  $customs_option = isset( $_POST['splc_customs_option'] ) ? sanitize_text_field(  $_POST['splc_customs_option']  ) : '';
  $product->update_meta_data( 'splc_packet', $packet );
  $product->update_meta_data( 'splc_customs_number', $customs_number );
  $product->update_meta_data( 'splc_unit',  $unit  );
  $product->update_meta_data( 'splc_origin_country', $country  );
  $product->update_meta_data( 'splc_customs_option', $customs_option  );
  $product->save();
}

add_action( 'woocommerce_process_product_meta', 'splc_save_custom_shipping_fields' );