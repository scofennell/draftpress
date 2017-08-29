<?php

/**
 * A class for getting NFL team logos.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Logo {

	public function __construct( $team_slug ) {

		$this -> team_slug = $team_slug;
		//$this -> width     = $width;		

	}

	function get() {

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		$src = DRAFTPRESS_URL . 'img/logos/' . $this -> team_slug . '.png';

		$alt = esc_attr( $this -> team_slug );

		//$width = absint( $this -> width );

		$img = "<img class='$class' src='$src' alt='$alt'>";

		return $img;

	}

}