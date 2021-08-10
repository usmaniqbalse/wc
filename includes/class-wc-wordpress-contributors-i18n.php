<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.wordpress.com
 * @since      1.0.0
 *
 * @package    Wc_Wordpress_Contributors
 * @subpackage Wc_Wordpress_Contributors/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wc_Wordpress_Contributors
 * @subpackage Wc_Wordpress_Contributors/includes
 * @author     Usman Iqbal <software.engineer.usman@gmail.com>
 */
class Wc_Wordpress_Contributors_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wc-wordpress-contributors',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
