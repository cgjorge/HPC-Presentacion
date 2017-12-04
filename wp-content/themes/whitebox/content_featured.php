<?php
/**
 * To display the featured posts on the front-page
 * @package whitebox
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('featured'); ?>>
  <div class="featured-post clearfix">  
    <figure class="post-thumbnail">  
      <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>  
    </figure>  
    <div class="post-entry">  
      <h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>  
      <?php the_content(); ?>  
    </div>  
  </div>
	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'whitebox' ) );
			if ( $categories_list && whitebox_categorized_blog() ) :
		?>
		<span class="cat-links">
			<?php printf( __( 'Posted in %1$s', 'whitebox' ), $categories_list ); ?>
		</span>
		<?php endif; // End if categories ?>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'whitebox' ) );
			if ( $tags_list ) :
		?>
		<span class="tags-links">
			<?php printf( __( 'Tagged %1$s', 'whitebox' ), $tags_list ); ?>
		</span>
		<?php endif; // End if $tags_list ?>
		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'whitebox' ), __( '1 Comment', 'whitebox' ), __( '% Comments', 'whitebox' ) ); ?></span>
		<?php endif; ?>
		<?php edit_post_link( __( 'Edit', 'whitebox' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->

