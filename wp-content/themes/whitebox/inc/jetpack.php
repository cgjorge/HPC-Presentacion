<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package whitebox
 * @since 1.0
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function whitebox_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
  	// Jetpack: Add support for featured content.
  add_theme_support( 'featured-content', array(
      'featured_content_filter' => 'whitebox_get_featured_posts',
      'max_posts' => 6,
      'post_types' => array( 'post'),
  ) );
    	// Jetpack: Add support for responsive videos.
  add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'whitebox_jetpack_setup' );
