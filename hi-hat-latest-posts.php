<?php
/**
 * Hi-hat Latest Posts
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Hi_Hat_Latest_Posts
 * @author    Mike Turner <turner.mike@gmail.com>
 * @license   GPL-2.0+
 * @link      http://hi-hatconsulting.com
 * @copyright 2014 Hi-hat Consulting
 *
 * @wordpress-plugin
 * Plugin Name:       Hi-hat Latest Posts
 * Plugin URI:        http://hi-hatconsulting.com
 * Description:       A plugin for displaying the latest posts of a Custom Post Type. Date and Excerpt fields are optional. (WIDGET ONLY)
 * Version:           1.0.0
 * Author:            Mike Turner
 * Author URI:        http://hi-hatconsulting.com
 * Text Domain:       hi-hat-latest-posts
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
 * - replace `class-hi-hat-latest-posts.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-hi-hat-latest-posts.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Hi_Hat_Latest_Posts with the name of the class defined in
 *   `class-hi-hat-latest-posts.php`
 */
register_activation_hook( __FILE__, array( 'Hi_Hat_Latest_Posts', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Hi_Hat_Latest_Posts', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Hi_Hat_Latest_Posts with the name of the class defined in
 *   `class-hi-hat-latest-posts.php`
 */
add_action( 'plugins_loaded', array( 'Hi_Hat_Latest_Posts', 'get_instance' ) );


