<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package whitebox
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php if ( is_singular() && comments_open() && get_option('thread_comments') )
          wp_enqueue_script( 'comment-reply' );
  ?>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php do_action( 'before' ); ?>
  <header class="site-header" id="masthead" role="banner" >
    <nav class="main-navigation" id="site-navigation" role="navigation">
      <h1 class="menu-toggle"><?php _e( 'Menu', 'whitebox' ); ?></h1>
      <div class="screen-reader-text skip-link">
      <a href="#content" title="<?php esc_attr_e( 'Skip to content', 'whitebox' ); ?>"><?php _e( 'Skip to content', 'whitebox' ); ?></a>
      </div>
      <?php wp_nav_menu( array( 'sort_column' => 'menu_order'  ) ); ?>
    </nav><!-- #site-navigation -->
    <div class="site-branding">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
        <h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
      </a>
      <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
      <?php whitebox_breadcrumb_trail();?>
    </div>
  </header><!-- #masthead -->
  <div class="hfeed site" id="page">
    <div class="site-content" id="content">
