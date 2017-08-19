<?php

/**
 * Register our user meta boxes.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class UserMetaBox {

	use Form;

	public function __construct() {

		add_action( 'personal_options_update',  array( $this, 'update' ) );
		add_action( 'edit_user_profile_update', array( $this, 'update' ) );

		add_action( 'show_user_profile', array( $this, 'show' ) );
		add_action( 'edit_user_profile', array( $this, 'show' ) );

		$this -> user_meta_fields = get_dp() -> user_meta_fields;
	
	}

	function show( $user ) {

		$user_id = $user -> ID;

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		$title = esc_html__( 'DraftPress Info', 'dp' );

		$values = $this -> user_meta_fields -> get_values( $user_id );

		//var_dump( $values, $user_id, get_user_meta( $user_id, FALSE, TRUE ) );

		$sections     = $this -> user_meta_fields -> get_fields();
		$settings_out = '';
		foreach( $sections as $section_id => $section ) {

			$settings = $section['settings'];

			foreach( $settings as $setting_id => $setting ) {

				$th = $setting['label'];

				// Grab the value for this setting.
				$value = FALSE;
					
				$value_key = "$section_id-$setting_id";

				$id = DRAFTPRESS . '-' . $value_key;

				if( isset( $values[ $value_key ] ) ) {
					$value = $values[ $value_key ];
				}

				if( isset( $values[ $value_key ] ) ) {
					$value = $values[ $value_key ];
				}

				if( empty( $value ) ) { 
					if( isset( $setting['default'] ) ) {
						$value = $setting['default'];
					}
				}

				// Grab the input for this setting.
				$td = $this -> get_field( $user_id, $value, $section_id, $setting_id, $setting, FALSE );

				$settings_out .= "
					<tr>
						<th>
							<label for='$id'>$th</label>
						</th>
						<td>$td</td>
					</tr>
				";

			}

		}

		$out = "
			<div class='$class'>
				<h2>$title</h2>
				<table class='$class form-table'>
					<tbody>
						$settings_out
					</tbody>
				</table>
			</div>
		";

		echo $out;

	}

	function update( $user_id ) {

		if( ! current_user_can( 'edit_user',$user_id ) ) { return FALSE; }
		
		if( ! isset( $_POST[ DRAFTPRESS ] ) ) {
			$posted_data = array();
		} else {
			$posted_data = $_POST[ DRAFTPRESS ];
		}

		$sections     = $this -> user_meta_fields -> get_fields();
		$settings_out = '';
		foreach( $sections as $section_id => $section ) {

			$settings = $section['settings'];

			foreach( $settings as $setting_id => $setting ) {

				$value_key = "$section_id-$setting_id";

				if( ! isset( $posted_data[ $value_key ] ) ) {

					$value = FALSE;

				} else {

					$value = $this -> sanitize( $posted_data[ $value_key ] );

				}

				update_user_meta( $user_id, $value_key, $value );

			}

		}

	} 

}