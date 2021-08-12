<?php
/**
 * The Unit Test for displaying the list of contributors on frotnend
 * 
 * Class Wc_Wordpress_Contributors_Test
 *
 * @package Wc_Wordpress_Contributors
 */
class Wc_Wordpress_Contributors_Test extends WP_UnitTestCase {

	function test_constructor() {
		$wc_contributors = new Wc_Wordpress_Contributors();

		$is_action_hooked = has_action( 'the_content', [ $wc_contributors, 'wc_wordpress_contributors_filter_the_content' ] );

		$this->assertTrue( 10 === $is_action_hooked );
	}

	function test_wc_wordpress_contributors_filter_the_content(){
		global $wp_query;

		//initialize the class'Wc_Wordpress_Contributors'
		$wc_contributors = new Wc_Wordpress_Contributors();
		
		// Implement 'WP_UnitTest_Factory_For_Post' class
		$post_id = $this->factory->post->create( [
			'post_status' => 'publish',
			'post_title'  => 'Test Case One',
			'post_content' => 'Lorem ipsum doller imet id',
		] );

		// Generate user ids.
		$user_ids = $this->factory->user->create_many( 3 );

		// Save user ids created above into 'wc_contributors' post meta key.
		update_post_meta( $post_id, 'wc_contributors', $user_ids );

		$wp_query = new WP_Query( [
			'post__in' => [ $post_id ],
			'posts_per_page' => 1,
		] );

		// Call our wc_wordpress_contributors_filter_the_content() to add the $content to each post content.
		if ( $wp_query->have_posts() ) {
			while( $wp_query->have_posts() ) {
				$wp_query->the_post();

				$wp_query->is_single = true;

				$output = $wc_contributors->wc_wordpress_contributors_filter_the_content( 'Testing Test cases' );

				// Check the 'wc-contributor-list' class name in content
				$classname_exists = strpos( $output, 'wc-contributor-list' );

				$this->assertTrue( false !== $classname_exists );

			}
		}
	}
}