<?php

/**
 * A class for getting an import.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Import {

	public function __construct() {

		#delete_option( sanitize_key( __CLASS__ ) );

		$this -> subsite_settings = new SubsiteSettings;

	}

	function get_crawl_data() {

		if( ! isset( $this -> crawl_data ) ) { $this -> set_crawl_data(); }

		return $this -> crawl_data;

	}

	function set_crawl_data() {

		$crawl_data = get_option( sanitize_key( __CLASS__ ) );
		if( ! empty( $crawl_data ) ) {
			$this -> crawl_data = $crawl_data;
			return;
		}

		$per_page = 40;

		$league_id = $this -> subsite_settings -> get_value( 'setup', 'league_id' );

		$base = 'http://games.espn.com/ffl/tools/projections';

		$max_calls = 30;

		$start_index = 0;

		$url = add_query_arg(
			array( 
				'leagueId'   => $league_id,
				'startIndex' => $start_index,
			),
			$base
		);

		$page = 0;
		$rows_arr = array();
		while( $page < $max_calls ) {

			$start_index = $per_page * $page;

			$url = remove_query_arg( 'startIndex', $url );
			$url = add_query_arg( array( 'startIndex' => $start_index ), $url );

			$get  = wp_remote_get( $url );

			if( is_wp_error( $get ) ) { return FALSE; }

			$body = $get['body'];

			@$classname    = 'playerTableTable';
			@$domdocument  = new \DOMDocument();
			@$domdocument -> loadHTML( $body );
			@$xpath        = new \DOMXPath( $domdocument );
			@$table        = $xpath -> query( "//*[contains(@class, '$classname')]" );

			$table = $table[0];
			$tbody = $table -> childNodes;

			if( ! $tbody ) { break; }

			foreach( $tbody as $row ) {

				//$row_html = $row -> ownerDocument -> saveHTML( $row );

				if( $row -> textContent == 'PLAYERSSTATUSPASSINGRUSHINGRECEIVINGTOTAL' ) { continue; }
				if( stristr( $row -> textContent, 'RNKPLAYER' ) ) { continue; }

				$cells     = $row -> childNodes;

				$cell_html = '';
				$slug = '';
				foreach( $cells as $cell ) {

					$cell_html = $cell -> ownerDocument -> saveHTML( $cell );
				
					if( stristr( $cell_html, 'playertablePlayerName' ) ) {

						$player_data = $cell -> textContent;

						$player_data_arr = explode( ',', $player_data );
						
						if( ! isset( $player_data_arr[1] ) ) {

							$defense_arr = explode( ' ', $player_data_arr[0] );
							$name     = $defense_arr[0] . ' dst';
							$position = 'dst';
							$team     = $name;

						} else {
						
							$name = $player_data_arr[0];

							$meta = trim( $player_data_arr[1] );
				
							// Split by &nbsp; .
							$meta_arr = explode( chr(0xC2).chr(0xA0), $meta );

							$team     = strtolower( $meta_arr[0] );
							$position = strtolower( $meta_arr[1] );

						}

						$name = str_replace( '*', '', $name );

						$slug = sanitize_title_with_dashes( $name );

					} elseif( stristr( $cell_html, 'appliedPoints' ) ) {

						$points = $cell -> textContent;

					} else {

						continue;

					}

				}

				if( empty( $slug ) ) { continue; }

				$rows_arr[] = array(
					'name'        => $name,
					'position'    => $position,
					'team'        => $team,
					'espn_points' => $points,
				);
			
			}

			//wp_die( var_dump( $rows_arr ) );

			$page++;

		}

		update_option( sanitize_key( __CLASS__ ), $rows_arr );

		$this -> crawl_data = $rows_arr;

	}

	function set_crawl_results() {

		$this -> crawl_results = array(
			'crawled' => get_option( sanitize_key( __CLASS__ ) ),
		);

	}

	function get_crawl_results() {

		if( ! isset( $this -> crawl_results ) ) { $this -> set_crawl_results(); }

		return $this -> crawl_results;
	
	}

	function set_import_results() {

		$rows = get_option( sanitize_key( __CLASS__ ) );

		$out = array();

		$max = 500;

		$i = 0;
		foreach( $rows as $player_i => $player ) {

			if( $i > $max ) { break; }

			$name_arr   = explode( ' ', $player['name'] );
			$first_name = esc_html( $name_arr[0] );
			unset( $name_arr[0] );
			$last_name  = implode( ' ', $name_arr );
			$comma_name = sprintf( esc_html__( '%s, %s', 'dp' ), $last_name, $first_name );
			
			$team     = esc_html( $player['team'] );
			$position = esc_html( $player['position'] );

			$espn_points = floatval( $player['espn_points'] );

			$post_arr = array(
				'post_status' => 'publish',
				'post_type'   => 'player',
				'post_title'  => $comma_name,
				'meta_input'  => array(
					'bio-first_name'       => $first_name,
					'bio-last_name'        => $last_name,
					'bio-team'             => $team,
					'roster-' . $position  => TRUE,
					'rankings-espn_points' => $espn_points
				),
			);

			$wp_insert_post = wp_insert_post( $post_arr );

			if( is_int( $wp_insert_post ) ) {

				$out[] = $comma_name;

				unset( $rows[ $player_i ] );

			}

			$i++;

		}

		$this -> import_results = $out;

		update_option( sanitize_key( __CLASS__ ), $rows );

	}

	function get_import_results() {

		if( ! isset( $this -> import_results ) ) { return FALSE; }

		return $this -> import_results;
	
	}

}