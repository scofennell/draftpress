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

	public function __construct( $team_slug, $width ) {

		$this -> team_slug = $team_slug;
		$this -> width     = $width;		

	}

	function get() {

		$src = DRAFTPRESS_URL . 'img/logos/' . $this -> team_slug . '.png';

		$alt = esc_attr( $this -> team_slug );

		$width = absint( $this -> width );

		$img = "<img src='$src' width='$width' alt='$alt'>";

		return $img;

	}

}