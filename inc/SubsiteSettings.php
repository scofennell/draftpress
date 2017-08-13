<?php

/**
 * A class for getting and setting the Waiver Alert subsite options.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class SubsiteSettings {

	public function __construct() {

		$this -> set_settings_values();

	}

	/**
	 * Get the unique namespace for our plugin subsite settings.  What you'd call in get_option( $slug ).
	 * 
	 * @return string The unique namespace for our plugin subsite settings.
	 */
	public function get_settings_slug() { return DRAFTPRESS . '_subsite'; }

	/**
	 * Define our multidimensional array of sections and settings.
	 * 
	 * @return array A multidimensional array of sections and settings.
	 */
	public function get_settings_array() {

		$out = array();

		// Create the "section_1" section.
		$out['setup'] = array(

			// The label for this settings section.
			'label' => esc_html__( 'Setup', 'draftpress' ),
			
			// The array of settings for this section.
			'settings' => array(

	            // A setting.
				'league_id' => array(

					// The user-facing label text for this setting.
					'label'    => esc_html__( 'League ID', 'draftpress' ),
					
					// The type of form input.
					'type'     => 'text',
					
					// Some notes for this setting.
					'notes'    => sprintf( esc_html__( 'Your league ID, found in the url for your league on espn.com.  For example, %s', 'draftpress' ), '<strong>http://games.espn.com/ffl/leagueoffice?leagueId=1234</strong>')

				// End this setting.
				),	

				
			// End the list of settings for this section.
			)

		// End this section.
		);

		return $out;

	}

	public function set_settings_values() {

		$this -> settings_values = get_option( $this -> get_settings_slug() );

	}

	public function get_settings_values() {

		return $this -> settings_values;

	}

	function get_value( $section_slug, $setting_slug ) {

		return $this -> settings_values[ $section_slug ][ $setting_slug ];

	}

}