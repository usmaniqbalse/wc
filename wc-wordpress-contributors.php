<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/plugins/wc-wordpress-contributors/
 * @since             1.0.0
 * @package           Wc_Wordpress_Contributors
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Contributors
 * Plugin URI:        https://wordpress.org/plugins/wc-wordpress-contributors/
 * Description:       This plugin will be used to display more than one author name on a post.
 * Version:           1.0.0
 * Author:            Usman Iqbal
 * Author URI:        https://profiles.wordpress.org/seusmaniqbal/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-wordpress-contributors
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WC_WORDPRESS_CONTRIBUTORS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-wordpress-contributors-activator.php
 */
function activate_wc_wordpress_contributors() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-wordpress-contributors-activator.php';
	Wc_Wordpress_Contributors_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-wordpress-contributors-deactivator.php
 */
function deactivate_wc_wordpress_contributors() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-wordpress-contributors-deactivator.php';
	Wc_Wordpress_Contributors_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_wordpress_contributors' );
register_deactivation_hook( __FILE__, 'deactivate_wc_wordpress_contributors' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-wordpress-contributors.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_wordpress_contributors() {

	$plugin = new Wc_Wordpress_Contributors();
	$plugin->run();

}
run_wc_wordpress_contributors();