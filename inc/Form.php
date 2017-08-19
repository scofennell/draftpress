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

	/**
	 * Get an HTML input for a meta field.
	 * 
	 * @param  string $post_id    The post ID.
	 * @param  string $value      The database value for this input.
	 * @param  string $section_id The ID for the section that this setting is in.
	 * @param  string $setting_id The ID for this setting.
	 * @param  string $setting    The definition of this setting.
	 * @return string             An HTML input for a meta field.
	 */
	function get_field( $post_id, $value, $section_id, $setting_id, $setting, $use_label = TRUE ) {

		$out = '';

		// The label for this setting.
		$setting_label = $setting['label'];

		// The description for this setting.
		$setting_description = '';
		if( isset( $setting['description'] ) ) {
			$setting_description = '<p class="howto">' . $setting['description'] . '</p>';
		}
		
		// Namespace the ID for this setting.
		$id = DRAFTPRESS . '-' . $section_id . '-' . $setting_id;

		// Name the setting so it will be saved as an array.
		$name = DRAFTPRESS . '[' . $section_id . '-' . $setting_id . ']';

		$label = '';
		if( $use_label ) {
			$label = "<div><label for='$id'>$setting_label</label></div>";
		}

		// The type of input.
		$type = 'text';
		if( isset( $setting['type'] ) ) {
			$type = esc_attr( $setting['type'] );
		}

		if( $type == 'checkboxes' ) {

			$fields     = new Fields( $value, $id, $name );
			$checkboxes = $fields -> get_array_as_checkboxes( $setting['choices'] );

			// Wrap the input.
			$input = "
				<div>$setting_label</div>
				$checkboxes
			";

		} elseif( $type == 'radio' ) {

			$fields = new Fields( $value, $id, $name );
			$radios = $fields -> get_array_as_radios( $setting['choices'] );

			// Wrap the input.
			$input = "
				<div>$setting_label</div>
				$radios
			";

		} elseif( $type == 'checkbox' ) {

			$checked = checked( $value, 1, FALSE );

			// Wrap the input.
			$input = "
				<div>
					<input $checked type='$type' id='$id' name='$name' value='1'>
					$label
				</div>
			";

		} elseif( $type == 'textarea' ) {

			$value = esc_textarea( $value );

			// Wrap the input.
			$input = "
				$label
				<textarea class='widefat' id='$id' name='$name'>$value</textarea>
			";

		} elseif( $type == 'draggable' ) {

			$value = esc_attr( $value );

			$fields = new Fields( $value, $id, $name );

			$items = $setting['items'];
			$draggable = '';
			if( is_array( $items ) ) {
				$count = count( $items );
				if( $count == 2 ) {

					$items_class = __NAMESPACE__ . '\\' . $items[0];

					if( class_exists( $items_class ) ) {
						
						$items_method = $items[1];
						$items_obj = new $items_class;
						$order_arr = explode( ',', $value );
						$order_clean = array();
						foreach( $order_arr as $item ) {
							$order_clean[ $item ] = NULL;
						}
						
						$items_arr = call_user_func( array( $items_obj, $items_method ), $order_clean );
						
						$draggable = $fields -> get_draggable( $items_arr );

					}
				}
			}

			// Wrap the input.
			$input = "
				$label
				$draggable
			";

		} else {

			// Wrap the input.
			$input = "
				$label
				<input class='regular-text' type='$type' id='$id' name='$name' value='$value'>
			";

		}

		$out = "

			<div id='$id-wrap'>
				$input
				$setting_description
			</div>

		";

		return $out;

	}	

}