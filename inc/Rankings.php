<?php

/**
 * A class for getting rankings.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Rankings {

	public function __construct( $id ) {

		$this -> id = absint( $id );

		$this -> post_meta_fields = get_dp() -> post_meta_fields;

	}

	function get() {

		$values = $this -> post_meta_fields -> get_section_values( $this -> id, 'players' );

		wp_die( var_dump( $values,  $this -> id ) );

		$out = '';
	
		return $out;

	}

}