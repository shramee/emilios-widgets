/**
 * Plugin front end scripts
 *
 * @package Vimeo_LLMS
 * @version 1.0.0
 */
jQuery(function ($) {

	$( '.widget-title' ).click( function () {
		var $wid = $( this ).closest( '.widget' );
		$wid.find( '.llms-section, .wixbu-section' ).css( 'overflow', 'hidden' );
		$wid.toggleClass( 'wixbu-expanded' );
		setTimeout( function () {
			if ( $wid.hasClass( 'wixbu-expanded' ) ) {
				$wid.find( '.llms-section, .wixbu-section' ).css( 'overflow', 'auto' );
			}
		}, 500 );
	} );

});