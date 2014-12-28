<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Latest_Posts_Custom_Post_Types
 * @author    Mike Turner <turner.mike@gmail.com>
 * @license   GPL-2.0+
 * @link      http://hi-hatconsulting.com
 * @copyright 2014 Hi-hat Consulting
 *
 * @wordpress-plugin
 * Plugin Name:       Latest Posts Custom Post Types
 * Plugin URI:        http://hi-hatconsulting.com
 * Description:       A plugin for displaying the latest posts for a custom post type.
 * Version:           1.0.0
 * Author:            Mike Turner
 * Author URI:        http://hi-hatconsulting.com
 * Text Domain:       latest-posts-custom-post-types
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * WordPress-Plugin-Boilerplate: v2.6.1
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-latest-posts-custom-post-types.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-latest-posts-custom-post-types.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Latest_Posts_Custom_Post_Types with the name of the class defined in
 *   `class-latest-posts-custom-post-types.php`
 */
register_activation_hook( __FILE__, array( 'Latest_Posts_Custom_Post_Types', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Latest_Posts_Custom_Post_Types', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Latest_Posts_Custom_Post_Types with the name of the class defined in
 *   `class-latest-posts-custom-post-types.php`
 */
add_action( 'plugins_loaded', array( 'Latest_Posts_Custom_Post_Types', 'get_instance' ) );


