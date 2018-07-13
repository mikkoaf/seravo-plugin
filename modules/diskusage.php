<?php
/*
 * Plugin name: disk-usage
 * Description: Collection of tools for basic admin tasks
 */

namespace Seravo;

// Deny direct access to this file
if ( ! defined('ABSPATH') ) {
  die('Access denied!');
}

//require_once dirname( __FILE__ ) . '/../lib/disk-usage-ajax.php';

if ( ! class_exists('diskusage') ) {
  class Diskusage {

    public static function load() {
      add_action( 'admin_menu', array( __CLASS__, 'register_diskusage_page' ) );
    }


    public static function register_diskusage_page() {
      add_submenu_page( 
        'tools.php',
        __('Disk Usage', 'seravo'),
        __('Disk Usage', 'seravo'),
        'manage_options',
        'disk-usage_page',
        array( __CLASS__, 'load_diskusage_page' )
      );
    }

    public static function load_diskusage_page() {
      require_once dirname( __FILE__ ) . '/../lib/diskusage-page.php';
    }
  }
  Diskusage::load();
}