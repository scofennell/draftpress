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
				'bye'      => 8,
			),
			'atl' => array(
				'mascot'   => esc_html__( 'Falcons', 'dp' ),
				'location' => esc_html__( 'Atlanta', 'dp' ),
				'bye'      => 5,				
			),	
			'bal' => array(
				'mascot'   => esc_html__( 'Ravens', 'dp' ),
				'location' => esc_html__( 'Baltimore', 'dp' ),
				'bye'      => 10,
			),
			'buf' => array(
				'mascot'   => esc_html__( 'Bills', 'dp' ),
				'location' => esc_html__( 'Buffalo', 'dp' ),
				'bye'      => 6,
			),	
			'car' => array(
				'mascot'   => esc_html__( 'Panthers', 'dp' ),
				'location' => esc_html__( 'Carolina', 'dp' ),
				'bye'      => 11,
			),	
			'chi' => array(
				'mascot'   => esc_html__( 'Bears', 'dp' ),
				'location' => esc_html__( 'Chicago', 'dp' ),
				'bye'      => 9,
			),	
			'cin' => array(
				'mascot'   => esc_html__( 'Bengals', 'dp' ),
				'location' => esc_html__( 'Cincinnati', 'dp' ),
				'bye'      => 6,
			),	
			'cle' => array(
				'mascot'   => esc_html__( 'Browns', 'dp' ),
				'location' => esc_html__( 'Cleveland', 'dp' ),
				'bye'      => 9,
			),
			'dal' => array(
				'mascot'   => esc_html__( 'Cowboys', 'dp' ),
				'location' => esc_html__( 'Dallas', 'dp' ),
				'bye'      => 6,
			),
			'den' => array(
				'mascot'   => esc_html__( 'Broncos', 'dp' ),
				'location' => esc_html__( 'Denver', 'dp' ),
				'bye'      => 5,
			),
			'det' => array(
				'mascot'   => esc_html__( 'Lions', 'dp' ),
				'location' => esc_html__( 'Detroit', 'dp' ),
				'bye'      => 7,
			),	
			'gb' => array(
				'mascot'   => esc_html__( 'Packers', 'dp' ),
				'location' => esc_html__( 'Green Bay', 'dp' ),
				'bye'      => 8,
			),
			'hou' => array(
				'mascot'   => esc_html__( 'Texans', 'dp' ),
				'location' => esc_html__( 'Houston', 'dp' ),
				'bye'      => 7,
			),	
			'ind' => array(
				'mascot'   => esc_html__( 'Colts', 'dp' ),
				'location' => esc_html__( 'Indianapolis', 'dp' ),
				'bye'      => 11,
			),	
			'jax' => array(
				'mascot'   => esc_html__( 'Jaguars', 'dp' ),
				'location' => esc_html__( 'Jacksonville', 'dp' ),
				'bye'      => 8,
			),	
			'kc' => array(
				'mascot'   => esc_html__( 'Chiefs', 'dp' ),
				'location' => esc_html__( 'Kansas City', 'dp' ),
				'bye'      => 10,
			),
			'lac' => array(
				'mascot'   => esc_html__( 'Chargers', 'dp' ),
				'location' => esc_html__( 'Los Angeles', 'dp' ),
				'bye'      => 9,
			),	
			'lar' => array(
				'mascot'   => esc_html__( 'Rams', 'dp' ),
				'location' => esc_html__( 'Los Angeles', 'dp' ),
				'bye'      => 8,
			),	
			'mia' => array(
				'mascot'   => esc_html__( 'Dolphins', 'dp' ),
				'location' => esc_html__( 'Miami', 'dp' ),
				'bye'      => 11,
			),	
			'min' => array(
				'mascot'   => esc_html__( 'Vikings', 'dp' ),
				'location' => esc_html__( 'Minnesota', 'dp' ),
				'bye'      => 9,
			),	
			'ne' => array(
				'mascot'   => esc_html__( 'Patriots', 'dp' ),
				'location' => esc_html__( 'New England', 'dp' ),
				'bye'      => 9,
			),	
			'no' => array(
				'mascot'   => esc_html__( 'Saints', 'dp' ),
				'location' => esc_html__( 'New Orleans', 'dp' ),
				'bye'      => 5,
			),	
			'nyg' => array(
				'mascot'   => esc_html__( 'Giants', 'dp' ),
				'location' => esc_html__( 'New York', 'dp' ),
				'bye'      => 8,
			),	
			'nyj' => array(
				'mascot'   => esc_html__( 'Jets', 'dp' ),
				'location' => esc_html__( 'New York', 'dp' ),
				'bye'      => 11,
			),	
			'oak' => array(
				'mascot'   => esc_html__( 'Raiders', 'dp' ),
				'location' => esc_html__( 'Oakland', 'dp' ),
				'bye'      => 10,
			),	
			'phi' => array(
				'mascot'   => esc_html__( 'Eagles', 'dp' ),
				'location' => esc_html__( 'Philadelphia', 'dp' ),
				'bye'      => 10,
			),	
			'pit' => array(
				'mascot'   => esc_html__( 'Steelers', 'dp' ),
				'location' => esc_html__( 'Pittsburgh', 'dp' ),
				'bye'      => 9,
			),	
			'sea' => array(
				'mascot'   => esc_html__( 'Seahawks', 'dp' ),
				'location' => esc_html__( 'Seattle', 'dp' ),
				'bye'      => 6,
			),	
			'sf' => array(
				'mascot'   => esc_html__( '49ers', 'dp' ),
				'location' => esc_html__( 'San Francisco', 'dp' ),
				'bye'      => 11,
			),
			'tb' => array(
				'mascot'   => esc_html__( 'Buccaneers', 'dp' ),
				'location' => esc_html__( 'Tampa Bay', 'dp' ),
				'bye'      => 11,
			),	
			'ten' => array(
				'mascot'   => esc_html__( 'Titans', 'dp' ),
				'location' => esc_html__( 'Tennessee', 'dp' ),
				'bye'      => 8,
			),	
			'wsh' => array(
				'mascot'   => esc_html__( 'Redskins', 'dp' ),
				'location' => esc_html__( 'Washington', 'dp' ),
				'bye'      => 5,
			),	

		);

		return $out;

	}

	function get_team_key_by_mascot( $mascot ) {

		$teams = $this -> get();

		foreach( $teams as $team_k => $team ) {

			if( $team['mascot'] == $mascot ) {

				return $team_k;

			} 

		}

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