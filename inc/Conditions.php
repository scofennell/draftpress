<?php

/**
 * Register our conditional tags.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Conditions {

	public function __construct( $post_id = FALSE ) {

		if( ! $post_id ) { $post_id = get_the_ID(); }

		$this -> post_meta_fields = get_dp() -> post_meta_fields;
		$this -> meta_fields      = $this -> post_meta_fields -> get_fields();		

	}

	public function is_auction() {

		$draft_type = $this -> post_meta_fields -> get_value( $this -> post_id, 'scope', 'draft_type' );
		
		if( $draft_type == 'auction' ) { return TRUE; }

		return FALSE;

	}

	public function is_standard() {

		$is_auction = $this -> is_auction();

		if( ! $is_auction ) { return TRUE; }

		return FALSE;

	}

}