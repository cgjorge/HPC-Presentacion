<?php
add_action( 'wp_enqueue_scripts', 'redify_theme_css',999);
function redify_theme_css() {
    wp_enqueue_style( 'redify-parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'redify-child-style', get_stylesheet_uri(), array( 'redify-parent-style' ) );
}
?>