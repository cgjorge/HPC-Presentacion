<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Rara_Journal
 */

$social_links = get_theme_mod('rara_journal_social_ed','1');

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>> 
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="<?php bloginfo('charset'); ?>" >
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<header id="masthead" class="site-header" role="banner">

			<?php if ( has_nav_menu( 'secondary' ) || true == $social_links ) { ?>
			
				<div class="header-top">
					<div class="container">

						<div id="mobile-header">
				    		<a id="responsive-menu-button" href="#sidr-main"><i class="fa fa-bars"></i></a>
						</div>
					
						<nav class="top-menu" id="secondary-menu">
						
							<?php wp_nav_menu( 
								array( 
										'theme_location' => 'secondary',
										'container' => false,
										'fallback_cb'  => false,
   									 ) );   								  
   								?>
						
						</nav>

						<?php
							if($social_links){
					 			rara_journal_social_link(); 
					 		}
						?>
					
					</div>
				</div>

			<?php } ?>

			<div class="header-bottom">
				<div class="container">
					<div class="site-branding">

					  	<?php 
				        	if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                            	the_custom_logo();
                       		 } 
                    	?>

                		<h1 class="site-title">
                		 	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
						</h1>
						
						<?php
    						$description = get_bloginfo( 'description', 'display' );
    						  
    						if ( $description || is_customize_preview() ) {
    					   		echo '<p class="site-description">'. esc_html( $description ) .'</p>'; /* WPCS: xss ok. */     					
    						 } 
    					?>

					</div>

					<?php if ( has_nav_menu( 'primary' ) ) { ?>

						<div id="mobile-header">
				    		<a id="responsive-menu-button" href="#sidr-main"><i class="fa fa-bars"></i></a>
						</div>

						<nav id="site-navigation" class="main-navigation" role="navigation">
							<?php wp_nav_menu( 
								array( 
										'theme_location' => 'primary',
										'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
										'fallback_cb'  => false,
   									) ); 
   								?>
						</nav>
	
					<?php } ?> 
	
				</div>
			</div>
		</header>

		<?php
    		if( is_front_page() ) {
    			if(get_theme_mod('rara_journal_ed_slider') )
    				do_action( 'rara_journal_slider' );
    			}
	 	?>

		<div id="content" class="site-content">
		<?php if ( is_category() || is_author() || is_archive() || is_tag() ) : ?>
		
			<?php do_action('rara_journal_archive_header'); ?>
		
		<?php elseif ( is_search() ) :?>
			
			<div class="page-header">
				<div class="container">
				
					<?php 
						 do_action('rara_journal_header'); 
					 	 get_search_form(); 
					?>
				</div>
			</div>   
    	<?php 
    		endif; 
    		
    		if( ! is_404() ) { 
				echo '<div class="container">';
			}

			if ( ! ( is_home() || is_search() ) ){ 
				echo '<div class="row">';
			} 
		?>
