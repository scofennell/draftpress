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

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		$values = $this -> post_meta_fields -> get_section_values( $this -> id, 'players' );

		$out = '';

		foreach( $values as $position_slug => $player_ids ) {

			if( empty( $player_ids ) ) { continue; }

			$player_ids = explode( ',', $player_ids );

			$position_items = '';

			foreach( $player_ids as $player_id ) {

				$player = new Player( $player_id );
				$name = $player -> get_name();
				$player_link = esc_url( get_permalink( $player_id ) );
				$name = "<a href='$player_link'>$name</a>";
				$team = $player -> get_team();


				$position_items .= "
					<li class='$class-player'>
						<span class='$class-name'>$name</span>
						<span class='$class-team'>$team</span>
					</li>
				";

			}


			if( ! empty( $position_items ) ) {
				$out .= "
					<div class='$class-position'>
						<h4 class='$class-position-title'>$position_slug</h4>
						<ol>$position_items</ol>
					</div>
				";
			} 


		}

		if( empty( $out ) ) { return FALSE; }

		$out = "<div class='$class'>$out</div>";
	
		return $out;

	}

}