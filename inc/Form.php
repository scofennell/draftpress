<?php

/**
 * A trait for common form tasks.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

trait Form {

	function sanitize( $dirty = array() ) {

		// Will hold cleaned values.
		$clean = array();

		if( ! is_array( $dirty ) ) { return wp_kses_post( $dirty ); }

		// For each section of settings...
		foreach( $dirty as $k => $v ) {

			$clean[ $k ] = $this -> sanitize( $v );
	
		}

		return $clean;

	}

	/**
	 * Convert an associative array into html attributes.
	 * 
	 * @param  array $array An associative array.
	 * @return string       HTML attributes.
	 */
	function get_attrs_from_array( $array ) {

		$out = '';

		foreach( $array as $k => $v ) {

			$k = sanitize_key( $k );
			$v = esc_attr( $v );

			$out .= " $k='$v' ";

		}

		return $out;

	}

	/**
	 * Determine if any setting dependencies are unmet.
	 * 
	 * @param  array  $dependencies An array of callbacks.
	 * @return mixed  Returns TRUE if dependencies are met, else WP Error.
	 */
	function parse_dependencies( array $dependencies ) {
		
		// Lets' assume the best.
		$out = TRUE;

		// Will hold any failed dependencies.
		$failed_deps = array();

		// For each dependency...
		foreach( $dependencies as $dep ) {

			// Grab the object and method.
			$dep_class  = __NAMESPACE__ . '\\' . $dep[0];
			$dep_obj    = new $dep_class;
			$dep_method = $dep[1];
		
			// Call the mthod and assess the result.
			$dep_result = call_user_func( array( $dep_obj, $dep_method ) );
			if( is_wp_error( $dep_result ) ) {
				$failed_deps[]= $dep_result;
			}

		}

		// Any failures?
		$failed_deps_count = count( $failed_deps );
		if( ! empty( $failed_deps_count ) ) {
			return new \WP_Error( 'setting_dependencies', 'This setting cannot be displayed.', $failed_deps );
		}

		return $out;

	}	

}