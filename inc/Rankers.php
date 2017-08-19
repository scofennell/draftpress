<?php

/**
 * A class for getting rankers.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Rankers {

	public function __construct() {}

	function get() {

		$out = array();

		$ranker_key = DRAFTPRESS . '-rankings-is_ranker';

		$args = array(
			'meta_key'   => $ranker_key,
			'meta_value' => 1,
		);

		$user_query = new \WP_User_Query( $args );
		
		$get_results = $user_query -> get_results();

		if ( empty( $get_results ) ) { return FALSE; }

	    foreach ( $get_results as $ranker ) {
	
			$out[ $ranker -> ID ] = $ranker;

		}

		return $out;

	}

	function get_as_settings_array() {

		$rankers = $this -> get();

		$out = array();

		foreach( $rankers as $user_id => $user ) {

			$out[ $user_id ] = array(
				'label' => esc_html( $user -> display_name ),
			);

		}

		return $out;

	}

}