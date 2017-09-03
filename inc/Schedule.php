<?php

/**
 * A class for getting an NFL schedule.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Schedule {

	public function __construct() {

	}

	function get_weeks_as_array() {

		$out = array(
			'' => esc_html__( 'Not Applicable' ),
		);

		$start = 1;
		$end   = 17;

		$i = $start;

		while( $i <= 17 ) {

			$out[ $i ] = $i;

			$i++;

		}

		return $out;

	}

}