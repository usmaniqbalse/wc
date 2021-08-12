<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.wordpress.com
 * @since      1.0.0
 *
 * @package    Wc_Wordpress_Contributors
 * @subpackage Wc_Wordpress_Contributors/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Wordpress_Contributors
 * @subpackage Wc_Wordpress_Contributors/admin
 * @author     Usman Iqbal <software.engineer.usman@gmail.com>
 */
class Wc_Wordpress_Contributors_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-wordpress-contributors-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-wordpress-contributors-admin.js', array('jquery'), $this->version, false );
	}
	/**
	 * Function for register the custom meta for the Posts
	 *
	 * @since  1.0.0
	 * @param  void
	 * @return void
	 */
	public function register_wc_wordpress_contributors_posts_meta()
	{
		add_meta_box( 'wc-wordpress-contributors-meta', __( 'Contributors', 'wc-wordpress-contributors' ), array( $this, 'wc_wordpress_contributors_meta_display_callback' ), 'post', 'advanced', 'high' );
	}
	/**
	 * Function for showing the  post
	 *
	 * @since  1.0.0
	 * @param  void
	 * @return object
	 */
	public function wc_wordpress_contributors_meta_display_callback()
	{
		global $post;
		$html = '';
		$wc_contributors = get_post_meta( $post->ID, 'wc_contributors',true );
		wp_nonce_field( 'wc_wordpress_contributors_meta_action', 'wc_wordpress_contributors_meta_nonce' );
		ob_start();
		$args = array( 
			'fields' => array( 
				'display_name', 
				'id', 
				'user_login' 
			) 
		);
		if( $users = get_users( $args ) ) {
			$html .= '<p class="wc-authors-list">';
			foreach( $users as $user ) {
				$checked = ( is_array( $wc_contributors ) && in_array( $user->id, $wc_contributors ) ) ? ' checked="checked"' : ''; 
				$html .= '<input name="wc_contributors[]" type="checkbox" value="' . $user->id . '"' . $checked . '>' .esc_attr($user->display_name). " ";
			}
			$html .= '</p>';
		}
		// $output = ob_get_contents();
		ob_end_clean();
		echo $html;
	}

	/**
	 * Function for save meta boxes
	 *
	 * @since  1.0.0
	 * @param  int $post_id
	 * @return object
	 */
	public function register_wc_wordpress_contributors_posts_save_meta($post_id)
	{

		// Check if nonce is set.
        if ( NULL == filter_input( INPUT_POST, 'wc_wordpress_contributors_meta_nonce' ) ) {
		    return;
		}

		// Verify that the nonce is valid.
		check_admin_referer( 'wc_wordpress_contributors_meta_action', 'wc_wordpress_contributors_meta_nonce' );

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}	

		update_post_meta( $post_id, 'wc_contributors', $_POST['wc_contributors'] ); 
	}
}
