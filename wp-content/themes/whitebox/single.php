<?php
/**
 * The Template for displaying all single posts.
 *
 * @package whitebox
 */

get_header(); ?>
<?php
  if (has_post_thumbnail()) {
    $whiteboxImage = get_the_post_thumbnail('full');
    the_post_thumbnail('full', array(
      'class'	=> "wb-wide-image",
    ));
  }
?>
        <div class="content-area" id="primary">
          <main class="site-main" id="main" role="main">
          <?php while ( have_posts() ) : the_post(); ?>
            <?php $wb_type =  get_post_type($post->ID);?>
            <?php get_template_part( 'content', $wb_type ); ?>
            <?php whitebox_content_nav( 'nav-below' ); ?>
            <?php
              // If comments are open or we have at least one comment, load up the comment template
              if ( comments_open() || '0' != get_comments_number() )
                comments_template();
            ?>
          <?php endwhile; // end of the loop. ?>
          </main><!-- #main -->
        </div><!-- #primary -->
      <?php get_sidebar(); ?>
      <?php get_footer(); ?>