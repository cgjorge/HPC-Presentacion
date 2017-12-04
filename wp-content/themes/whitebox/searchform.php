<?php
/**
 * The template for displaying search forms in whitebox
 *
 * @package whitebox
 */
?>
<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'whitebox' ); ?></span>
		<input class="search-field" type="search" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'whitebox' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'whitebox' ); ?>">
	</label>
	<input class="search-submit" type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'whitebox' ); ?>">
</form>
