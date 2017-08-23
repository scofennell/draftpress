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

jQuery( document ).ready( function() {

	jQuery( '.DraftPressFields-get_draggable' ).dpSortable();
	
});

jQuery( document ).ready( function( $ ) {

	$.fn.dpSortable = function( options ) {

		// For each element to which our plugin is applied...
		return this.each( function() {

			// Save a reference to the input, so that we may safely use "this" later.
			var that = this;

			var parent = $( that ).parent();

			var dataHolder = $( parent ).find( '.DraftPressFields-get_draggable-hidden' );

			var prefix = $( dataHolder ).attr( 'id' );

			$( that ).sortable({
				placeholder: 'ui-state-highlight',
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

jQuery( document ).ready( function() {

	jQuery( '.DraftPress-toggle' ).dpToggle();
	
});

jQuery( document ).ready( function( $ ) {

	$.fn.dpToggle = function( options ) {

		// For each element to which our plugin is applied...
		return this.each( function() {

			// Save a reference to the input, so that we may safely use "this" later.
			var that = this;

			var handle = $( that ).find( '.DraftPress-toggle_handle' );

			var hidden = $( that ).find( '.DraftPress-toggled' );

			var arrow = $( handle ).find( '.dashicons' );

			$( hidden ).hide();

			$( handle ).on( 'click', function() {
				$( hidden ).fadeToggle();
				$( arrow ).toggleClass( 'dashicons-arrow-down dashicons-arrow-up' );
			});

			// Make our plugin chainable.
			return this;

		// End for each element to which our plugin is applied.
		});

	// End the definition of our plugin.
	};

}( jQuery ) );
