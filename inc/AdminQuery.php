<?php

/**
 * Register our admin query params.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class AdminQuery {

	public function __construct() {

		add_action( 'pre_get_posts', array( $this,  'pre_get_posts' ) );

	}

	function pre_get_posts( $query ) {

		if( ! $query -> is_main_query() ) { return $query; }

		if( ! is_admin() ) { return $query; }

		$post_type = $query -> get( 'post_type' );

		if( $post_type != 'player' ) { return $query; }

		$query -> set( 'meta_key', 'rankings-espn_points' );
		$query -> set( 'orderby',  'meta_value_num' );
		$query -> set( 'order',    'desc' );

		return $query;
		
	}

}