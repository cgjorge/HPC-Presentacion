<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package whitebox
 */

get_header(); ?>
      <section class="content-area" id="primary">
        <main class="site-main" id="main" role="main">
        <?php if ( have_posts() ) : ?>
          <header class="page-header">
            <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'whitebox' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
          </header><!-- .page-header -->
          <?php /* Start the Loop */ ?>
          <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'content', 'search' ); ?>
          <?php endwhile; ?>
          <?php whitebox_content_nav( 'nav-below' ); ?>
        <?php else : ?>
          <?php get_template_part( 'no-results', 'search' ); ?>
        <?php endif; ?>
        </main><!-- #main -->
      </section><!-- #primary -->
    <?php get_sidebar(); ?>
    <?php get_footer(); ?>