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

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
/**
 *  orcid + orcid_data_block + block_init ()
*/


/** Commenting this out because it's forcing an error 
function orcid_orcid_data_block_block_init() {
  // automatically load dependencies and version
  $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');

  // register_block_type( __DIR__ . '/build' );
  register_block_type(
    __DIR__ . '/build',
    array(
      'api_version' => 2,
      //'attributes' => [],
      // this line causes an error
      //'editor_script' => 'orcid_orcid_data_block_block_init',
      'render_callback' => 'orcid_data_block_dynamic_render_callback',
    )
  );
}
add_action( 'init', 'orcid_orcid_data_block_block_init' );
*/
/**
 * Callback function to display the data from ORCiD:section
 *
 * @param {Object}   $block_attributes   Block attributes object
 * @param {String}   $contents Block contents
 *
 * @return {HTML} Element to render.
 */
function orcid_data_block_dynamic_render_callback( $block_attributes, $content ) {
  //
  // HOW send the $block_attributes to the LOG file to examine

//   if( array_key_exists( 'section', $block_attributes ) ){
//       $section = $block_attributes['section'];
//   }
//   if( array_key_exists( 'worksType', $block_attributes ) ){
//     $works_type = $block_attributes['worksType'];
//   } else {
//     $works_type = "all";
//   }
//   if( array_key_exists( 'worksStartYear', $block_attributes ) ){
//     $works_start_year = $block_attributes['worksStartYear'];
//   } else {
//     $works_start_year = "3000";
//   }

  $section = $block_attributes['section'];
  $works_start_year = $block_attributes['worksStartYear'];
  $works_type = $block_attributes['worksType'];


  $time_stamp = new DateTime();
  $time_stamp_str = $time_stamp->format('Y-m-d H:i:s');
  //$orcid_html = "<div class=\"orcid-timestamp\">The time is now:&nbsp;<b>{$time_stamp_str}</b></div>";
  $orcid_html = "";
  //+++++++++++++++++++++
//   $orcid_html = $orcid_html . "<ul>";
//   foreach($block_attributes as $key => $value){
//     $orcid_html = $orcid_html . "<li>{$key}:{$value}</li>";
//   }
//   $orcid_html = $orcid_html . "</ul>";
  //+++++++++++++++++++++

  $orcid_html = $orcid_html . orcid_data_block_function($section, $works_type, $works_start_year);
  return $orcid_html;
}

/**
 *
 */
include_once( plugin_dir_path( __FILE__ ) . 'config.php' );
include( plugin_dir_path( __FILE__ ) . 'orcid-functions.php' );

/************************
 * WORDPRESS HOOKS
 ************************/

/**
 * add actions to the (de)install activation hooks
 */
register_activation_hook( __FILE__, 'orcid_install' );
register_deactivation_hook( __FILE__, 'orcid_uninstall' );

/**
 * install procedures:
 * schedule daily event to update publication lists
 */
function orcid_install() {
        // empty for now
}

/**
 * un-install procedures:
 * remove any scheduled tasks
 */
function orcid_uninstall() {
        // empty for now
}

//add_action('wp_enqueue_scripts', 'orcid_scripts');
//add_action('admin_enqueue_scripts', 'orcid_scripts');

/**
 * add javascript and stylesheets to both the admin page and front-end.
 * hooked by 'wp_enqueue_scripts' and 'admin_enqueue_scripts'
 */
function orcid_scripts() {
        // empty for now
        // wp_enqueue_style('orcid_style', plugins_url('ip_style.css', __FILE__));
        // wp_enqueue_script('orcid_script', plugins_url('ip_script.js', __FILE__), array('jquery'), null, true);
}

/************************
 * SHORTCODE HOOKS
 ************************/
/**
 * register the shortcode
 */
function register_shortcodes() {
        add_shortcode( 'orcid-data', 'orcid_data_function' );
}

/**
 * hook into WordPress
 */
add_action( 'init', 'register_shortcodes' );

/**
 * create the admin menu
 * hooked by admin_menu event
 */
function orcid_create_menu() {
        add_menu_page( 'My ORCiD Retrieval and Display Information', 'My ORCiD Profile',
                'edit_posts', __FILE__, 'orcid_settings_form' );
}

/************************
 * SETTINGS MENU
 ************************/
add_action( 'admin_menu', 'orcid_create_menu' );

/**
 * create and handle the settings form
 * hooked by orcid_create_menu
 */
function orcid_settings_form() {
        $user_ob = wp_get_current_user();
        $user    = $user_ob->ID;
        if ( ! empty( get_user_meta( $user, '_orcid_id', true ) ) ) {
                $orcid_id = get_user_meta( $user, '_orcid_id', true );
        }
        //=================================================
        $download_from_orcid_flag = false;
        //=================================================
        // process a form submission if it has occurred
        if ( isset( $_POST['submit'] ) ) {
                //+++++++++++++++++++++++++++++++++++++++++++++++++++++
                // check_admin_referer('orcid_nonce')?
                // this used for security to validate form data came from current site.
                // see: https://codex.wordpress.org/Function_Reference/check_admin_referer
                // nonce: https://wordpress.org/support/article/glossary/#nonce
                //+++++++++++++++++++++++++++++++++++++++++++++++++++++
                check_admin_referer( 'orcid_nonce' );

                if ( isset( $_POST['orcid_id'] ) ) {
                        $orcid_id = $_POST['orcid_id'];
                } else {
                        $orcid_id = '';
                }
                //
                // we can either download the data from orcid.org OR use the cached value
                // we download the data IFF ($download_from_orcid_flag = TRUE)
                // 1) orcid_id has changed
                // 2) there is no cached xml data
                // 3) the cached value is older than ORCID_CACHE_TIMEOUT (in seconds)
                //
                $download_from_orcid_flag = false;
                //
                // 1) orcid_id has changed
                $orcid_id_db = get_user_meta( $user, '_orcid_id', true );
                if ( $orcid_id !== $orcid_id_db ) {
                        $download_from_orcid_flag = true;
                        // save new value
                        update_user_meta( $user, '_orcid_id', $orcid_id );
                }
                //
                // 2) there is no cached xml data
                // empty($foo) is better than ($foo == '')
                if ( empty( get_user_meta( $user, '_orcid_xml', true ) ) ) {
                        $download_from_orcid_flag = true;
                }
                //
                // 3) the cached value is older than ORCID_CACHE_TIMEOUT (in seconds)
                $current_time = time();
                // last download time
                $orcid_xml_download_time = intval( get_user_meta( $user, '_orcid_xml_download_time', true ) );
                //
                $time_diff = $current_time - $orcid_xml_download_time;
                if ( $time_diff >= ORCID_CACHE_TIMEOUT ) {
                        $download_from_orcid_flag = true;
                }
                //
                // we EITHER previously saved the orcid_id as metadata
                // OR we are taking the value from the database
                $orcid_id = get_user_meta( $user, '_orcid_id', true );

        }
        ?>
    <!-- $orcid_id = get_user_meta( $user, '_orcid_id', true ); -->

    <div class="wrap">
        <h2>ORCiD Profile Settings</h2>
        <form method="POST" id="orcidForm">
            <!-- wp_nonce_field used for security (see above comment) -->
                        <?php wp_nonce_field( 'orcid_nonce' ); ?>
            <!-- need to replace table with CSS -->
            <table>
                <tr>
                    <td><label for="orcid_id">ORCiD ID</label></td>
                    <td>
                        <input type="text" name="orcid_id" id="orcid_id"
                               value="<?php echo esc_attr__( $orcid_id ); ?>">
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Update" class="button-primary"/></td>
                </tr>
            </table>
        </form>
    </div>

        <?php
        if ( $download_from_orcid_flag ) {
                echo '<p>Downloading XML data from orcid.org</p>' . PHP_EOL;
                $orcid_xml = orcid_download_data( $orcid_id );
                update_user_meta( $user, '_orcid_xml', $orcid_xml );
                //
                // keep track of when download occurred
                update_user_meta( $user, '_orcid_xml_download_time', strval( time() ) );
        } else {
                echo '<p>Using cached XML data</p>' . PHP_EOL;
                $orcid_xml = get_user_meta( $user, '_orcid_xml', true );
        }

        //
        // this option (display a title line/header) is not available to the user
        // it is set to 'yes' in the orcid config backend
        // it can be set to 'no' when individual orcid sections are to be displayed
        // e.g. when using short words
        $display_sections['display_header'] = 'yes';

        $display_sections['display_personal']           = 'yes';
        $display_sections['display_education']          = 'yes';
        $display_sections['display_employment']         = 'yes';
        $display_sections['display_works']              = 'yes';
        $display_sections['works_type']                 = 'all';
        $display_sections['works_start_year']           = '1900';
        $display_sections['display_fundings']           = 'yes';
        $display_sections['display_peer_reviews']       = 'yes';
        $display_sections['display_invited_positions']  = 'yes';
        $display_sections['display_memberships']        = 'yes';
        $display_sections['display_qualifications']     = 'yes';
        $display_sections['display_research_resources'] = 'yes';
        $display_sections['display_services']           = 'yes';
        $orcid_html                                     = orcid_format_data_as_html( $orcid_xml, $display_sections );
        echo '<div class="wrap" id="orcid_wrapper">' . $orcid_html . '</div>';
}

