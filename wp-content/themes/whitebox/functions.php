<?php
/**
 * whitebox functions and definitions
 *
 * @package whitebox
 * @since 1.0
 */ 

/**
 * Register widgetized area and update sidebar with default widgets
 */
function whitebox_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Sidebar', 'whitebox' ),
    'id'            => 'sidebar-1',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ) );
}
/**
 * Enqueue scripts and styles
 */
function whitebox_scripts() {
  wp_enqueue_style( 'whitebox-open-sans', 
    '//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,latin-ext' );
  wp_enqueue_style( 'whitebox-style', get_stylesheet_uri(), null, '', 'Screen' );
  wp_enqueue_script( 'whitebox',  get_template_directory_uri() . '/js/whitebox.js', array('jquery'), '08092013', true);
}

/**
 * Custom functions that act independently of the theme templates.
 */
require_once( trailingslashit( get_template_directory() ). '/inc/template-tags.php');
require_once( trailingslashit( get_template_directory() ).'/inc/extras.php');
require_once( trailingslashit( get_template_directory() ).'/inc/breadcrumb-trail.php');
require_once( trailingslashit( get_template_directory() ).'/inc/jetpack.php');
/**
 * Load Jetpack compatibility file.
 */
require_once( trailingslashit( get_template_directory() ).'/inc/jetpack.php');

  /**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if ( ! function_exists( 'whitebox_setup' ) ) :
  function whitebox_setup() {
    global $content_width;
    /**
     * Set the content width based on the theme's design and stylesheet.
     */
    if ( ! isset( $content_width ) )
      $content_width = 1120; /* pixels */      
    /**
     * Make theme available for translation
     * Translations can be filed in the /languages/ directory
     */
    load_theme_textdomain( 'whitebox', get_template_directory() . '/languages' );

    /**
     * Add default posts and comments RSS feed links to head
     * Format according to HTML5
     */
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    /**
     * Enable support for Featured Images on posts and pages
     */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size(300, 9999, true);
    add_image_size( 'featured-image-thumb', 300, 9999 );
      /**
     * This theme uses wp_nav_menu() in one location.
     */
    add_theme_support( 'menus' );
    register_nav_menus( array(
      'primary' => __( 'Primary Menu', 'whitebox' ),
      'social' => __( 'Social Menu', 'whitebox' ),
    ) );
	 /*  Enable support for Post Formats.	 */
    add_theme_support( 'post-formats', array(	'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery'	) );
    
    /**
     * Make it possible to have a stylesheet editor-style.css for the editor
     */
     add_editor_style();
     
     // This theme allows users to set a custom background.
    add_theme_support( 'custom-background', array( 'default-color' => '99cccc' ) );    
   
  }
endif; 
add_action( 'after_setup_theme', 'whitebox_setup' );
add_action( 'widgets_init', 'whitebox_widgets_init' );
add_action( 'wp_enqueue_scripts', 'whitebox_scripts' );

function whitebox_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'whitebox') . '</a>';
}
add_filter( 'excerpt_more', 'whitebox_excerpt_more' );

function whitebox_get_featured_content( $minimum = 1 ) {
  global $featured_posts;
    if ( is_paged() )
        return false;
    $featured_posts = apply_filters( 'whitebox_get_featured_posts', array() );    
    if ( ! is_array( $featured_posts ) )
        return false;
 
    if ( $minimum > count( $featured_posts ) )
        return false;
 
    return true;    
} 

?>
