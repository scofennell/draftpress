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
		
			'ARI' => array(
				'label' => esc_html__( 'Arizona Cardinals', 'dp' ),
			),
			'ATL' => array(
				'label' => esc_html__( 'Atlanta Falcons', 'dp' ),
			),	
			'BAL' => array(
				'label' => esc_html__( 'Baltimore Ravens', 'dp' ),
			),
			'BUF' => array(
				'label' => esc_html__( 'Buffalo Bills', 'dp' ),
			),	
			'CAR' => array(
				'label' => esc_html__( 'Carolina Panthers', 'dp' ),
			),	
			'CHI' => array(
				'label' => esc_html__( 'Chicago Bears', 'dp' ),
			),	
			'CIN' => array(
				'label' => esc_html__( 'Cincinnati Bengals', 'dp' ),
			),	
			'CLE' => array(
				'label' => esc_html__( 'Cleveland Browns', 'dp' ),
			),
			'DAL' => array(
				'label' => esc_html__( 'Dallas Cowboys', 'dp' ),
			),
			'DEN' => array(
				'label' => esc_html__( 'Denver Broncos', 'dp' ),
			),
			'DET' => array(
				'label' => esc_html__( 'Detroit Lions', 'dp' ),
			),	
			'GB' => array(
				'label' => esc_html__( 'Green Bay Packers', 'dp' ),
			),
			'HOU' => array(
				'label' => esc_html__( 'Houston Texans', 'dp' ),
			),	
			'IND' => array(
				'label' => esc_html__( 'Indianapolis Colts', 'dp' ),
			),	
			'JAC' => array(
				'label' => esc_html__( 'Jacksonville Jaguars', 'dp' ),
			),	
			'KC' => array(
				'label' => esc_html__( 'Kansas City Chiefs', 'dp' ),
			),
			'LAC' => array(
				'label' => esc_html__( 'Los Angeles Chargers', 'dp' ),
			),	
			'LAR' => array(
				'label' => esc_html__( 'Los Angeles Rams', 'dp' ),
			),	
			'MIA' => array(
				'label' => esc_html__( 'Miami Dolphins', 'dp' ),
			),	
			'MIN' => array(
				'label' => esc_html__( 'Minnesota Vikings', 'dp' ),
			),	
			'NWE' => array(
				'label' => esc_html__( 'New England Patriots', 'dp' ),
			),	
			'NOR' => array(
				'label' => esc_html__( 'New Orleans Saints', 'dp' ),
			),	
			'NYG' => array(
				'label' => esc_html__( 'New York Giants', 'dp' ),
			),	
			'NYJ' => array(
				'label' => esc_html__( 'New York Jets', 'dp' ),
			),	
			'OAK' => array(
				'label' => esc_html__( 'Oakland Raiders', 'dp' ),
			),	
			'PHI' => array(
				'label' => esc_html__( 'Philadelphia Eagles', 'dp' ),
			),	
			'PIT' => array(
				'label' => esc_html__( 'Pittsburgh Steelers', 'dp' ),
			),	
			'SD' => array(
				'label' => esc_html__( 'San Diego Chargers', 'dp' ),
			),	
			'SEA' => array(
				'label' => esc_html__( 'Seattle Seahawks', 'dp' ),
			),	
			'SF' => array(
				'label' => esc_html__( 'San Francisco 49ers', 'dp' ),
			),
			'TB' => array(
				'label' => esc_html__( 'Tampa Bay Buccaneers', 'dp' ),
			),	
			'TEN' => array(
				'label' => esc_html__( 'Tennessee Titans', 'dp' ),
			),	
			'WAS' => array(
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