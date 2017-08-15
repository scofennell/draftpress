<?php

/**
 * A class for getting NFL players.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Players {

	function get() {

		$args = array(
			'post_type'      => 'player',
			'posts_per_page' => 999,

		);

		$the_query = new \WP_Query( $args );

		if( ! $the_query -> have_posts() ) { return FALSE; }
	
		while( $the_query -> have_posts() ) {
			
			$the_query -> the_post();
	
			global $post;

			$out[ get_the_ID() ] = $post;

		}
	
		wp_reset_postdata();
	
		return $out;

	}

	function get_as_kv() {

		$arr = $this -> get();

		$out = array();

		foreach( $arr as $k => $v ) {

			$out[ $k ] = $v -> post_title;

		}

		return $out;

	}

}