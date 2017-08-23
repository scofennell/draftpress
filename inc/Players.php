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

	public function __construct() {

		$this -> post_meta_fields = get_dp() -> post_meta_fields;

	}

	function get( $positions = FALSE ) {

		$args = array(
			'post_type'      => 'player',
			'posts_per_page' => 9999,
			'meta_key'       => 'rankings-espn_points',
			'orderby'        => 'meta_value_num',
			'order'          => 'desc',
		);

		if( is_string( $positions ) ) {
			$positions = array( $positions );
		}

		if( is_array( $positions ) ) {

			$meta_query = array();
			foreach( $positions as $position ) {
		
				$meta_query[] = array(
					'key'     => 'roster-' . $position ,
					'value'   => 1,
					'compare' => '=',
				);
			
			}
			$args['meta_query'] = $meta_query;

		}

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

	function get_rbs_as_draggable_items( $order ) {

		$players = $this -> get( 'rb' );

		$out = $this -> get_as_draggable_items( $order, $players );

		return $out;

	}

	function get_as_draggable_items( $order, $players = FALSE ) {

		if( ! $players ) {
			$players = $this -> get();
		}

		$unordered = array();

		foreach( $players as $k => $v ) {

			$player   = new Player( $k );
			$name     = $player -> get_name();
			$team     = $player -> get_team();
			$position = $player -> get_position();


			$name     = '<strong>' . $name     . '</strong>';
			$team     = '<span>'   . $team     . '</span>';
			$position = '<em>'     . $position . '</em>';
			
			$label = "$name $team $position";

			$unordered[ $k ] = $label;

		}

		$ordered = array();
		foreach( $order as $order_k => $null ) {

			if( ! isset( $unordered[ $order_k ] ) ) { continue; }

			$ordered[ $order_k ] = $unordered[ $order_k ];
			unset( $unordered[ $order_k ] );

		}

		$out = $ordered + $unordered;

		return $out;

	}

}