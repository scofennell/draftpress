<?php

/**
 * Register our post meta fields.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class PostMetaFields {

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

			// A post type.
			'players' => array(

				// The label for this post type.
				'label' => esc_html__( 'Player Data', 'dp' ),

				// The sections for this post type.
				'sections' => array(

					// A section.
					'meta' => array(

						// The label for this section.
						'label' => esc_html__( 'Meta for This Player', 'dp' ),

						// The settings for this section.
						'settings' => array(

							'team' => array(
								'type'        => 'radio',
								'label'       => esc_html__( 'Team', 'dp' ),
								'description' => esc_html__( 'The NFL team for which this player plays.', 'dp' ),
								'choices'     => array( 'Teams', 'get_as_kv' ),
							),	

							'position' => array(
								'type'        => 'checkbox_group',
								'label'       => esc_html__( 'Position', 'dp' ),
								'description' => esc_html__( 'The positions this player plays.', 'dp' ),
								'choices'     => array( 'Positions', 'get_as_kv' ),
							),									

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
	 * @param  integer $post_id The ID of the post.
	 * @return array            A multidimensional array of values by setting and section.
	 */
	function get_values( $post_id ) {

		$out = get_post_meta( $post_id, FALSE, TRUE );

		return $out;

	}

	/**
	 * Get the value for a meta field.
	 * 
	 * @param  integer $post_id    The post ID.
	 * @param  string  $section_id The section ID.
	 * @param  string  $setting_id The setting ID.
	 * @return mixed               The post meta value from the DB.
	 */ 
	function get_value( $post_id, $section_id, $setting_id ) {

		$values = $this -> get_values( $post_id );

		if( isset( $values[ $section_id ] ) ) {

			if( isset( $values[ $section_id ][ $setting_id ] ) ) {

				if( ! empty( $values[ $section_id ][ $setting_id ] ) ) {

					return $values[ $section_id ][ $setting_id ];

				}

			}

		}

		return FALSE;

	}

}