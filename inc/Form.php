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

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		// The label for this setting.
		$setting_label = $setting['label'];

		// The description for this setting.
		$setting_description = '';
		if( isset( $setting['description'] ) ) {
			$setting_description = '<p class="howto">' . $setting['description'] . '</p>';
		}
		
		$choices = array();
		if( isset( $setting['choices'] ) ) {
			$choices = $this -> parse_callable( $setting['choices'] );
		}

		$items = array();
		if( isset( $setting['items'] ) ) {
			$items = $setting['items'];
		}		

		// Namespace the ID for this setting.
		$id = DRAFTPRESS . '-' . $section_id . '-' . $setting_id;

		// Name the setting so it will be saved as an array.
		$name = DRAFTPRESS . '[' . $section_id . '-' . $setting_id . ']';

		$atts ='';
		if( isset( $setting['atts'] ) ) {
			$atts = $this -> get_attrs_from_array( $setting['atts'] );
		}

		$label = '';
		if( $use_label ) {
			$label = "<label class='$class-label' for='$id'>$setting_label</label>";
		}

		// The type of input.
		$type = 'text';
		if( isset( $setting['type'] ) ) {
			$type = esc_attr( $setting['type'] );
		}

		if( $type == 'select' ) {

			$fields = new Fields( $value, $id, $name );
			$select = $fields -> get_array_as_select( $choices );

			// Wrap the input.
			$input = "
				<div>$setting_label</div>
				$select
			";

		} elseif( $type == 'checkboxes' ) {

			$fields     = new Fields( $value, $id, $name );
			$checkboxes = $fields -> get_array_as_checkboxes( $choices);

			// Wrap the input.
			$input = "
				<div>$setting_label</div>
				$checkboxes
			";

		} elseif( $type == 'radio' ) {

			$fields = new Fields( $value, $id, $name );
			$radios = $fields -> get_array_as_radios( $choices );

			// Wrap the input.
			$input = "
				<div>$setting_label</div>
				$radios
			";

		} elseif( $type == 'checkbox' ) {

			$checked = checked( $value, 1, FALSE );

			// Wrap the input.
			$input = "
				<div class='$class-$type-wrapper'>
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

		} elseif( $type == 'multinumber' ) {

			$value = esc_attr( $value );

			$fields = new Fields( $value, $id, $name );

			$multinumber = '';
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
				
				$multinumber = $fields -> get_multinumber( $items_arr );

			}

			$toggle        = DRAFTPRESS . '-toggle';
			$toggle_handle = DRAFTPRESS . '-toggle_handle';
			$toggled       = DRAFTPRESS . '-toggled';
			$toggle_icon   = '<span class="dashicons dashicons-arrow-down"></span>';

			// Wrap the input.
			$input = "
				<div class='$toggle'>
					<div class='$toggle_handle'>$toggle_icon$label</div>
					<div class='$toggled'>$multinumber</div>
				</div>
			";

		} elseif( $type == 'draggable' ) {

			$value = esc_attr( $value );

			$fields = new Fields( $value, $id, $name );

			$draggable = '';
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

			$toggle        = DRAFTPRESS . '-toggle';
			$toggle_handle = DRAFTPRESS . '-toggle_handle';
			$toggled       = DRAFTPRESS . '-toggled';
			$toggle_icon   = '<span class="dashicons dashicons-arrow-down"></span>';

			// Wrap the input.
			$input = "
				<div class='$toggle'>
					<div class='$toggle_handle'>$toggle_icon$label</div>
					<div class='$toggled'>$draggable</div>
				</div>
			";

		} else {

			// Wrap the input.
			$input = "
				<div>$label</div>
				<input class='widefat' $atts type='$type' id='$id' name='$name' value='$value'>
			";

		}

		$out = "

			<div class='$class-$type $class' id='$id-wrap'>
				$input
				$setting_description
			</div>

		";

		return $out;

	}

	function parse_callable( $var ) {

		if( ! is_array( $var ) ) { return $var; }
		$count = count( $var );
		if( $count != 2 ) { return $var; }

		if( ! isset( $var[0] ) ) { return $var; }

		$class = __NAMESPACE__ . '\\' . $var[0];
		if( ! class_exists( $class ) ) { return $var; }

		$obj = new $class;

		$method = $var[1];
		
		$out = call_user_func( array( $obj, $method ) );
		
		return $out;

	}

}