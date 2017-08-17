<?php

/**
 * A class for getting an NFL player.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Player {

	public function __construct( $id ) {

		$this -> id = absint( $id );

		$this -> post_meta_fields = get_dp() -> post_meta_fields;

	}

	function get() {

		return get_post( $this -> id );
	
	}

	function get_team() {

		return $this -> post_meta_fields -> get_value( $this -> id, 'bio', 'team' );

	}

	function get_name() {

		return $this -> get() -> post_title;

	}

	function get_positions() {

		$out = array();

		$vals = array();

		$positions = new Positions;
		$get_positions = $positions -> get();
		foreach( $get_positions as $pos_k => $pos_v ) {
			$vals[ $pos_k ] = $this -> post_meta_fields -> get_value( $this -> id, 'roster', $pos_k );
		}

		foreach( $vals as $k => $v ) {
			if( $v ) {
				$out[] = $k;
			}
		}

		return $out;

	}

	function get_position() {

		$positions = $this -> get_positions();
		$out = implode( ',', $positions );
		
		return $out;

	}


}