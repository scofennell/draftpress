<?php

/**
 * A class for getting NFL teams.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Teams {

	function get() {

		$out = array(
		
			'ari' => array(
				'mascot'   => esc_html__( 'Cardinals', 'dp' ),
				'location' => esc_html__( 'Arizona', 'dp' ),
			),
			'atl' => array(
				'mascot'   => esc_html__( 'Falcons', 'dp' ),
				'location' => esc_html__( 'Atlanta', 'dp' ),
			),	
			'bal' => array(
				'mascot'   => esc_html__( 'Ravens', 'dp' ),
				'location' => esc_html__( 'Baltimore', 'dp' ),
			),
			'buf' => array(
				'mascot'   => esc_html__( 'Bills', 'dp' ),
				'location' => esc_html__( 'Buffalo', 'dp' ),
			),	
			'car' => array(
				'mascot'   => esc_html__( 'Panthers', 'dp' ),
				'location' => esc_html__( 'Carolina', 'dp' ),
			),	
			'chi' => array(
				'mascot'   => esc_html__( 'Bears', 'dp' ),
				'location' => esc_html__( 'Chicago', 'dp' ),
			),	
			'cin' => array(
				'mascot'   => esc_html__( 'Bengals', 'dp' ),
				'location' => esc_html__( 'Cincinnati', 'dp' ),
			),	
			'cle' => array(
				'mascot'   => esc_html__( 'Browns', 'dp' ),
				'location' => esc_html__( 'Cleveland', 'dp' ),
			),
			'dal' => array(
				'mascot'   => esc_html__( 'Cowboys', 'dp' ),
				'location' => esc_html__( 'Dallas', 'dp' ),
			),
			'den' => array(
				'mascot'   => esc_html__( 'Broncos', 'dp' ),
				'location' => esc_html__( 'Denver', 'dp' ),
			),
			'det' => array(
				'mascot'   => esc_html__( 'Lions', 'dp' ),
				'location' => esc_html__( 'Detroit', 'dp' ),
			),	
			'gb' => array(
				'mascot'   => esc_html__( 'Packers', 'dp' ),
				'location' => esc_html__( 'Green Bay', 'dp' ),
			),
			'hou' => array(
				'mascot'   => esc_html__( 'Texans', 'dp' ),
				'location' => esc_html__( 'Houston', 'dp' ),
			),	
			'ind' => array(
				'mascot'   => esc_html__( 'Colts', 'dp' ),
				'location' => esc_html__( 'Indianapolis', 'dp' ),
			),	
			'jax' => array(
				'mascot'   => esc_html__( 'Jaguars', 'dp' ),
				'location' => esc_html__( 'Jacksonville', 'dp' ),
			),	
			'kc' => array(
				'mascot'   => esc_html__( 'Chiefs', 'dp' ),
				'location' => esc_html__( 'Kansas City', 'dp' ),
			),
			'lac' => array(
				'mascot'   => esc_html__( 'Chargers', 'dp' ),
				'location' => esc_html__( 'Los Angeles', 'dp' ),
			),	
			'lar' => array(
				'mascot'   => esc_html__( 'Rams', 'dp' ),
				'location' => esc_html__( 'Los Angeles', 'dp' ),
			),	
			'mia' => array(
				'mascot'   => esc_html__( 'Dolphins', 'dp' ),
				'location' => esc_html__( 'Miami', 'dp' ),
			),	
			'min' => array(
				'mascot'   => esc_html__( 'Vikings', 'dp' ),
				'location' => esc_html__( 'Minnesota', 'dp' ),
			),	
			'ne' => array(
				'mascot'   => esc_html__( 'Patriots', 'dp' ),
				'location' => esc_html__( 'New England', 'dp' ),
			),	
			'no' => array(
				'mascot'   => esc_html__( 'Saints', 'dp' ),
				'location' => esc_html__( 'New Orleans', 'dp' ),
			),	
			'nyg' => array(
				'mascot'   => esc_html__( 'Giants', 'dp' ),
				'location' => esc_html__( 'New York', 'dp' ),
			),	
			'nyj' => array(
				'mascot'   => esc_html__( 'Jets', 'dp' ),
				'location' => esc_html__( 'New York', 'dp' ),
			),	
			'oak' => array(
				'mascot'   => esc_html__( 'Raiders', 'dp' ),
				'location' => esc_html__( 'Oakland', 'dp' ),
			),	
			'phi' => array(
				'mascot'   => esc_html__( 'Eagles', 'dp' ),
				'location' => esc_html__( 'Philadelphia', 'dp' ),
			),	
			'pit' => array(
				'mascot'   => esc_html__( 'Steelers', 'dp' ),
				'location' => esc_html__( 'Pittsburgh', 'dp' ),
			),	
			'sea' => array(
				'mascot'   => esc_html__( 'Seahawks', 'dp' ),
				'location' => esc_html__( 'Seattle', 'dp' ),
			),	
			'sf' => array(
				'mascot'   => esc_html__( '49ers', 'dp' ),
				'location' => esc_html__( 'San Francisco', 'dp' ),
			),
			'tb' => array(
				'mascot'   => esc_html__( 'Buccaneers', 'dp' ),
				'location' => esc_html__( 'Tampa Bay', 'dp' ),
			),	
			'ten' => array(
				'mascot'   => esc_html__( 'Titans', 'dp' ),
				'location' => esc_html__( 'Tennessee', 'dp' ),
			),	
			'wsh' => array(
				'mascot'   => esc_html__( 'Redskins', 'dp' ),
				'location' => esc_html__( 'Washington', 'dp' ),
			),	

		);

		return $out;

	}

	function get_as_kv() {

		$arr = $this -> get();

		$out = array();

		foreach( $arr as $k => $v ) {

			$logo = new Logo( $k );
			$logo = $logo -> get();

			$text = '<span>' . $v['location'] . ' ' . $v['mascot'] . '</span>';

			$label = $logo . $text;

			$out[ $k ] = $label;

		}

		return $out;

	}

}