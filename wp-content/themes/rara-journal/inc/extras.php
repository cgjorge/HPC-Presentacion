<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Rara_Journal
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */

function rara_journal_body_classes( $classes ) {

	global $post;
    
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	
    // Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}
     
    if( !( is_active_sidebar( 'right-sidebar' ) ) ) {
        $classes[] = 'full-width'; 
    }
    
    if( is_single() ){
        $classes[] = 'post'; 
    }
    
    if( is_archive() ){
        $classes[] = 'category'; 
    }
    
    if( is_page() ){
        $sidebar_layout = rara_journal_sidebar_layout();
        if( $sidebar_layout == 'no-sidebar' )
        $classes[] = 'full-width';
    }
	return $classes;
}
add_filter( 'body_class', 'rara_journal_body_classes' );


/**
 * Archive Header Layout
 */
function rara_journal_archive_header_layout (){ ?>

	<?php if ( is_category() ) : ?>

		<div class="page-header">
			<div class="container">
				<h1 class="page-title"><?php foreach((get_the_category()) as $cat) { echo esc_html( $cat->cat_name . ' ' ); } ?></h1>
				<span><?php esc_html_e('Category','rara-journal'); ?></span>
			</div>
		</div>
	
	<?php elseif ( is_tag() ) : ?>
	
		<div class="page-header">
			<div class="container">
				<h1 class="page-title"><?php the_archive_title();?></h1>
				<span><?php esc_html_e('Tag','rara-journal'); ?></span>
			</div>
		</div>

	<?php elseif ( is_author() ) : ?>
	
		<div class="page-header">
			<div class="container">
				<h1 class="page-title"><?php the_author_posts_link(); ?></h1>
				<span><?php esc_html_e('Author','rara-journal'); ?></span>
			</div>
		</div>
	
	<?php else : ?>
	
		<div class="page-header">
			<div class="container">
				<h1 class="page-title"><?php echo trim(single_month_title(' ',false));?></h1>
				<span><?php esc_html_e('Archive','rara-journal'); ?></span>
			</div>
		</div>
    
    <?php endif; 
} 

add_action( 'rara_journal_archive_header', 'rara_journal_archive_header_layout' );


/**
 * Search header for Search page
*/
function rara_journal_search_header(){
    
    if( is_search() ){ 
        global $wp_query;    
    ?>
    <h2 class="page-title"><?php printf( esc_html__( 'Search Results', 'rara-journal' ), get_search_query() ); ?></h2>
    	<span>
    		<?php printf( esc_html__( '%s Results Found','rara-journal' ), $wp_query->found_posts ); ?>
    	</span>
    <?php
    }
}
add_action( 'rara_journal_header', 'rara_journal_search_header' );
 
 /**
 * 
 * @link http://www.altafweb.com/2011/12/remove-specific-tag-from-php-string.html
*/
function rara_journal_strip_single( $tag, $string ){
    $string=preg_replace('/<'.$tag.'[^>]*>/i', '', $string);
    $string=preg_replace('/<\/'.$tag.'>/i', '', $string);
    return $string;
}

/** 
 * Hook to move comment text field to the bottom in WP 4.4 
 *
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-move-comment-text-field-to-bottom-in-wordpress-4-4/  
 */
function rara_journal_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter( 'comment_form_fields', 'rara_journal_move_comment_field_to_bottom' );

/**
 * Callback function for Comment List *
 * 
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
 */
 
function rara_journal_theme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	
    <footer class="comment-meta">

        <div class="comment-author vcard">
            <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <?php printf( __( '<b class="fn"><a href="<?php get_the_author(); ?>">%s</a></b>', 'rara-journal' ), get_comment_author_link() ); ?>
        </div>
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'rara-journal' ); ?></em>
            <br />
        <?php endif; ?>
    
        <div class="comment-metadata commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_date(); ?>">
            <?php
                /* translators: 1: date, 2: time */
                echo esc_html( get_comment_date() ); ?></time></a><?php edit_comment_link( __( '(Edit)', 'rara-journal' ), '  ', '' );
            ?>
        </div>

    </footer>
    
    <div class="comment-content"><?php comment_text(); ?></div>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

/**
 * Call Back Function for Home page Slider
 */
function rara_journal_slider_cb(){
    $rarajournal_slider_caption = get_theme_mod( 'rara_journal_slider_caption', '1' );
    $rarajournal_slider_cat = get_theme_mod( 'rara_journal_slider_cat' );
    
    if( $rarajournal_slider_cat ){
        $slider_qry = new WP_Query( array( 
            'post_type'             => 'post', 
            'post_status'           => 'publish',
            'posts_per_page'        => -1,                    
            'cat'                   => $rarajournal_slider_cat,
            'ignore_sticky_posts'   => true
        ) );
        if( $slider_qry->have_posts() ){
            echo ' <div class="slider hidden" id="banner-slider"><ul id="lightSlider">';
            
            while( $slider_qry->have_posts()) {
                $slider_qry->the_post();
                if( has_post_thumbnail() ){
                ?>
    			<li>
                    <a href ="<?php the_permalink($slider_qry->ID); ?>" >
    				    <?php 
                        the_post_thumbnail( 'rara-journal-slider' ); ?>
                        <?php if($rarajournal_slider_caption){ ?>           
                    <div class="image-holder">
    					<p><?php the_title(); ?></p>
 				    </div>
                  <?php } ?> 
              </a>  
    			</li>
                <?php 
                }
            } 
            echo '</ul></div>';
            wp_reset_postdata(); 
        }
    }   
 }
 
 add_action( 'rara_journal_slider', 'rara_journal_slider_cb' );
 
 /**
  * Function for Social Icons 
  */
function rara_journal_social_link(){


    $rarajournal_button_url_fb = get_theme_mod( 'rara_journal_button_url_fb' );
    $rarajournal_button_url_tw = get_theme_mod( 'rara_journal_button_url_tw' );
    $rarajournal_button_url_ln = get_theme_mod( 'rara_journal_button_url_ln' );
    $rarajournal_button_url_rss = get_theme_mod( 'rara_journal_button_url_rss' );
    $rarajournal_button_url_gp = get_theme_mod( 'rara_journal_button_url_gp' );
    $rarajournal_button_url_pi = get_theme_mod( 'rara_journal_button_url_pin' );
    $rarajournal_button_url_yt = get_theme_mod( 'rara_journal_button_url_yt' );
    $rarajournal_button_url_ins = get_theme_mod( 'rara_journal_button_url_ins' );
    ?>
		<ul class="social-networks">
			 <?php if( $rarajournal_button_url_fb ){?>
			<li><a href="<?php echo esc_url( $rarajournal_button_url_fb ) ?>"><i class="fa fa-facebook"></i></a></li>
			<?php } if( $rarajournal_button_url_tw ){?>
			<li><a href="<?php echo esc_url( $rarajournal_button_url_tw ) ?>"><i class="fa fa-twitter"></i></a></li>
			<?php } if( $rarajournal_button_url_ln ){?>
			<li><a href="<?php echo esc_url( $rarajournal_button_url_ln ) ?>"><i class="fa fa-linkedin"></i></a></li>
			<?php } if( $rarajournal_button_url_rss ){?>
			<li><a href="<?php echo esc_url( $rarajournal_button_url_rss ) ?>"><i class="fa fa-rss"></i></a></li>
			<?php } if( $rarajournal_button_url_gp ){?>
			<li><a href="<?php echo esc_url( $rarajournal_button_url_gp ) ?>"><i class="fa fa-google-plus"></i></a></li>
			<?php } if( $rarajournal_button_url_yt ){?>
			<li><a href="<?php echo esc_url( $rarajournal_button_url_yt ) ?>"><i class="fa fa-youtube"></i></a></li>
			<?php } if( $rarajournal_button_url_pi ){?>
			<li><a href="<?php echo esc_url( $rarajournal_button_url_pi ) ?>"><i class="fa fa-pinterest-p"></i></a></li>
			<?php } if( $rarajournal_button_url_ins ){?>
			<li><a href="<?php echo esc_url( $rarajournal_button_url_ins ) ?>"><i class="fa fa-instagram"></i></a></li>
			<?php } ?>
			</ul>

 <?php 
} 

/**
 *Filter For Archive Title
 */

add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = get_the_author();
    }
    return $title;

});

if ( ! function_exists( 'rara_journal_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function rara_journal_excerpt_more() {
	return ' &hellip; ';
}
add_filter( 'excerpt_more', 'rara_journal_excerpt_more' );
endif;

if ( ! function_exists( 'rara_journal_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function rara_journal_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'rara_journal_excerpt_length', 999 );
endif;

/**
 * Return sidebar layouts for pages
*/
function rara_journal_sidebar_layout(){
    global $post;
    
    if( get_post_meta( $post->ID, 'rara_journal_sidebar_layout', true ) ){
        return esc_html( get_post_meta( $post->ID, 'rara_journal_sidebar_layout', true ) );    
    }else{
        return 'right-sidebar';
    }
}

/**
 * Footer Credits 
*/
function rara_journal_footer_credit(){
      
    $text  = '<div class="site-info"><div class="container"><p>';
    $text .= esc_html__( 'Copyright &copy; ', 'rara-journal' ) . date('Y'); 
    $text .= ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a> &verbar; ';
    $text .= '<a href="' . esc_url( 'http://raratheme.com/wordpress-themes/rara-journal/' ) .'" rel="author" target="_blank">' . esc_html__( 'Rara Journal by: Rara Theme', 'rara-journal' ) . '</a> &verbar; ';
    $text .= sprintf( esc_html__( 'Powered by: %s', 'rara-journal' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'rara-journal' ) ) .'" target="_blank">WordPress</a>' );
    $text .= '</p></div></div>';
    echo apply_filters( 'rara_journal_footer_text', $text );    
}
add_action( 'rara_journal_footer', 'rara_journal_footer_credit' );

/**
 * comment_form_default_fields
 */
add_filter( 'comment_form_default_fields', 'rara_journal_commentd_fields' );
function rara_journal_commentd_fields( $fields ) {
 
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><input id="author" name="author" placeholder="' . esc_attr__( 'Name*', 'rara-journal' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . ' />';
        
    $fields['email'] = '<p class="comment-form-email"><input id="email" name="email" placeholder="' . esc_attr__( 'Email*', 'rara-journal' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
        
    $fields['url'] = '<p class="comment-form-url"><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'rara-journal' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';
  
    return $fields;
     
}

/**
 * comment_form_defaults
 */
add_filter( 'comment_form_defaults', 'rara_journal_change_comment_form' );
function rara_journal_change_comment_form( $defaults ) {
 
    $defaults['label_submit'] = __( 'POST COMMENT', 'rara-journal' );

    $defaults['comment_field'] =  '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'rara-journal' ) . '" cols="45" rows="8" aria-required="true">' . '</textarea></p>';
     
    return $defaults;
}