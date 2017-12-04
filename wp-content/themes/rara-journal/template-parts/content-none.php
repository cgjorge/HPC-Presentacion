<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Rara_Journal
 */

?>
<div id="content" class="site-content">
	<div class="container">

		<main id="main" class="site-main" role="main">

			<div class="page">

				<?php if ( !  is_search() ){ ?>
					<span><h2 class="entry-title"><?php esc_html_e( ' 404: Page Not Found', 'rara-journal' ); ?></h2></span>
				<?php } ?>

				<div class="page-content">
					
					<?php
						if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
						<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'rara-journal' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
					
					<?php elseif ( is_search() ) : ?>
						<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'rara-journal' ); ?></p>
					
					<?php else : ?>
					<p><?php esc_html_e( 'The page you were looking for cannot be found, it may have been moved or no longer exists. The search below may help you find the desired page, or you can navigate back to the homepage by clicking&nbsp;', 'rara-journal' ); ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rara-journal' ); ?></a></p>
				
					<?php endif; ?>
				</div>

			</div>
			
		</main>

	</div>
</div>