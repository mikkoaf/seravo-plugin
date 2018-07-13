<?php
/*
 * Plugin name: Maintenance
 * Description: Collection of tools for basic admin tasks
 */

namespace Seravo;

// Deny direct access to this file
if ( ! defined('ABSPATH') ) {
  die('Access denied!');
}

//require_once dirname( __FILE__ ) . '/../lib/maintenance-ajax.php';

if ( ! class_exists('maintenance') ) {
  class Maintenance {

    public static function load() {
      add_action( 'admin_menu', array( __CLASS__, 'register_maintenance_page' ) );
    }


    public static function register_maintenance_page() {
      add_submenu_page( 
        'tools.php',
        __('Maintenance', 'seravo'),
        __('Maintenance', 'seravo'),
        'manage_options',
        'maintenance_page',
        array( __CLASS__, 'load_maintenance_page' )
      );
    }

    public static function load_maintenance_page() {
      require_once dirname( __FILE__ ) . '/../lib/maintenance-page.php';
    }
  }
  Maintenance::load();
}