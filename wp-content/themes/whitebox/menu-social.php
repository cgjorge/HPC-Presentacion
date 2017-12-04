<?php 
/**
 * whitebox social menu
 *
 * @package whitebox
 * @since 1.0
 */

if ( has_nav_menu( 'social' ) ) {

	wp_nav_menu(
		array(
			'theme_location'  => 'social',
			'container'       => false,
			'container_id'    => 'menu-social',
			'container_class' => 'menu',
			'menu_id'         => 'menu-social-items',
			'menu_class'      => 'menu-items',
			'depth'           => 1,
			'link_before'     => '<span class="screen-reader-text">',
			'link_after'      => '</span>',
			'fallback_cb'     => '',
		)
	);

} ?>