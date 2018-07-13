<?php
// Deny direct access to this file
if ( ! defined('ABSPATH') ) {
  die('Access denied!');
}
?>



  <div id="wpbody" role="main">
    <div id="wpbody-content" aria-label="Main content" tabindex="0">
      <div class="wrap">
        <div id="dashboard-widgets" class="metabox-holder">
        <!-- first -->
        <div id="dashboard_right_now" class="postbox">
              <button type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel: <?php _e('Backups', 'seravo'); ?></span>
                <span class="toggle-indicator" aria-hidden="true"></span>
              </button>
              <h2 class="hndle ui-sortable-handle">
                <span><?php _e('Backups', 'seravo'); ?></span>
              </h2>
              <div class="inside">
                <p><?php _e('Backups are made automatically every night and preserved for 30 days. The data can be accessed on the server at <code>/data/backups</code>.', 'seravo'); ?></p>
              </div>
          </div>
          <!-- first ends -->

          <!-- second -->
          <div id="dashboard_activity" class="postbox">
            <button type="button" class="handlediv button-link" aria-expanded="true">
              <span class="screen-reader-text">Toggle panel: <?php _e('Create a new backup', 'seravo'); ?></span>
              <span class="toggle-indicator" aria-hidden="true"></span>
            </button>
            <h2 class="hndle ui-sortable-handle">
              <span><?php _e('Create a new backup', 'seravo'); ?></span>
            </h2>
            <div class="inside">
              <p><?php _e('You can also create backups using the command line tool <code>wp-backup</code>. We recommend getting familiar with the command line option accessible via SSH so that recovering a backup is not dependant on if WP-admin works or not.', 'seravo'); ?></p>
              <p class="create_backup">
                <button id="create_backup_button" class="button"><?php _e('Make a new backup', 'seravo'); ?> </button>
                <div id="create_backup_loading"><img class="hidden" src="/wp-admin/images/spinner.gif"></div>
                <pre><div id="create_backup"></div></pre>
              </p>
            </div>
          </div>
          <!-- second ends -->

          <!-- third -->
          <div id="dashboard_quick_press" class="postbox">
            <button type="button" class="handlediv button-link" aria-expanded="true">
              <span class="screen-reader-text">Toggle panel: <?php _e('Files excluded from backups', 'seravo'); ?></span>
              <span class="toggle-indicator" aria-hidden="true"></span>
            </button>
            <h2 class="hndle ui-sortable-handle">
              <span><?php _e('Files excluded from backups', 'seravo'); ?></span>
            </h2>
            <div class="inside">
              <?php
                // translators: %s name of the file shown
                echo wp_sprintf( __('Below is the content of the file %s.', 'seravo'), '<code>/data/backups/exclude.filelist</code>' );
              ?>
              <p>
                <div id="backup_exclude_loading">
                  <img src="/wp-admin/images/spinner.gif">
                </div>
                <pre id="backup_exclude"></pre>
              </p>
            </div>
          </div>
          <!-- third ends -->
        </div>
      </div>

      <div class="postbox-container">
        <div id="side-sortables" class="meta-box-sortables ui-sortable">
          <!-- fourth -->
          <div id="dashboard_primary" class="postbox">
              <button type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel: <?php _e( 'Current backups', 'seravo' ); ?></span>
                <span class="toggle-indicator" aria-hidden="true"></span>
              </button>
              <h2 class="hndle ui-sortable-handle">
                <span><?php _e( 'Current backups', 'seravo' ); ?></span>
              </h2>
              <div class="inside">
                <?php
                  // translators: %s command used to list WordPress backups of the website
                  echo wp_sprintf( __('This listing is produced by command %s.', 'seravo'), '<code>wp-backup-status</code>' );
                ?>
                <p>
                  <div id="backup_status_loading"><img src="/wp-admin/images/spinner.gif"></div>
                  <pre id="backup_status"></pre>
                </p>
                <!-- fourth ends -->
<!--First postbox: Database access-->
<div id="dashboard_right_now" class="postbox">
              <button type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel: <?php _e('Database access', 'seravo'); ?></span>
                <span class="toggle-indicator" aria-hidden="true"></span>
              </button>
              <h2 class="hndle ui-sortable-handle">
                <span><?php _e('Database access', 'seravo'); ?></span>
              </h2>
              <div class="inside">
                <div class="seravo-section">
                  <p>
                    <?php
                      // translators: $s example of the command for getting user's database credentials
                      printf( __( 'You can find the database credentials by connecting with SSH and running command %s. These credentials can be used to connect to server with SSH tunnel. You can also use web-based Adminer below.', 'seravo' ), '<code>wp-list-env</code>' );
                    ?>
                  </p>
                  <p>
                    <?php
                      // translators: $s url containing additional information on WordPress database tools
                      printf( __( 'When you have SSH connection you can use WP-CLI that has powerful database tools for example exports and imports. <a href="%s">Read wp db docs.</a>', 'seravo' ), 'https://developer.wordpress.org/cli/commands/db/' );
                    ?>
                  </p>
                </div>
              </div>
            </div>
          <!--First postbox: end-->

          <!--Second postbox: Manage database with Adminer-->
            <div id="dashboard_activity" class="postbox">
              <button type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel: <?php _e('Manage database with Adminer', 'seravo'); ?></span>
                <span class="toggle-indicator" aria-hidden="true"></span>
              </button>
              <h2 class="hndle ui-sortable-handle">
                <span><?php _e('Manage database with Adminer', 'seravo'); ?></span>
              </h2>
              <div class="inside">
                <div class="seravo-section">
                  <p>
                    <?php
                      /* translators:
                      * %1$s url to www.adminer.org
                      */
                      printf( __( 'Adminer is a simple database management tool like phpMyAdmin. <a href="%1$s">Learn more about Adminer.</a>', 'seravo' ), 'https://www.adminer.org' );
                    ?>
                  </p>
                  <p>
                    <?php
                      /* translators:
                      * %1$s example url for accessing Adminer in production environment
                      * %2$s example url for accessing Adminer in local development
                      */
                      printf( __( 'Find Adminer in production at %1$s and in local development at %2$s.', 'seravo' ), '<code>sitename.com/.seravo/adminer</code>', '<code>adminer.sitename.local</code>' );
                    ?>
                  </p>

                  <?php

                  $adminer_url = '';

                  // TODO: test for multisite
                  $siteurl = get_site_url();


                  if ( 'production' === getenv('WP_ENV') ) {

                    // Add trailing slash if missing
                    if ( substr($siteurl, -1) !== '/' ) {
                      $siteurl .= '/';
                    }

                    $adminer_url = $siteurl . '.seravo/adminer';

                  } else {

                    // Add trailing slash if missing
                    if ( substr($siteurl, -1) !== '/' ) {
                      $siteurl .= '/';
                    }

                    // Inject subdomain
                    $adminer_url = str_replace('//', '//adminer.', $siteurl);

                  }

                  ?>

                  <p class="adminer_button"><a href="<?php echo esc_url($adminer_url); ?>" class="button" target="_blank"><?php _e( 'Open Adminer', 'seravo' ); ?><span aria-hidden="true" class="dashicons dashicons-external"></span></a></p>
                </div>
              </div>
            </div>
          <!--Second postbox: end-->
          </div>
        </div>

        <div class="postbox-container">
          <div id="side-sortables" class="meta-box-sortables ui-sortable">
            <!--Third postbox: Search-replace tool-->
            <div id="dashboard_quick_press" class="postbox">
              <button type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel: <?php _e('Search-replace tool', 'seravo'); ?></span>
                <span class="toggle-indicator" aria-hidden="true"></span>
              </button>
              <h2 class="hndle ui-sortable-handle">
                <span>
                  <span class="hide-if-no-js"><?php _e('Search-replace tool', 'seravo'); ?></span>
                </span>
              </h2>
              <div class="inside">
                <?php if ( exec( 'which wp' ) && apply_filters('seravo_search_replace', true) ) : ?>
                <div class="seravo-section">
                  <p> <?php _e('With this tool you can run wp search-replace. For your own safety, dry-run has to be ran before the actual search-replace', 'seravo'); ?></p>
                  <div class="sr-navbar">
                    <span class="label_buttons"><label class="from_label" for="sr-from"><?php _e('From:', 'seravo'); ?></label> <input type="text" id="sr-from" value=""></span>
                    <span class="label_buttons to_button"><label class="to_label" for="sr-to"><?php _e('To:', 'seravo'); ?></label> <input type="text" id="sr-to" value=""></span>
                    <!-- To add new arbitrary option put it below. Use class optionbox
                        Custom options will be overriden upon update -->
                    <ul class="optionboxes">
                        <li class="sr_option">
                          <input type="checkbox" id="skip_backup" class="optionbox">
                          <label for="skip_backup"><?php _e('Skip backups', 'seravo'); ?></label>
                        </li>
                      <?php if ( $GLOBALS['sr_alltables'] ) : ?>
                        <li class="sr_option">
                          <input type="checkbox" id="all_tables" class="optionbox">
                          <label for="all_tables"><?php _e('All tables', 'seravo'); ?></label>
                        </li>
                      <?php endif; ?>
                      <?php if ( $GLOBALS['sr_networkvisibility'] ) : ?>
                        <li class="sr_option">
                          <input type="checkbox" id="network" class="optionbox">
                          <label for="network"><?php _e('Network', 'seravo'); ?></label>
                        </li>
                      <?php endif; ?>
                    </ul>
                    <div class="datab_buttons">
                      <button id="sr-drybutton" class="button sr-button"> <?php _e('Run dry-run', 'seravo'); ?> </button>
                      <button id="sr-button" class="button sr-button" disabled> <?php _e('Run wp search-replace', 'seravo'); ?> </button>
                    </div>
                  </div>
                  <div id="search_replace_loading"><img class="hidden" src="/wp-admin/images/spinner.gif"></div>
                  <div id="search_replace_command"></div>
                  <table id="search_replace"></table>
                </div>
                <?php endif; // end search & replace ?>
              </div>
            </div>
            <!--Third postbox: end-->

            <!--Fourth postbox: Database size-->
            <div id="dashboard_primary" class="postbox">
              <button type="button" class="handlediv button-link" aria-expanded="true">
                <span class="screen-reader-text">Toggle panel: <?php _e( 'Database size', 'seravo' ); ?></span>
                <span class="toggle-indicator" aria-hidden="true"></span>
              </button>
              <h2 class="hndle ui-sortable-handle">
                <span><?php _e( 'Database size', 'seravo' ); ?></span>
              </h2>
              <div class="inside">
                <?php if ( exec( 'which wp' ) ) : ?>
                <div class="seravo-section section_chart_mobile">
                  <p>
                    <div id="seravo_wp_db_info_loading"><img src="/wp-admin/images/spinner.gif"></div>
                    <pre><div id="seravo_wp_db_info"></div></pre>
                    <div class="pie_container">
                      <canvas id="pie_chart" style="width: 10%; height: 4vh;"></canvas>
                    </div>
                  </p>
                </div>
                <?php endif; // end database info ?>
              </div>
            </div>
            <!--Fourth postbox: end-->

          <!-- container 1 -->
          <div class="postbox-container-max">
            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
              <!--First postbox: Cruft remover-->
              <div id="dashboard_cruft_files" class="postbox">
                <button type="button" class="handlediv button-link" aria-expanded="true">
                  <span class="screen-reader-text">Toggle panel:
                    <?php _e( 'Cruft Files (beta)', 'seravo' ); ?>
                  </span>
                  <span class="toggle-indicator" aria-hidden="true"></span>
                </button>
                <h2 class="hndle ui-sortable-handle">
                  <span>
                    <?php _e( 'Cruft Files (beta)', 'seravo' ); ?>
                  </span>
                </h2>
                <div class="inside">
                  <div class="seravo-section">
                    <p>
                      <?php _e( 'Find and delete unnecessary files in the filesystem', 'seravo' ); ?>
                    </p>
                    <p>
                      <div id="cruftfiles_status">
                        <table>
                          <tbody id="cruftfiles_entries">
                          </tbody>
                        </table>
                        <div id="cruftfiles_status_loading">
                          <?php _e( 'Finding files...', 'seravo' ); ?>
                          <img src="/wp-admin/images/spinner.gif">
                        </div>
                      </div>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- container 3 -->
          <div class="postbox-container-max">
            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
              <!-- -->
              <div id="dashboard_plugins" class="postbox">
                <button type="button" class="handlediv button-link" aria-expanded="true">
                  <span class="screen-reader-text">Toggle panel:
                    <?php _e( 'Unnecessary plugins', 'seravo' ); ?>
                  </span>
                  <span class="toggle-indicator" aria-hidden="true"></span>
                </button>
                <h2 class="hndle ui-sortable-handle">
                  <span>
                    <?php _e( 'Unnecessary plugins', 'seravo' ); ?>
                  </span>
                </h2>
                <div class="inside">
                  <div class="seravo-section">
                    <p>
                      <?php _e( 'Find and remove plugins that are unnecessary or inactive. For more information, read our <a href="https://help.seravo.com/en/knowledgebase/19-teemat-ja-lisaosat/docs/51-wordpress-lisaosat-wp-palvelu-fi-ssa">Helpy-page</a>.', 'seravo' ); ?>
                    </p>
                    <p>
                      <div id="cruftplugins_status">
                        <div id="cruftplugins_status_loading">
                          <?php _e( 'Finding plugins...', 'seravo' ); ?>
                          <img src="/wp-admin/images/spinner.gif">
                        </div>
                      </div>
                    </p>
                  </div>
                </div>
              </div>
              <!-- -->
            </div>

          </div>
          <!-- end 3 -->





        </div>
      </div>
    </div>
