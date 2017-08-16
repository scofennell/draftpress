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

			var dataHolder = $( that ).next( 'input' );

			$( that ).sortable({
				axis: 'y',
				containment: that,
				scroll: false,
				change: function( event, ui ) {
					var sorted = $( that ).sortable( 'toArray' );
					$( dataHolder ).val( sorted );
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


/**
 * A jQuery plugin for doing a sticky nav.
 */
jQuery( document ).ready( function() {

	var el = jQuery( '.stickified' );

	jQuery( el ).cmStickify();

});

( function ( $ ) {

	$.fn.cmStickify = function( options ) {

		return this.each( function() {

			var that = this;

			var navOffset = $( that ).offset();
			var navOffsetTop = navOffset.top;

			var initScrollPos = 0;

			$( window ).scroll( function() {
				
				var navHeight = $( that ).outerHeight();

				var scrollTop = $( window ).scrollTop();

				var scrollPast = navOffsetTop;

				function stick() {
					$( that ).addClass( 'stickified-fixed' );
					$( that ).removeClass( 'stickified-not_fixed' );
					$( 'body' ).css( 'marginTop', navHeight );
				}

				function unstick() {

					$( that ).addClass( 'stickified-not_fixed' );
					
					setTimeout( function(){
						$( that ).removeClass( 'stickified-fixed' );
						$( 'body' ).css( 'marginTop', 0 );
					}, 250 );

				}

				if ( scrollTop > scrollPast ) {

					$( 'body' ).addClass( 'scrolled_past_header' );
					$( 'body' ).removeClass( 'not_scrolled_past_header' );
					stick();

				} else {
				
					$( 'body' ).removeClass( 'scrolled_past_header' );
					$( 'body' ).addClass( 'not_scrolled_past_header' );
					unstick();

				}
			
			});

		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for doing a toggle.
 */
jQuery( document ).ready( function() {

	var el = jQuery( '.toggle' );

	jQuery( el ).cmToggle();

});

( function ( $ ) {

	$.fn.cmToggle = function( options ) {

		return this.each( function() {

			var that = this;

			var handle = $( that ).find( '.toggle-handle' );

			var target = $( that ).find( '.toggle-target' );		

			$( target ).hide();

			$( handle ).click( function( event ) {
				
				event.preventDefault();

				$( target ).fadeToggle( 250, function() {

					if( $( target ).is( ':visible' ) ) {

						$( this ).trigger( 'toggleOpened' );

					} else {

						$( this ).trigger( 'toggleClosed' );
					
					}

					$( this ).trigger( 'toggleComplete' );

				});

				CM.flipIcon( this );

			});

			$( document ).on( 'hamburgerClosed', function() {
				$( target ).hide();
				CM.closeIcon( handle );
			});

		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for doing a toggle.
 */
jQuery( document ).ready( function() {

	var el = jQuery( '.mobile_toggle' );

	jQuery( el ).cmMobileToggle();

});

( function ( $ ) {

	$.fn.cmMobileToggle = function( options ) {

		return this.each( function() {

			var timeout = false;

			var that = this;

			var handle = $( that ).find( '.mobile_toggle-handle' );

			var target = $( that ).find( '.mobile_toggle-target' );	

			var icon = $( handle ).find( '.fa' );

			if( CM.isNarrow() ) {
				$( target ).hide();
			} else {
				$( icon ).hide();
			}
			
			$( handle ).click( function( event ) {
				
				event.preventDefault();

				if( ! CM.isNarrow() ) {
					return false;
				}
				
				$( target ).slideToggle( 250, function() {

					if( $( target ).is( ':visible' ) ) {
						
					} else {
						
					}

				});

				CM.flipIcon( this );

			});

			function reset() {

				if( CM.isNarrow() ) {
					$( icon ).show();
					$( target ).hide();
					CM.closeIcon( handle );
				} else {
					$( icon ).hide();
					$( target ).show();
				}

			}

			// On window resize...
			window.addEventListener( 'resize', function() {
			
				// Clear the timeout.
				clearTimeout( timeout );
				
				// Once we're done resizing, reset the element.
				timeout = setTimeout( reset, 100 );
			
			});


		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for doing an overlay.
 */
jQuery( document ).ready( function() {

	var el = jQuery( '.overlay' );

	jQuery( el ).cmOverlay();

});

( function ( $ ) {

	$.fn.cmOverlay = function( options ) {

		return this.each( function() {

			var that = this;
			$( that ).hide().appendTo( 'body' );

			var controllerSel = $( that ).data( 'controller' );
			var controller = $( '.' + controllerSel );

			var closerSel = $( that ).data( 'closer' );
			var closer = $( '.' + closerSel );

			$( controller ).on( 'click', function( event ) {

				event.preventDefault();

				$( that ).fadeIn( 250 );

				$( that ).find( 'input' ).first().focus();

			});

			$( document ).on( 'keydown', function ( event ) {
				if ( event.keyCode === 27 ) { // ESC
					
					$( that ).fadeOut( 250 );
				
					$( controller ).focus();

				}
			});

			$( closer ).on( 'click', function ( event ) {

				event.preventDefault();

				$( that ).fadeOut( 250 );

				$( controller ).focus();

			});		

		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for adding CSS classes to stuff.
 */
jQuery( document ).ready( function() {

	jQuery( 'html' ).cmClasser();

});

( function ( $ ) {

	$.fn.cmClasser = function( options ) {

		return this.each( function() {

			var that = this;

			var products = $( '.widget_products' );
			var productsParent = $( products ).closest( '.widget_area' );
			var productsPrev = $( productsParent ).prev().addClass( 'before_products' );

			var ad = $( '.widget_ad' );
			var adParent = $( ad ).closest( '.widget_area' );
			var adPrev = $( adParent ).prev().addClass( 'before_ad' );	


			var stealsSidebar = $( '.widget_area-steals_content_2' );
			var stealsSidebarPrev = $( stealsSidebar ).prev().addClass( 'before_steals_sidebar' );			

		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for show/hiding popular posts.
 */
jQuery( document ).ready( function() {

	jQuery( '.Widget_Popular-get_items' ).cmPopulars();

});

( function ( $ ) {

	$.fn.cmPopulars = function( options ) {

		return this.each( function() {

			var that = this;

			var perPage        = $( that ).data( 'per_page' );		
			var pages          = $( that ).data( 'pages' );
			var page           = $( that ).data( 'page' );	
			
			var items = $( that ).find( '.Widget_Popular-get_items-item' ).hide();

			var controller = $( '[data-controls="' + 'Widget_Popular-get_items' + '"]' );

			var start   = 0;
			var end     = start + perPage;
			var showers = $( items ).slice( start, end );

			$( showers ).fadeIn( 250, function() {});

			page++;
			
			$( controller ).on( 'click', function( event ) {

				event.preventDefault();

				var start   = perPage * page;
				var end     = start + perPage;
				var showers = $( items ).slice( start, end );

				$( showers ).fadeIn( 250, function() {});

				page++;

				if( page == pages ) {
					
					var moreWarapper = $( this ).closest( '.Widget_Popular-get_items-more-outer' ).fadeOut( 250 ).remove();
					$( this ).fadeOut( 250 ).remove();

				}

			});

		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for doing a hamburger.
 */
jQuery( document ).ready( function() {

	var el = jQuery( '.widget_hamburger' );

	jQuery( el ).cmHamburger();

});

( function ( $ ) {

	$.fn.cmHamburger = function( options ) {

		return this.each( function() {

			var that = this;

			var handle = $( that ).find( '.Widget_Hamburger-widget-burger' );

			var target = $( that ).find( '.Widget_Hamburger-get_content' );

			var closer = $( that ).find( '.Widget_Hamburger-get_content-closer' );

			// Will hold a timeout to help debounce our window resize function.
			var timeout = false;
	
			function reset() {

				if( ! CM.isNarrow() ) {
					closeTarget();
				}

				if( ! $( target ).is( ':visible' ) ) {

					tooTallify();
					scrollify();

				}

			}

			function openTarget() {
				//$( target ).fadeIn( 250 );

				$( target ).addClass( 'show' );
				$( target ).removeClass( 'hide' );
				tooTallify();
				scrollify();
				$( that ).trigger( 'hamburgerOpen' );
			}

			function closeTarget() {

				//$( target ).fadeOut( 250 );
				$( target ).addClass( 'hide' );
				$( target ).removeClass( 'show' );

				$( handle ).focus();
				$( that ).trigger( 'hamburgerClosed' );

				var origScroll = $( 'body' ).attr( 'data-origScroll' );
				if( origScroll != 0 ) {
					CM.scrollPageTo( origScroll );
				}
		
			}

			function tooTallify() {

				if( ! $( target ).is( ':visible' ) ) { return; }

				var windowHeight = $( window ).height();

				var targetHeight = $( target )[0].scrollHeight;
				
				if( targetHeight > windowHeight ) {
				
					$( target ).addClass( 'taller_than_window' );
					
				} else {
				
					$( target ).removeClass( 'taller_than_window' );			
				
				}

			}

			function scrollify() {

				if( ! $( target ).is( ':visible' ) ) { return; }

				var windowHeight = $( window ).height();

				var targetHeight = $( target )[0].scrollHeight;
				
				if( targetHeight > windowHeight ) {
				
					var origScroll = $( window ).scrollTop();
					$( 'body' ).attr( 'data-origScroll', origScroll );
					CM.scrollPageTo( 0 );
				
				} else {
				
					$( 'body' ).attr( 'data-origScroll', 0 );			
				
				}

			}

			$( target ).appendTo( 'body' ).removeClass( 'loading' );

			$( document ).on( 'toggleOpened', function() {
				tooTallify();
				scrollify();
			});

			$( document ).on( 'toggleClosed', function() {
				tooTallify();
			});


			$( handle ).click( function( event ) {
				event.preventDefault();
				openTarget();
			});

			$( closer ).click( function( event ) {
				event.preventDefault();
				closeTarget();
			});			

			$( document ).on( 'keydown', function ( e ) {
				
				if ( e.keyCode === 27 ) { // ESC

					closeTarget();

				}
			
			});

			// On window resize...
			window.addEventListener( 'resize', function() {
			
				// Clear the timeout.
				clearTimeout( timeout );
				
				// Once we're done resizing, reset the element.
				timeout = setTimeout( reset, 100 );
			
			});

		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for detecting touch screens.
 */
jQuery( document ).ready( function() {

	var el = jQuery( 'body' );

	jQuery( el ).cmTouch();

});

( function ( $ ) {

	$.fn.cmTouch = function( options ) {

		return this.each( function() {

			var that = this;

			$.fn.onFirstTouch = function( options ) {

				window.addEventListener('touchstart', function onFirstTouch() {
				
					$( that ).addClass( 'is_touch_screen' );

					// We only need to know once that a human touched the screen, so we can stop listening now.
					window.removeEventListener( 'touchstart', onFirstTouch, false );

				}, false );

			};

		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for complaining about products.
 */
jQuery( document ).ready( function() {

	var el = jQuery( '.Shortcode_Gifts-get_edit_form-overlay' );
	
	jQuery( el ).cmComplain();
  	
});

( function ( $ ) {
	
	$.fn.cmComplain = function( options ) {

		return this.each( function() {
			
			// Set a reference to this because JS is weird.
			var that = this;

			var form = $( that ).find( '.Shortcode_Gifts-get_edit_form' );
			
			var formTitle = $( that ).find( '.Shortcode_Gifts-get_edit_form-title' );

			var controllerSel = $( that ).data( 'controller' );
			var controller = $( '.' + controllerSel );

			var closerSel = $( that ).data( 'closer' );
			var closer = $( '.' + closerSel );

			var postIdInput = $( form ).find( '.Shortcode_Gifts-get_edit_form-id' );

			$( controller ).on( 'click', function( event ) {

				var productLink = this;
				var product = $( productLink ).closest( '.Shortcode_Gifts-get-gift' );

				var img = $( product ).find( '.Template_Tags-get_the_featured_image' );
				if( $( img ).length > 0 ) {
					img = $( img ).get(0).outerHTML;
				} else {
					img = '';
				}

				var title = $( product ).find( '.Shortcode_Gifts-get-gift-title' ).clone().html();

				var imgHtml = $( img ).html();
				var titleHtml = $( title ).html();			

				var preview = $( '<div />' ).addClass( 'preview' ).append( img + title );


				$( preview ).insertAfter( formTitle );

				var postId = $( product ).data( 'product_id' );
				$( postIdInput ).val( postId );

			});

			$( closer ).on( 'click', function( event ) {

				event.preventDefault();

				var preview = $( that ).find( '.preview' );
				$( preview ).remove();

			});

			$( document ).on( 'keydown', function ( event ) {
				if ( event.keyCode === 27 ) {
					
					var preview = $( that ).find( '.preview' );
					$( preview ).remove();

				}
			});



		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for doing a featured images input.
 */
jQuery( document ).ready( function() {

	var el = jQuery( '#cm-content-featured_images-wrap' );
	
	jQuery( el ).featuredImagesInput();
  	
});

( function ( $ ) {
	
	$.fn.featuredImagesInput = function( options ) {

		return this.each( function() {
			
			// Set a reference to this because JS is weird.
			var that = this;

			var wrappers = $( that ).find( '.featured_images_inputs' );

			var hidden = $( that ).find( '#cm-content-featured_images' );
			
			$( wrappers ).each( function( wrapper ) {

				var inputs = $( this ).find( '.featured_images_radio' ).addClass( 'screen-reader-text' );
				var labels = $( this ).find( '.featured_images_input_label' );

			});

		});

	};

}( jQuery ) );

/**
 * A jQuery plugin for doing a slider images input.
 */
jQuery( document ).ready( function() {

	var el = jQuery( '#cm-content-slider_images-wrap' );
	
	jQuery( el ).cmSliderImages();
  	
});

( function ( $ ) {
	
	$.fn.cmSliderImages = function( options ) {

		return this.each( function() {
			
			// Set a reference to this because JS is weird.
			var that = this;

			var wrappers = $( that ).find( '.slider_images_slide' );

			var hidden = $( that ).find( '#cm-content-slider_images' );
			
			var cloner = $( that ).find( '.add_new' );
			var clonerLink = $( cloner ).find( 'a' );

			var first = $( that ).find( '.slider_images_slide' ).first();

			$( 'body' ).on( 'click', '.remove a', function( event ) {

				event.preventDefault();
				var parent = $( this ).closest( '.slider_images_slide_remove' );
				$( parent ).fadeOut( 300, function() { $( this ).remove(); });

				console.log( parent );



				//	$( parent ).remove();
			});


			$( clonerLink ).on( 'click', function( event ) {

				event.preventDefault();
				
				var newSlide = $( first ).clone().hide();
				newSlide = reIndex( newSlide );
				$( newSlide ).insertAfter( cloner ).slideDown();

			});

			$( wrappers ).each( function( wrapper ) {

				var inputs = $( this ).find( '.slider_images_radio' ).addClass( 'screen-reader-text' );
				var labels = $( this ).find( '.slider_images_input_label' );

			});

			function reIndex( newSlide ) {

				var wrappers = $( that ).find( '.slider_images_slide' );

				var count = wrappers.length;
				
				var inputs = $( newSlide ).find( 'input' );
				var labels = $( newSlide ).find( 'label' );

				$( inputs ).each( function() {

					var baseName = $( this ).data( 'base_name' );
					var baseID = $( this ).data( 'base_id' );

					var baseIDArr = baseID.split( '-' );
					var imgID     = baseIDArr.splice(-1,1);
					var size      = baseIDArr.splice(-1,1);
					var prefix    = baseIDArr.splice(-1,1);
					var newIDArr  = [ prefix, count, size, imgID ];
					var newID     = newIDArr.join( '-' );

					var baseNameArr = [];
					var pattern = /\[(.*?)\]/g;
					var match;
					while ((match = pattern.exec(baseName)) != null) {
						baseNameArr.push(match[1]);
					}

					var size = baseNameArr.splice( -1, 1 );
					var oldCount = baseNameArr.splice( -1, 1 );
					baseNameArr.push( count );
					baseNameArr.push( size );

					var newName = 'cm[' + baseNameArr.join( '][' ) + ']';
					
					$( this ).attr( 'name', newName );
					$( this ).attr( 'id', newID );

				});

				$( labels ).each( function() {
					
					var baseID = $( this ).data( 'base_id' );

					var baseIDArr = baseID.split( '-' );
					var imgID     = baseIDArr.splice(-1,1);
					var size      = baseIDArr.splice(-1,1);
					var prefix    = baseIDArr.splice(-1,1);
					var newIDArr  = [ prefix, count, size, imgID ];
					var newID     = newIDArr.join( '-' );

					$( this ).attr( 'for', newID );

				});					

				return newSlide;

			}

		});

	};

}( jQuery ) );


/**
 * A jQuery plugin for doing a fitVid.
 */
jQuery( document ).ready( function() {

	var el = jQuery( '.video .post-banner' );
	
	jQuery( el ).cmFitVids();
  	
});

( function ( $ ) {
	
	$.fn.cmFitVids = function( options ) {

		return this.each( function() {
			
			var that = this;

			$( that ).fitVids();

		});

	};

}( jQuery ) );
