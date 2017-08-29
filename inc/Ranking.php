<?php

/**
 * A class for getting a ranking.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Ranking {

	public function __construct( $id ) {

		$this -> id = absint( $id );

		$this -> post_meta_fields = get_dp() -> post_meta_fields;

	}

	function get() {

		
	
	}

}