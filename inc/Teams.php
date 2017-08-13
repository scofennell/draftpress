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
				'label' => esc_html__( 'Arizona Cardinals', 'dp' ),
			),
			'atl' => array(
				'label' => esc_html__( 'Atlanta Falcons', 'dp' ),
			),	
			'bal' => array(
				'label' => esc_html__( 'Baltimore Ravens', 'dp' ),
			),
			'buf' => array(
				'label' => esc_html__( 'Buffalo Bills', 'dp' ),
			),	
			'car' => array(
				'label' => esc_html__( 'Carolina Panthers', 'dp' ),
			),	
			'chi' => array(
				'label' => esc_html__( 'Chicago Bears', 'dp' ),
			),	
			'cin' => array(
				'label' => esc_html__( 'Cincinnati Bengals', 'dp' ),
			),	
			'cle' => array(
				'label' => esc_html__( 'Cleveland Browns', 'dp' ),
			),
			'dal' => array(
				'label' => esc_html__( 'Dallas Cowboys', 'dp' ),
			),
			'den' => array(
				'label' => esc_html__( 'Denver Broncos', 'dp' ),
			),
			'det' => array(
				'label' => esc_html__( 'Detroit Lions', 'dp' ),
			),	
			'gb' => array(
				'label' => esc_html__( 'Green Bay Packers', 'dp' ),
			),
			'hou' => array(
				'label' => esc_html__( 'Houston Texans', 'dp' ),
			),	
			'ind' => array(
				'label' => esc_html__( 'Indianapolis Colts', 'dp' ),
			),	
			'jac' => array(
				'label' => esc_html__( 'Jacksonville Jaguars', 'dp' ),
			),	
			'kc' => array(
				'label' => esc_html__( 'Kansas City Chiefs', 'dp' ),
			),
			'lac' => array(
				'label' => esc_html__( 'Los Angeles Chargers', 'dp' ),
			),	
			'lar' => array(
				'label' => esc_html__( 'Los Angeles Rams', 'dp' ),
			),	
			'mia' => array(
				'label' => esc_html__( 'Miami Dolphins', 'dp' ),
			),	
			'min' => array(
				'label' => esc_html__( 'Minnesota Vikings', 'dp' ),
			),	
			'ne' => array(
				'label' => esc_html__( 'New England Patriots', 'dp' ),
			),	
			'no' => array(
				'label' => esc_html__( 'New Orleans Saints', 'dp' ),
			),	
			'nyg' => array(
				'label' => esc_html__( 'New York Giants', 'dp' ),
			),	
			'nyj' => array(
				'label' => esc_html__( 'New York Jets', 'dp' ),
			),	
			'oak' => array(
				'label' => esc_html__( 'Oakland Raiders', 'dp' ),
			),	
			'phi' => array(
				'label' => esc_html__( 'Philadelphia Eagles', 'dp' ),
			),	
			'pit' => array(
				'label' => esc_html__( 'Pittsburgh Steelers', 'dp' ),
			),	
			'sd' => array(
				'label' => esc_html__( 'San Diego Chargers', 'dp' ),
			),	
			'sea' => array(
				'label' => esc_html__( 'Seattle Seahawks', 'dp' ),
			),	
			'sf' => array(
				'label' => esc_html__( 'San Francisco 49ers', 'dp' ),
			),
			'tb' => array(
				'label' => esc_html__( 'Tampa Bay Buccaneers', 'dp' ),
			),	
			'ten' => array(
				'label' => esc_html__( 'Tennessee Titans', 'dp' ),
			),	
			'was' => array(
				'label' => esc_html__( 'Washington Redskins', 'dp' ),
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