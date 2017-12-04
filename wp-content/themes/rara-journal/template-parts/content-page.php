<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Rara_Journal
 */
$sidebar_layout = rara_journal_sidebar_layout();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
	</header><!-- .entry-header -->
    
    <?php if( has_post_thumbnail() ){ ?>

    	<div class="post-thumbnail">
        	<?php ( is_active_sidebar( 'right-sidebar' ) && ( $sidebar_layout == 'right-sidebar' ) ) ? the_post_thumbnail( 'rara-journal-with-sidebar' ) : the_post_thumbnail( 'rara-journal-without-sidebar' ) ; ?>
    	</div>

    <?php } ?>
    
	<div class="entry-content">
		<?php
			the_content();
			
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rara-journal' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'rara-journal' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
