<?php
/**
 * Rara Journal functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Rara_Journal
 */


if ( ! function_exists( 'rara_journal_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rara_journal_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Rara Journal, use a find and replace
	 * to change 'rara-journal' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'rara-journal', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'rara-journal' ),
		'secondary' => esc_html__( 'Secondary', 'rara-journal' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
    	'status',
    	'audio', 
    	'chat'
	) );
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'rara_journal_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );


	/* Custom Logo */
    add_theme_support( 'custom-logo', array(    	
    	'header-text' => array( 'site-title', 'site-description' ),
    ) );

	 // Custom Image Sizes
	add_image_size( 'rara-journal-slider', 450, 301, true );
    add_image_size( 'rara-journal-with-sidebar', 846, 515, true );
    add_image_size( 'rara-journal-without-sidebar', 1140, 610, true );
    add_image_size( 'rara-journal-featured-post', 275, 275, true );
    add_image_size( 'rara-journal-recent-post', 66, 66, true );
	
}
endif;
add_action( 'after_setup_theme', 'rara_journal_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rara_journal_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rara_journal_content_width', 845 );
}
add_action( 'after_setup_theme', 'rara_journal_content_width', 0 );

/**
* Adjust content_width value according to template.
*
* @return void
*/
function rara_journal_template_redirect_content_width() {

	// Full Width in the absence of sidebar.
	if( is_page() ){

	   $sidebar_layout = rara_journal_sidebar_layout();
       if( ( $sidebar_layout == 'no-sidebar' ) || ! ( is_active_sidebar( 'right-sidebar' ) ) ) $GLOBALS['content_width'] = 1170;

        
	}elseif ( ! ( is_active_sidebar( 'right-sidebar' ) ) ) {

		$GLOBALS['content_width'] = 1170;
	
	}
}
add_action( 'template_redirect', 'rara_journal_template_redirect_content_width' );



/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rara_journal_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'rara-journal' ),
		'id'            => 'right-sidebar',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

    register_sidebar( array(
		'name'          => esc_html__( 'Footer One', 'rara-journal' ),
		'id'            => 'footer-one',
		'description'   => '',
		'before_widget' => '<aside  class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Two', 'rara-journal' ),
		'id'            => 'footer-two',
		'description'   => '',
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Three', 'rara-journal' ),
		'id'            => 'footer-three',
		'description'   => '',
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Four', 'rara-journal' ),
		'id'            => 'footer-four',
		'description'   => '',
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rara_journal_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rara_journal_scripts() {

	$my_theme = wp_get_theme();
    $version = $my_theme['Version'];

	$query_args = array(
		'family' => 'Lustria|Lato:400,700',
		);
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.css' );
	wp_enqueue_style( 'lightslider', get_template_directory_uri().'/css/lightslider.css' );
	wp_enqueue_style( 'jquery-sidr-light', get_template_directory_uri().'/css/jquery.sidr.light.css' );
	wp_enqueue_style( 'meanmenu', get_template_directory_uri().'/css/meanmenu.css' );
	wp_enqueue_style( 'rara-journal-google-fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ) );
	wp_enqueue_style( 'rara-journal-style', get_stylesheet_uri(), array(), $version );


	wp_enqueue_script( 'lightslider', get_template_directory_uri() . '/js/lightslider.js', array('jquery'), $version, true );
	wp_enqueue_script( 'jquery-meanmenu', get_template_directory_uri() . '/js/jquery.meanmenu.js', array('jquery'), '2.0.8', true );
	wp_enqueue_script( 'jquery-sidr', get_template_directory_uri() . '/js/jquery.sidr.js', array('jquery'), $version, true );
	wp_enqueue_script( 'rara-journal-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), $version, true );


    $rarajournal_slider_auto = get_theme_mod( 'rara_journal_slider_auto', '1' );
    $rarajournal_slider_loop = get_theme_mod( 'rara_journal_slider_loop', '1' );
    $rarajournal_slider_pager = get_theme_mod( 'rara_journal_slider_pager', '1' );    
    $rarajournal_slider_animation = get_theme_mod( 'rara_journal_slider_animation', 'slide' );
    $rarajournal_slider_speed = get_theme_mod( 'rara_journal_slider_speed', '7000' );
    $rarajournal_animation_speed = get_theme_mod( 'rara_journal_animation_speed', '600' );
    
    $rarajournal_array = array(
        'auto'      => esc_attr( $rarajournal_slider_auto ),
        'loop'      => esc_attr( $rarajournal_slider_loop ),
        'pager'   	=> esc_attr( $rarajournal_slider_pager ),
        'animation' => esc_attr( $rarajournal_slider_animation ),
        'speed'     => absint( $rarajournal_slider_speed ),
        'a_speed'   => absint( $rarajournal_animation_speed )
    );
    
    wp_localize_script( 'rara-journal-custom', 'rarajournal_data', $rarajournal_array );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rara_journal_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Featured Post Widget
 */
require get_template_directory() . '/inc/widget-featured-post.php';

/**
 * Recent Post Widget
 */
require get_template_directory() . '/inc/widget-recent-post.php';

/**
 * Recent Post Widget
 */
require get_template_directory() . '/inc/widget-popular-post.php';


/**
 * Recent Post Widget
 */
require get_template_directory() . '/inc/widget-social-links.php';


/**
 * Recent Post Widget
 */
require get_template_directory() . '/inc/metabox.php';
