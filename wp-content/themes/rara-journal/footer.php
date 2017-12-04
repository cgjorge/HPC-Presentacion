<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
*
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Rara_Journal
 */

			
	 		if ( ! ( is_home() || is_search() ) ){ 
				echo '</div>'; // .container
	 		} 
            

            if( ! is_404() ) {  
                echo '</div>';  // .row
            } 
        ?>
	
		</div> <!-- #content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
        	<?php if( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) || is_active_sidebar( 'footer-four' ) ){ ?>
      			<div class="widget-area">
					<div class="container">
						<div class="row">
    
                         	<?php if( is_active_sidebar( 'footer-one' ) ){ ?>
        						<div class="column">
    	   				   		   <?php dynamic_sidebar( 'footer-one' ); ?>	
    						    </div>                    	
                            <?php } ?>

                    	    <?php if( is_active_sidebar( 'footer-two' ) ){ ?>
    					        <div class="column">
    					           <?php dynamic_sidebar( 'footer-two' ); ?>	
    					        </div>
                    	    <?php } ?>

                    	    <?php if( is_active_sidebar( 'footer-three' ) ){ ?>
    					        <div class="column">
    					            <?php dynamic_sidebar( 'footer-three' ); ?>	
    					        </div>
                    	    <?php } ?>

                    	    <?php if( is_active_sidebar( 'footer-four' ) ){ ?>
    					        <div class="column">
    					            <?php dynamic_sidebar( 'footer-four' ); ?>	
    					        </div>
                    	    <?php } ?>
   
						</div>
					</div>
				</div>
       		<?php } 
            
            	/**
            	 * @hooked rara_journal_footer_credit
            	*/
            	do_action( 'rara_journal_footer' );
        
        	?>	
		</footer>
	</div>	<!-- #page -->		
    <?php wp_footer(); ?>
	</body>
</html>