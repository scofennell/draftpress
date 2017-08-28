<?php

/**
 * Register our REST data.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class REST {

	public function __construct() {

		$this -> post_meta_fields = get_dp() -> post_meta_fields;
		$this -> meta_fields      = $this -> post_meta_fields -> get_fields();
		
		// Add our post types.
		add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );

	}

	function rest_api_init() {

		$object_type = 'post';

		$args = array(
			'single'       => TRUE,
			'show_in_rest' => TRUE,
		);

		$fields = $this -> meta_fields;

		foreach( $fields as $post_type_k => $post_type ) {

			$sections = $post_type['sections'];

			foreach( $sections as $section_k => $section ) {

				$settings = $section['settings'];

				foreach( $settings as $setting_k => $setting ) {

					register_meta( $object_type, $section_k . '-' . $setting_k, $args );	

				}

			}
		
		}

	}

}