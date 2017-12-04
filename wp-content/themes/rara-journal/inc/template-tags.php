<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Rara_Journal
 */

if ( ! function_exists( 'rara_journal_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function rara_journal_posted_on() {  
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	echo '<span class="byline"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span><span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' . '</span>'; // WPCS: XSS OK.
		// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( _x(', ', '', 'rara-journal' ) );
		if ( $categories_list && rara_journal_categorized_blog() ) {
          	printf( '<span class="category">%s </span>',
	           $categories_list
            );
		
		}

	} 
    
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'rara-journal' ), esc_html__( '1 Comment', 'rara-journal' ), esc_html__( '% Comments', 'rara-journal' ) );
		echo '</span>';
	}

}
endif;

if ( ! function_exists( 'rara_journal_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function rara_journal_entry_footer() {

	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', _x( ', ', '', 'rara-journal' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">%s</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link( esc_html__( 'Edit', 'rara-journal' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function rara_journal_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'rara_journal_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'rara_journal_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so rara_journal_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so rara_journal_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in rara_journal_categorized_blog.
 */
function rara_journal_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'rara_journal_categories' );
}
add_action( 'edit_category', 'rara_journal_category_transient_flusher' );
add_action( 'save_post',     'rara_journal_category_transient_flusher' );
