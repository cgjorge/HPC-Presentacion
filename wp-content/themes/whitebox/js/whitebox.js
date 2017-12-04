/**
 * whitebox
 * 
 * makes nested menu-items visible if they point to the current page
 * Handles toggling the main navigation menu for small screens.
 * fix for focus in some browsers
 * keyboard navigation
 */

 jQuery(document).ready(function($) {
    jQuery('.main-navigation .current_page_item').parents().css('display', 'block');
	jQuery('.main-navigation .current-page-ancestor').addClass('current_page_item');
	jQuery('.main-navigation .current_page_item').siblings().css('display', 'block');
	jQuery('.main-navigation .current_page_item').css('display', 'block');
	jQuery('body').click(function() {
		jQuery('.current_page_item').parents().filter('.main-navigation ul ul').toggle();
	});
	
		const MINWIDTH = 800;
	var $masthead = $( '#masthead' ),
	timeout = false;

	$.fn.smallMenu = function() {
		$masthead.find( '#site-navigation' ).removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );
		$masthead.find( '#site-navigation h1' ).removeClass( 'assistive-text' ).addClass( 'menu-toggle' );
		$masthead.find( '.menu' ).hide();
		$( '.menu-toggle' ).unbind( 'click' ).click( function() {
			$masthead.find( '.menu' ).toggle();
			$( this ).toggleClass( 'toggled-on' );
		} );
	};

	// Check viewport width on first load.
	if ( $( window ).width() < MINWIDTH )
		$.fn.smallMenu();

	// Check viewport width when user resizes the browser window.
	$( window ).resize( function() {
		var browserWidth = $( window ).width();

		if ( false !== timeout )
			clearTimeout( timeout );

		timeout = setTimeout( function() {
			if ( browserWidth < MINWIDTH ) {
				$.fn.smallMenu();
			} 
			else {
				$masthead.find( '#site-navigation' ).removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
				$masthead.find( '#site-navigation h1' ).removeClass( 'menu-toggle' ).addClass( 'assistive-text' );
				$masthead.find( '.menu' ).removeAttr( 'style' );
			}
		}, 200 );
	} );

		var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && 'undefined' !== typeof( document.getElementById ) ) {
		var eventMethod = ( window.addEventListener ) ? 'addEventListener' : 'attachEvent';
		window[ eventMethod ]( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;

				element.focus();
			}
		}, false );
	}
	
	$( document ).keydown( function( e ) {
		var url = false;
		if ( e.which === 37 ) {  // Left arrow key code
			url = $( '.nav-previous a' ).attr( 'href' );
		}
		else if ( e.which === 39 ) {  // Right arrow key code
			url = $( '.nav-next a' ).attr( 'href' );
		}
	} );
});