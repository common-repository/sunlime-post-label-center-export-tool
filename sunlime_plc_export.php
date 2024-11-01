<?php
/**
 * Plugin Name: SUNLIME Post Label Center Export Tool
 * Plugin URI:
 * Description: This plugin enables the export of WooCommerce orders to an existing Post Label Center.
 * Version: 1.1.6
 * Author: Sunlime Web Innovations GmbH
 * Author URI: https://sunlime.at
 * Domain Path: /languages
 * Text Domain: splc
 */

if( !is_admin() ) {
  return;
}
if( !class_exists( 'splc_Export' ) ) {
  class Sunlime_splc_Export {

    public function __construct() {
      add_action( 'plugins_loaded', array( $this, 'splc_on_plugins_loaded' ) );
      add_action( 'plugins_loaded', array( $this, 'splc_check_for_soap' ) );
    }

    public function splc_on_plugins_loaded() {

      if( !class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', function() {
          ?>
          <div class="error">
            <p>
              <strong>
                <?php _e( 'Please install and activate WooCommerce to use the PLC export tool', 'splc' ); ?>
              </strong>
            </p>
          </div>
          <?php
        } );
        return;
      }
      $this->splc_load_textdomain();
      $this->splc_load_dependencies();
      add_action( 'admin_enqueue_scripts', array( $this, 'splc_load_scripts' ) );
    }

    public function splc_check_for_soap() {
      if( !class_exists( "SOAPClient" ) ) {
        add_action( 'admin_notices', function() {
          ?>
          <div class="error">
            <p>
              <strong>
                <?php _e( 'It seems, that your server has no SOAPClient class, please contact your server provider/administrator', 'splc' ); ?>
              </strong>
            </p>
          </div>
          <?php
        } );
      }
    }

    public function splc_load_dependencies() {
      require_once( plugin_basename( 'classes/SPLCAddressRow.php' ) );
      require_once( plugin_basename( 'classes/SPLCColloRow.php' ) );
      require_once( plugin_basename( 'classes/SPLCColloArticleRow.php' ) );
      require_once( plugin_basename( 'inc/import-shipment.php' ) );
      require_once( plugin_basename( 'inc/ajax-handler.php' ) );
      require_once( plugin_basename( 'inc/core-functions.php' ) );
      require_once( plugin_basename( 'inc/settings-page.php' ) );
      require_once( plugin_basename( 'inc/woocommerce.php' ) );
    }

    public function splc_load_textdomain() {
      load_plugin_textdomain( 'splc', false, basename( dirname( __FILE__ ) ) . '/languages/' );
    }

    public function splc_load_scripts() {
      wp_enqueue_style( 'splc_admin_styles', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', array() );
      wp_enqueue_script( 'splc_admin_script', plugin_dir_url( __FILE__ ) . 'assets/js/plc.js', array( 'jquery' ) );
      wp_localize_script( 'splc_admin_script', 'plcAjaxVars', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ), ) );
    }
  }

  new Sunlime_splc_Export();
}

	

 