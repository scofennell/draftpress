<?php

/**
 * Register our theme update routine.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Update {

	public function __construct() {

		$this -> set_is_update();

	}

	function get_slug() {

		$out = sanitize_key( __CLASS__ );

		return $out;

	}

	function set_is_update() {

		$fv  = $this -> get_file_version();
		$dbv = $this -> get_database_version();

		if( empty( $dbv ) ) {

			$out = TRUE;

		} else {
	
			// returns -1 if the first version is lower than the second, 0 if they are equal, and 1 if the second is lower.
			$compare = version_compare( $fv, $dbv );

			if( $compare === 1 ) {
				$out = TRUE;
			} else {
				$out = FALSE;
			}

		}

		$this -> update_database_version( $fv );

		$this -> is_update = $out;

	}

	function is_update() {

		if( ! isset( $this -> is_update ) ) {
			$this -> set_is_update();
		}

		return $this -> is_update;

	}

	function get_file_version() {

		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$get_plugin_data = get_plugin_data( DRAFTPRESS_FILE );
		
		$out = $get_plugin_data['Version'];

		return $out;

	}

	function get_database_version() {

		$out = get_option( $this -> get_slug() );

		return $out;

	}

	function update_database_version( $new_version ) {

		$out = update_option( $this -> get_slug(), $new_version );

		return $out;

	}

}