/**
 * Plugin front end scripts
 *
 * @package My_Plugin
 * @version 1.0.0
 */
jQuery(function ($) {

	$( '.widget-title' ).click( function () {
		var $t = $( this );
		$t.closest( '.widget' ).toggleClass( 'wixbu-expanded' );
	} );

});