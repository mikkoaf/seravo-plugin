<?php
/*
 * Plugin name: Passwords
 * Description: Enforce strong passwords
 * Version: 1.0
 */

namespace Seravo;

use Seravo\Helpers;
// Deny direct access to this file
if ( ! defined('ABSPATH') ) {
  die('Access denied!');
}

if ( ! class_exists('Passwords') ) {
  class Passwords {

    /**
     * Load passwords features
     */
    public static function load() {

      add_action('login_enqueue_scripts', array( __CLASS__, 'register_scripts' ));
      add_action('admin_enqueue_scripts', array( __CLASS__, 'register_scripts' ));

    }

    /**
     * Register scripts
     *
     * @param string $page hook name
     */
    public static function register_scripts( $page ) {

      wp_register_style('seravo_passwords', plugin_dir_url(__DIR__) . '/style/passwords.css', '', Helpers::seravo_plugin_version());
      wp_register_script(
        'seravo_passwords', plugin_dir_url( __DIR__ ) . '/js/passwords.js',
        array( 'jquery' ),
        Helpers::seravo_plugin_version(), // version string
        true // in footer
      );

      if ( $page === 'profile.php' || $page === 'user-new.php' ) {
        wp_enqueue_style('seravo_passwords');
      } elseif ( $GLOBALS['pagenow'] === 'wp-login.php' ) {
        wp_enqueue_script('seravo_passwords');
      }

    }

  }

  Passwords::load();
}
