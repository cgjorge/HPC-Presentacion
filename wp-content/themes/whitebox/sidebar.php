<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package whitebox
 */
?>
        <div class="widget-area" id="secondary" role="complementary">
          <?php do_action( 'before_sidebar' ); ?>
        <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
          <aside class="widget" id="archives">
            <h1 class="widget-title"><?php _e( 'Archives', 'whitebox' ); ?></h1>
            <ul>
              <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
          </aside>
          <aside class="widget" id="meta">
            <h1 class="widget-title"><?php _e( 'Meta', 'whitebox' ); ?></h1>
            <ul>
              <?php wp_register(); ?>
              <li><?php wp_loginout(); ?></li>
              <?php wp_meta(); ?>
            </ul>
          </aside>
        <?php endif; // end sidebar widget area ?>
        </div><!-- #secondary -->
