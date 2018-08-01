<?php
/*
 * Plugin name: Instance Switcher
 * Description: Enable users to switch to any shadow they have available
 */

namespace Seravo;

use Seravo\Helpers;
// Deny direct access to this file
if ( ! defined('ABSPATH') ) {
  die('Access denied!');
}

if ( ! class_exists('InstanceSwitcher') ) {
  class InstanceSwitcher {

    public static function load() {

      // display a notice at the bottom of the window when in a shadow
      if ( getenv('WP_ENV') && getenv('WP_ENV') !== 'production' ) {
        add_action('admin_footer', array( 'Seravo\InstanceSwitcher', 'render_shadow_indicator' ) );
        add_action('wp_footer', array( 'Seravo\InstanceSwitcher', 'render_shadow_indicator' ) );
        add_action('login_footer', array( 'Seravo\InstanceSwitcher', 'render_shadow_indicator' ) );
        add_action('admin_notices', array( 'Seravo\InstanceSwitcher', 'render_shadow_admin_notice' ) );
      }

      // Check permission
      if ( ! current_user_can( self::custom_capability() ) ) {
        return;
      }

      // admin ajax action
      add_action( 'wp_ajax_instance_switcher_change_container', array( 'Seravo\InstanceSwitcher', 'change_wp_container' ) );
      add_action( 'wp_ajax_nopriv_instance_switcher_change_container', array( 'Seravo\InstanceSwitcher', 'change_wp_container' ) );

      // styles and scripts for the switcher
      add_action( 'admin_enqueue_scripts', array( 'Seravo\InstanceSwitcher', 'assets' ), 999);
      add_action( 'wp_enqueue_scripts', array( 'Seravo\InstanceSwitcher', 'assets' ), 999);

      // add the instance switcher menu
      add_action( 'admin_bar_menu', array( 'Seravo\InstanceSwitcher', 'add_switcher' ), 999 );

    }

    /**
    * Make capability filterable
    */
    public static function custom_capability() {
      return apply_filters( 'seravo_instance_switcher_capability', 'edit_posts' );
    }

    /**
    * Load JavaScript and stylesheets for the switcher only if WP Admin bar visible
    */
    public static function assets() {
      if ( function_exists('is_admin_bar_showing') && is_admin_bar_showing() ) {
        wp_enqueue_script( 'seravo', plugins_url( '../js/instance-switcher.js', __FILE__), 'jquery', Helpers::seravo_plugin_version(), false );
        wp_enqueue_style( 'seravo', plugins_url( '../style/instance-switcher.css', __FILE__), null, Helpers::seravo_plugin_version(), 'all' );
      }
    }

    /**
    * Automatically load list of shadow instances from Searvo API (if available)
    */
    public static function load_shadow_list() {

      if ( getenv('WP_ENV') !== 'production' ) {
        return false;
      }
      $shadow_list = get_transient( 'shadow_list' );
      if ( ( $shadow_list ) === false ) {
        $api_query = '/shadows';
        $shadow_list = API::get_site_data($api_query);
        if ( is_wp_error($shadow_list) ) {
          return false; // Exit with empty result and let later flow handle it
          // Don't break page load here or everything would be broken.
        }
        set_transient( 'shadow_list', $shadow_list, 10 * MINUTE_IN_SECONDS );
      }

      return $shadow_list;
    }

    /**
    * Create the menu itself
    */
    public static function add_switcher( $wp_admin_bar ) {

      // Bail out if there is no WP Admin bar
      if ( ! function_exists( 'is_admin_bar_showing' ) || ! is_admin_bar_showing() ) {
        return;
      }

      $id = 'instance-switcher';
      $menuclass = '';

      if ( getenv('WP_ENV') && getenv('WP_ENV') !== 'production' ) {
        $menuclass = 'instance-switcher-warning';
      }

      $current_title = strtoupper(getenv('WP_ENV'));
      $current_url = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
      if ( strpos($current_url, '?') > -1 ) {
        $current_url .= '&';
      } else {
        $current_url .= '?';
      }

      // create the parent menu here
      $wp_admin_bar->add_menu([
        'id'    => $id,
        'title' => __('Now in', 'seravo') . ': ' . $current_title,
        'href'  => ! empty($_COOKIE['wpp_shadow']) ? $current_url . 'wpp_shadow=' . $_COOKIE['wpp_shadow'] : '#',
        'meta'  => [
          'class' => $menuclass,
		],
      ]);

      $instances = self::load_shadow_list();

      if ( $instances ) {
        // add menu entries for each shadow
        foreach ( $instances as $key => $instance ) {
          $title = strtoupper($instance['env']);

          if ( strlen( $instance['info'] ) > 0 ) {
            $title .= ' (' . $instance['info'] . ')';
          }

          $wp_admin_bar->add_menu([
            'parent' => $id,
            'title'  => $title,
            'id'     => $instance['name'],
            'href'   => '#' . substr($instance['name'], -6),
          ]);
        }
      }

      // If in a shadow, always show exit link
      if ( getenv('WP_ENV') && getenv('WP_ENV') !== 'production' ) {
        $wp_admin_bar->add_menu(array(
          'parent' => $id,
          'title'  => __('Exit Shadow', 'seravo'),
          'id'     => 'exit-shadow',
          'href'   => '#exit',
        ));
      }

      // Last item is always docs link
      $wp_admin_bar->add_menu(array(
        'parent' => $id,
        'title'  => __('Shadows explained at Seravo.com/docs', 'seravo'),
        'id'     => 'shadow-info',
        'href'   => 'https://seravo.com/docs/deployment/shadows/',
      ));

    }

    /**
    * Front facing big fat red banner
    */
    public static function render_shadow_indicator() {
      $shadow_title = strtoupper(getenv('WP_ENV'));
      if ( getenv('WP_ENV_COMMENT') && ! empty( getenv('WP_ENV_COMMENT') ) ) {
        $shadow_title = $shadow_title . ' (' . getenv('WP_ENV_COMMENT') . ')';
      }
      ?>
      <style>#shadow-indicator { font-family: Arial, sans-serif; position: fixed; bottom: 0; left: 0; right: 0; width: 100%; color: #fff; background: #cc0000; z-index: 3000; font-size:16px; line-height: 1; text-align: center; padding: 5px } #shadow-indicator a.clearlink { text-decoration: underline; color: #fff; }</style>
      <div id="shadow-indicator">
      <?php
        // translators: $s Identifier for the shadow instance in use
        echo wp_sprintf( __('Your current shadow instance is %s.', 'seravo'), $shadow_title );
      ?>
      <a class="clearlink" href="/?wpp_shadow=clear&seravo_shadow=clear"><?php _e('Exit', 'seravo'); ?></a>
      </div>
      <?php
    }

    /**
    * Let plugins or themes display admin notice when inside a shadow
    */
    public static function render_shadow_admin_notice( $current_screen ) {
      $current_screen = get_current_screen();
      $admin_notice_content = apply_filters( 'seravo_instance_switcher_admin_notice', '', $current_screen );
      if ( ! empty($admin_notice_content) ) {
        echo $admin_notice_content;
      }
    }
  }

  InstanceSwitcher::load();
}
