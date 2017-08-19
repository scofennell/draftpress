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

	function show( $user_id ) {

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		$title = esc_html__( 'DraftPress Info', 'dp' );

		$values = $this -> user_meta_fields -> get_values( $user_id );

		$sections     = $this -> user_meta_fields -> get_fields();
		$settings_out = '';
		foreach( $sections as $section_id => $section ) {

			$settings = $section['settings'];

			foreach( $settings as $setting_id => $setting ) {

				$th = $setting['label'];

				// Grab the value for this setting.
				$value = FALSE;
					
				$value_key = "$section_id-$setting_id";

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
				$td = $this -> get_field( $user_id, $value, $section_id, $setting_id, $setting );

				$settings_out .= "
					<tr>
						<th>
							<label>$th</label>
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

	function update() {
		
	} 

}