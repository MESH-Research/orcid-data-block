<?php
/**
 * Plugin Name:       ORCiD Information
 * Description:       Block editing of data from ORCiD
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Amaresh R Joshi (joshia@msu.edu)
 * License:           GPL-3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       orcid-block
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_orcid_block_block_init() {
        register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_orcid_block_block_init' );
