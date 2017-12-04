<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Rara_Journal
 */
$read_more = get_theme_mod( 'rara_journal_post_read_more', __( 'Continue Reading','rara-journal' ) );

?>

<article class="post" id="post-<?php the_ID(); ?>" >

	<header class="entry-header">
	
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?><!-- .entry-header -->
			<?php if ( 'post' === get_post_type() ) { ?>
				<div class="entry-meta">
					<?php 
					 	 rara_journal_posted_on();
					?>
				</div>
			<?php } ?>
	
	</header>
	
	<?php 

		if ( has_post_thumbnail() ){
    		
			echo !is_single() ? '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">' : '<div class="post-thumbnail">'; 
            if( is_home() ){
                    the_post_thumbnail( 'rara-journal-without-sidebar' );
                }
            else{
				is_active_sidebar( 'right-sidebar' ) ? the_post_thumbnail( 'rara-journal-with-sidebar' ) : the_post_thumbnail( 'rara-journal-without-sidebar' ) ; 
			}
            echo ( !is_single() ) ? '</a>' : '</div>' ; 
    	}
    ?>

		<div class="entry-content"><!-- Content -->

			<?php
				if( is_single() ){
     				
     				the_content( sprintf(
    				/* translators: %s: Name of current post. */
    				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'rara-journal' ), array( 'span' => array( 'class' => array() ) ) ),
    				the_title( '<span class="screen-reader-text">"', '"</span>', false )
    				) );

         		 }else{
        		    
        		    if( false === get_post_format() ){

         		   	    the_excerpt();

        			}else{

           		   		the_content( sprintf(
        				/* translators: %s: Name of current post. */
        				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'rara-journal' ), array( 'span' => array( 'class' => array() ) ) ),
        				the_title( '<span class="screen-reader-text">"', '"</span>', false )
        			) );

          		  	}
       			 }
            

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rara-journal' ),
				'after'  => '</div>',
				) );

				?>
		</div><!-- .entry-content -->

		<?php if( !is_single() ){ ?>
			
			<footer class="entry-footer"><!-- .entry-footer -->

				<?php rara_journal_entry_footer(); 
					 if( $read_more ){ ?> 
					 <div class="continue-btn">
					 	<span>
					 		  <a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html( $read_more ); ?></a>
					 	</span>
					 </div>
				<?php } ?>
			
			</footer>

		<?php } ?>

</article>


						