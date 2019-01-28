<?php
/**
 * Plugin name: Seravo Check PHP version
 * Description: Checks that the PHP version is supported. If the version is lower than recommended,
 * it displays a warning on the dashboard.
 */

namespace Seravo;

// Deny direct access to this file
if ( ! defined('ABSPATH') ) {

  die('Access denied!');

}

if ( ! class_exists('CheckPHPVersion') ) {

  class CheckPHPVersion {

    // Get the php version and check if it is supported, if not, show a warning

    const RECOMMENDED_VERSION = '7.2';

    public static function load() {

      add_action('admin_notices', array( __CLASS__, '_seravo_check_php_version' ));

    }

    public static function _seravo_check_php_version() {

      if ( version_compare( PHP_VERSION, self::RECOMMENDED_VERSION, '<' ) ) {
        Seravo_Notification::give_notification(array('error'),
                                            array( __CLASS__, '_seravo_show_php_warning')
                                          );
      }

    }

    public static function _seravo_show_php_warning( ) {

          // The line below is very long, but PHPCS standards requires translation
          // strings to be one one line
          printf(
            // translators: %1$s: current php version, %2$s: recommended php version
            __('The PHP version %1$s currently in use is lower than the recommended %2$s. Security updates might not be available for the version in use. Please consider <a target="_blank" href="https://help.seravo.com/en/knowledgebase/13/docs/107-set-your-site-to-use-newest-php-version">updating the PHP version</a>.', 'seravo'),
            PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION, self::RECOMMENDED_VERSION
          );
    }

  }

  CheckPHPVersion::load();

}
