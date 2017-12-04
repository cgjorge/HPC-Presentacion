<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Rara_Journal
 */

get_header(); ?>

	<div class="container">

		<main id="main" class="site-main" role="main">

  			<div class="page">

				<span>
					<?php esc_html_e( '404: Page Not Found', 'rara-journal' ); ?>
				</span>

					<?php
						if ( is_home() && current_user_can( 'publish_posts' ) ) : 
							printf( wpautop( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'rara-journal' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ) );

						elseif ( is_search() ) : 
							wpautop( esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'rara-journal' ) ); 

						else : 
					?>
                        <p><?php esc_html_e( 'The page you were looking for cannot be found, it may have been moved or no longer exists. The search below may help you find the desired page, or you can navigate back to the homepage by clicking&nbsp;', 'rara-journal' ); ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="click-here"><?php esc_html_e( 'Home', 'rara-journal' ); ?></a></p>
					<?php
						endif; 						
						get_search_form(); 
					?>

			</div><!-- .page-content -->
		
		</main><!-- #main -->

	</div><!-- #primary -->
	<!-- .no-results -->
<?php get_footer(); ?>


