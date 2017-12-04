<?php
/**
 * The template file for the front page.
 * If the front-page is static, this page has no sidebar: it is intended to occupy the full width.
 * Above the content, up to six featured posts will be displayed, if available.
 *
 * @package whitebox
 */

get_header(); 
global $more; ?>
      <div class="content-area front-page" id="primary">
        <main class="site-main" id="main" role="main">
        <?php /* First show featured content */
          if ( whitebox_get_featured_content(1) ) : ?>  
            <div id="featured">  
              <h2><?php _e( 'Featured Content', 'whitebox' ); ?></h2>  
              <?php global $post;
              foreach ( $featured_posts as $post ) : setup_postdata($post); $more = 0;?>  
                <?php get_template_part( 'content_featured', get_post_format() ); ?>  
              <?php endforeach; ?> 
            </div> 
            <hr> 
          <?php endif;  ?>
          <?php wp_reset_query();  
            if ( have_posts() ) : ?>            
            <?php /* Start the Loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>
              <?php
                /* Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                get_template_part( 'content', get_post_format() );
              ?>
            <?php endwhile; ?>
          <?php endif; ?>
          
          
        </main><!-- #main -->
      </div><!-- #primary -->
      <?php get_footer(); ?>