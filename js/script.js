/**
 * Our plugin JS.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

/**
 * Some global vars we can use across our JS.
 * 
 * @type {Object}
 */
var DRAFTPRESS = {

	ns: 'DraftPress', 

	/**
	 * Determine if we are in wp-admin.
	 * 
	 * @return {Boolean} True if we are in wp-admin or not.
	 */
	isAdmin: function() {

		if( jQuery( 'body' ).hasClass( 'wp-admin' ) ) { return true; }

		return false;

	},		

};

/**
 * Our jQuery plugin for doing color pickers.
 */
jQuery( document ).ready( function() {

	// In our plugin settings page...
	jQuery( '.DraftPressFields-get_draggable' ).dpSortable();
	
});

jQuery( document ).ready( function( $ ) {

	/**
	 * Define our jQuery plugin for doing a color picker.
	 * 
	 * 
	 * @param  {array}  options An array of options to pass to our plugin.
	 * @return {object} Returns the item that the plugin was applied to, making it chainable.
	 */
	$.fn.dpSortable = function( options ) {

		// For each element to which our plugin is applied...
		return this.each( function() {

			// Save a reference to the input, so that we may safely use "this" later.
			var that = this;

			var parent = $( that ).parent();

			var dataHolder = $( that ).next( 'input' );

			var prefix = $( dataHolder ).attr( 'id' );

			$( that ).sortable({
				axis: 'y',
				containment: parent,
				scroll: false,
				stop: function( event, ui ) {



					var sorted = $( that ).sortable( 'toArray' );
					var array  = [];
					$.each( sorted, function( i, v ) {
						var unprefixed = v.replace( new RegExp( prefix + '-', 'g' ), '' );
						array.push( unprefixed );
					});
					
					console.log( array );

					$( dataHolder ).val( array );
				
				}
			
			});
		    $( that ).disableSelection();

			// Make our plugin chainable.
			return this;

		// End for each element to which our plugin is applied.
		});

	// End the definition of our plugin.
	};

}( jQuery ) );
