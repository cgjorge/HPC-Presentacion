<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package whitebox
 * @since 1.0
 */
?>
<?php
 /**
 * Set the url of the designer of the Whitebox theme.
 */
if ( ! isset( $designer_url) )
	$designer_url = 'http://dev.spiderproductions.nl';
	
 /**
 * Set the name of the designer of the Whitebox theme.
 */
if ( ! isset( $designer_name) )
	$designer_name = 'Spider productions';
?>
      </div><!-- #content -->
      <footer class="site-footer" id="colophon" role="contentinfo">
        <div class="site-info">
          <?php do_action( 'whitebox_credits' ); ?>
          <span class="sep"> | </span>
          <?php printf( __( 'Theme: %1$s by %2$s.', 'whitebox' ), 'whitebox', '<a href="' . $designer_url . '">'. $designer_name . '</a>' ); ?>
          <span class="sep"> | </span>
        </div><!-- .site-info -->
        <?php wp_footer(); ?>
      </footer><!-- #colophon -->
      </div><!-- #page -->
      <div id="whitebox-area">
        <div class="clear" id="whitebox-area-content">
          <aside id="search-form">
				<?php get_search_form(true); ?>
			</aside>
			<aside>
				<?php get_template_part( 'menu', 'social' ); ?>
			</aside>
		</div>
	</div>
</body>
</html>