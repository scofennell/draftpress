<?php

/**
 * Register our user meta fields.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class UserMetaFields {

	public function __construct() {

		// Define our settings.
		$this -> set_fields();

	}

	/**
	 * Get the array that defines our plugin post meta fields.
	 * 
	 * @return array Our plugin post meta fields.
	 */
	function get_fields() {

		return $this -> fields;

	}

	/**
	 * Store our meta fields definitions.
	 */
	function set_fields() {

		$out = array(

			// The sections for this post type.
			'sections' => array(

				// A section.
				'rankings' => array(

					// The label for this section.
					'label' => esc_html__( 'Rankings Settings', 'dp' ),

					// The settings for this section.
					'settings' => array(

						'is_ranker' => array(
							'label'       => esc_html__( 'Is a ranker?', 'dp' ),
							'description' => esc_html__( 'Is this user a ranker?', 'dp' ),
						),

					),

				),

			),
			

		);

		$this -> fields = $out;

	}

	/**
	 * Get the values for our meta box.
	 * 
	 * @param  integer $user_id The ID of the user.
	 * @return array            A multidimensional array of values by setting and section.
	 */
	function get_values( $user_id ) {

		$out = array();

		$get_user_meta = get_user_meta( $post_id, FALSE, TRUE );

		foreach( $get_user_meta as $k => $v ) {

			if( count( $v == 1 ) ) 
			$out[ $k ] = $v[ 0 ]; 

		}

		return $out;

	}

	/**
	 * Get the value for a meta field.
	 * 
	 * @param  integer $user_id    The user ID.
	 * @param  string  $section_id The section ID.
	 * @param  string  $setting_id The setting ID.
	 * @return mixed               The user meta value from the DB.
	 */ 
	function get_value( $user_id, $section_id, $setting_id ) {

		$user = get_user( $user_id );
		$key = "$section_id-$setting_id";

		if( ! isset( $user -> $key ) ) { return FALSE; }

		return $user -> $key;

	}

}