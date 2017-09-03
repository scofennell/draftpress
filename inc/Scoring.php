<?php

/**
 * A class for getting a scoring format.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Scoring {

	public function __construct() {

	}

	function get_formats_as_array() {

		$out = array(
			'non_ppr'    => esc_html__( 'Non PPR', 'dp' ),
			'half_point' => esc_html__( 'Half-Point PPR', 'dp' ),
			'full_point' => esc_html__( 'Full-Point PPR', 'dp' ),
		);

		return $out;

	}

}