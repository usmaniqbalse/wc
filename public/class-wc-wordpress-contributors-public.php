<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.wordpress.com
 * @since      1.0.0
 *
 * @package    Wc_Wordpress_Contributors
 * @subpackage Wc_Wordpress_Contributors/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wc_Wordpress_Contributors
 * @subpackage Wc_Wordpress_Contributors/public
 * @author     Usman Iqbal <software.engineer.usman@gmail.com>
 */
class Wc_Wordpress_Contributors_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Wordpress_Contributors_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Wordpress_Contributors_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wc-wordpress-contributors-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Wordpress_Contributors_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Wordpress_Contributors_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wc-wordpress-contributors-public.js', array('jquery'), $this->version, false);
	}
	/**
	 * Display the contributors under the posts.
	 *
	 * @since    1.0.0
     *
     * @param   mixed $content
     * @return  mixed $content
	 */
	public function wc_wordpress_contributors_filter_the_content($content)
	{
		// Check if we're inside the main loop in a single Post.
		if ( is_singular() && in_the_loop() && is_main_query() ) {
			$wc_contributors = get_post_meta( get_the_ID(), 'wc_contributors',true );

			// If there is no contributor checked
			if( !is_array( $wc_contributors ) ){
				return;
			}

			$userDisplay = "<div class='wc-contributor-list'><span>Contributors:</span>"; 
			$userDisplay .= "<ul>";
			foreach ($wc_contributors as $key => $wc_contributor) {
				$author_obj = get_user_by('id', $wc_contributor);
				$userDisplay .= "<li><a href='".esc_url( get_author_posts_url($wc_contributor) )."'><img class='avatar_image' src='".esc_url( get_avatar_url( $wc_contributor ) )."' /> ".$author_obj->data->user_login."</a></li>";
			}
			$userDisplay .= "</ul></div>"; 
			return $content . __($userDisplay, 'wc-wordpress-contributors');
		}

		return $content;
	}
}
