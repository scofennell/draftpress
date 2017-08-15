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
		
			'd' => array(
				'label' => esc_html__( 'Defense', 'dp' ),
			),
			'dst' => array(
				'label' => esc_html__( 'Defense/Special Teams', 'dp' ),
			),
			'k' => array(
				'label' => esc_html__( 'Kicker', 'dp' ),
			),	
			'qb' => array(
				'label' => esc_html__( 'Quarterback', 'dp' ),
			),	
			'rb' => array(
				'label' => esc_html__( 'Runningback', 'dp' ),
			),	
			'te' => array(
				'label' => esc_html__( 'Tight End', 'dp' ),
			),
			'wr' => array(
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