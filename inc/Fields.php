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

	function get_array_as_select( array $array ) {

		$options = $this -> get_array_as_options( $array );

		$css_class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		$name = $this -> name;
		$id   = $this -> id;

		$out = "
			<select class='widefat $css_class' id='$id' name='$name'>
				$options
			</select>
		";

		return $out;

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

		$css_class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		$name = $this -> name;
		$id   = $this -> id;

		foreach( $array as $k => $v ) {
			$checked = checked( $this -> current_value, $k, FALSE );	
			$button_id = $id . '-' . $k;

			$k         = esc_attr( $k );
			$button_id = esc_attr( $button_id );			

			$out .= "
				<div class='$css_class-item'>
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

		$id   = $this -> id;
		$name = $this -> name;
		$current_value = esc_attr( $this -> current_value );

		if( ! is_array( $items ) ) { return FALSE; }

		foreach( $items as $k => $v ) {
			$k = esc_attr( $k );
			$v = $v;
			$out .= "<div class='$class-item' id='$id-$k'>$v</div>";
		}

		if( ! empty( $out ) ) {
			$out = "
				<input class='$class-hidden widefat' type='hidden' tab-index='-1' value='$current_value' id='$id' name='$name'>
				<div class='$class'>$out</div>
			";
		}

		return $out;

	}

	function get_multinumber( $items ) {

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		wp_enqueue_script( 'jquery-ui-sortable' );

		$out = '';

		$id   = $this -> id;
		$name = $this -> name;
		$current_value = esc_attr( $this -> current_value );

		if( ! is_array( $items ) ) { return FALSE; }

		foreach( $items as $k => $v ) {
			$k = esc_attr( $k );
			$v = $v;
			$out .= "<div class='$class-item' id='$id-$k'>$v</div>";
		}

		if( ! empty( $out ) ) {
			$out = "
				<input class='$class-hidden widefat' type='hidden' tab-index='-1' value='$current_value' id='$id' name='$name'>
				<div class='$class'>$out</div>
			";
		}

		return $out;

	}	

}