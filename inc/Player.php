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

		$positions['d']   = $this -> post_meta_fields -> get_value( $this -> id, 'roster', 'd' );
		$positions['dst'] = $this -> post_meta_fields -> get_value( $this -> id, 'roster', 'dst' );
		$positions['k']   = $this -> post_meta_fields -> get_value( $this -> id, 'roster', 'k' );
		$positions['qb']  = $this -> post_meta_fields -> get_value( $this -> id, 'roster', 'qb' );
		$positions['rb']  = $this -> post_meta_fields -> get_value( $this -> id, 'roster', 'rb' );
		$positions['te']  = $this -> post_meta_fields -> get_value( $this -> id, 'roster', 'te' );
		$positions['wr']  = $this -> post_meta_fields -> get_value( $this -> id, 'roster', 'wr' );		

		foreach( $positions as $k => $v ) {
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