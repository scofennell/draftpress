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
			'player' => array(

				// The label for this post type.
				'label' => esc_html__( 'Player Data', 'dp' ),

				// The sections for this post type.
				'sections' => array(

					// A section.
					'bio' => array(

						// The label for this section.
						'label' => esc_html__( 'Biographical Data for This Player', 'dp' ),

						// The settings for this section.
						'settings' => array(

							'first_name' => array(
								'label'       => esc_html__( 'First Name', 'dp' ),
								'description' => esc_html__( 'The first name of this player.', 'dp' ),
							),

							'last_name' => array(
								'label'       => esc_html__( 'Last Name', 'dp' ),
								'description' => esc_html__( 'The last name of this player.', 'dp' ),
							),							

							'team' => array(
								'type'        => 'radio',
								'label'       => esc_html__( 'Team', 'dp' ),
								'description' => esc_html__( 'The NFL team for which this player plays.', 'dp' ),
								'choices'     => array( 'Teams', 'get_as_kv' ),
							),												

						),

					),

					'roster'  => array(

						// The label for this section.
						'label' => esc_html__( 'Roster Data for This Player', 'dp' ),

						// The settings for this section.
						'settings' => array(

							'd' => array(
								'type'        => 'checkbox',
								'label'       => esc_html__( 'Defense', 'dp' ),
								'description' => esc_html__( 'Is this player a Defense?', 'dp' ),
							),								

							'dst' => array(
								'type'        => 'checkbox',
								'label'       => esc_html__( 'D/ST', 'dp' ),
								'description' => esc_html__( 'Is this player a D/ST?', 'dp' ),
							),								

							'k' => array(
								'type'        => 'checkbox',
								'label'       => esc_html__( 'Kicker', 'dp' ),
								'description' => esc_html__( 'Is this player a Kicker?', 'dp' ),
							),								

							'qb' => array(
								'type'        => 'checkbox',
								'label'       => esc_html__( 'Quarterback', 'dp' ),
								'description' => esc_html__( 'Is this player a Quarterback?', 'dp' ),
							),								

							'rb' => array(
								'type'        => 'checkbox',
								'label'       => esc_html__( 'Runningback', 'dp' ),
								'description' => esc_html__( 'Is this player a Runningback?', 'dp' ),
							),								

							'wr' => array(
								'type'        => 'checkbox',
								'label'       => esc_html__( 'Wide Receiver', 'dp' ),
								'description' => esc_html__( 'Is this player a Wide Receiver?', 'dp' ),
							),								

							'te' => array(
								'type'        => 'checkbox',
								'label'       => esc_html__( 'Tight End', 'dp' ),
								'description' => esc_html__( 'Is this player a Tight End?', 'dp' ),
							),

						),

					),

				),

			),

			// A post type.
			'ranking' => array(

				// The label for this post type.
				'label' => esc_html__( 'Ranking Data', 'dp' ),

				// The sections for this post type.
				'sections' => array(

					// A section.
					'players' => array(

						// The label for this section.
						'label' => esc_html__( 'Player Rankings', 'dp' ),

						// The settings for this section.
						'settings' => array(

							'order' => array(
								'label'       => esc_html__( 'Order', 'dp' ),
								'type'        => 'draggable',
								'description' => esc_html__( 'The order in which players are ranked.', 'dp' ),
								'items'       => array( 'Players', 'get_as_kv' ),
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

		$out = array();

		$get_post_meta = get_post_meta( $post_id, FALSE, TRUE );

		foreach( $get_post_meta as $k => $v ) {

			if( count( $v == 1 ) ) 
			$out[ $k ] = $v[ 0 ]; 

		}

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

		$post = get_post( $post_id );
		$key = "$section_id-$setting_id";

		if( ! isset( $post -> $key ) ) { return FALSE; }

		return $post -> $key;

	}

}