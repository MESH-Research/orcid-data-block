<?php
/**
 * Plugin Name:       ORCiD Data
 * Plugin URI:        https://commons.msu.edu/
 * Description:       Data from ORCiD.org
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Amaresh R Joshi
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       orcid-data-block
 *
 * @package           orcid
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!extension_loaded('xsl')) {
    add_action('plugins_loaded', 'orcid_data_block_init_deactivation');

    /**
     * Schedule the plugin to be deactivated if the PHP XSLT extension is not enabled.
     *
     * @return void
     */
    function orcid_data_block_init_deactivation() {
        if (current_user_can('activate_plugins')) {
            add_action('admin_init', 'orcid_data_block_deactivate');
            add_action('admin_notices', 'orcid_data_block_admin_notice');
        }

        /**
         * Deactivate the plugin.
         *
         * @return void
         */
        function orcid_data_block_deactivate() {
            deactivate_plugins(plugin_basename(__FILE__));
        }

        /**
         * Display an admin notice explaining why the plugin was deactivated.
         *
         * @return void
         */
        function orcid_data_block_admin_notice() {
            $notice = '<strong>' . __('ORCiD Data requires the PHP XSL extension to be enabled.  It is not enabled, so the plugin has been deactivated.', 'orcid-data-block') . '</strong>';
            ?>
        <div class="updated"><p><?php echo $notice; ?></p></div>
            <?php
        }
    }

    return false;
}

require plugin_dir_path(__FILE__) . '/init.php';
