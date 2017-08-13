<?php

/**
 * A class for getting NFL teams.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Positions {

	function get() {

		$out = array(
		
			'D' => array(
				'label' => esc_html__( 'Defense', 'dp' ),
			),
			'DST' => array(
				'label' => esc_html__( 'Defense/Special Teams', 'dp' ),
			),
			'K' => array(
				'label' => esc_html__( 'Kicker', 'dp' ),
			),	
			'QB' => array(
				'label' => esc_html__( 'Quarterback', 'dp' ),
			),	
			'RB' => array(
				'label' => esc_html__( 'Runningback', 'dp' ),
			),	
			'TE' => array(
				'label' => esc_html__( 'Tight End', 'dp' ),
			),
			'WR' => array(
				'label' => esc_html__( 'Wide Receiver', 'dp' ),
			),	

		);

		return $out;

	}

	function get_as_kv() {

		$arr = $this -> get();

		$out = array();

		foreach( $arr as $k => $v ) {

			$out[ $k ] = $v['label'];

		}

		return $out;

	}	

}