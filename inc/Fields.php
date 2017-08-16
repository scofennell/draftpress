<?php

/**
 * A class for building form fields.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Fields {

	/**
	 * Set up our class variables.
	 * 
	 * @param boolean $current_value The current value of the setting for which we're building a field.
	 */
	function __construct( $current_value = FALSE, $id = '', $name = '' ) {

		$this -> current_value = $current_value;
		$this -> id            = $id;
		$this -> name          = $name;				
		
	}

	/**
	 * Convert as associative array to select options.
	 * 
	 * @param  array  $array An associative array.
	 * @return string        Select options.
	 */
	function get_array_as_options( array $array ) {

		$out = '';

		foreach( $array as $k => $v ) {

			$selected = selected( $this -> current_value, $k, FALSE );

			$k = esc_attr( $k );
			$v = esc_html( $v );

			$out .= "<option value='$k' $selected>$v</option>";

		}

		return $out;

	}

	function get_array_as_radios( array $array ) {

		$out = '';

		$name = $this -> name;
		$id   = $this -> id;

		if( class_exists( __NAMESPACE__ . '\\' . $array[0] ) ) {

			$class  = __NAMESPACE__ . '\\' . $array[0];
			$object = new $class;
			$method = $array[1];
			$array  = call_user_func( array( $object, $method ) );
		}

		foreach( $array as $k => $v ) {
			$checked = checked( $this -> current_value, $k, FALSE );	
			$button_id = $id . '-' . $k;

			$k         = esc_attr( $k );
			$button_id = esc_attr( $button_id );			
			$v         = esc_html( $v );

			$out .= "
				<div>
					<input $checked id='$button_id' type='radio' value='$k' name='$name'>
					<label for='$button_id'>$v</label>
				</div>
			";
		
		}

		return $out;

	}

	function get_draggable( $items ) {

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		wp_enqueue_script( 'jquery-ui-sortable' );

		$out = '';

		foreach( $items as $k => $v ) {
			$out .= "<li>$k $v</li>";
		}

		if( ! empty( $out ) ) {
			$out = "<ul class='$class'>$out</ul>";
		}

		return $out;

	}

}