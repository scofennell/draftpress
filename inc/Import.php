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

		$this -> subsite_settings = new SubsiteSettings;

	}

	function get_remote_data() {

		if( ! isset( $this -> remote_data ) ) { return FALSE; }

		return $this -> remote_data;

	}

	function set_remote_data() {

		$remote_data = get_option( sanitize_key( __CLASS__ ) );
		if( ! empty( $remote_data ) ) {
			$this -> remote_data = $remote_data;
			return;
		}

		$per_page = 40;

		$league_id = $this -> subsite_settings -> get_value( 'setup', 'league_id' );

		$base = 'http://games.espn.com/ffl/tools/projections';

		$max_calls = 25;

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

			$get = wp_remote_get( $url );
			$body = $get['body'];

			@$classname    = 'playerTableTable';
			@$domdocument  = new \DOMDocument();
			@$domdocument -> loadHTML( $body );
			@$xpath        = new \DOMXPath( $domdocument );
			@$table        = $xpath -> query( "//*[contains(@class, '$classname')]" );

			$table = $table[0];

			$html  = '';
			$tbody = $table -> childNodes;

			foreach( $tbody as $row ) {

				$cells_arr = array();
				$cells     = $row -> childNodes;
				$cell_html = '';
				foreach( $cells as $cell ) {

					$cell_html = $cell -> ownerDocument -> saveHTML( $cell );
				
					if( ! stristr( $cell_html, 'playertablePlayerName' ) ) { continue; }

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

					$rows_arr[] = array(
						'name'     => $name,
						'position' => $position,
						'team'     => $team,
					);

					break;

				}

				/*$cell_count = count( $cells_arr );
				if( empty( $cell_count ) ) { continue; }

				$rows_arr []= $cells_arr;*/
			
			}

			//wp_die( var_dump( $rows_arr ) );

			$page++;

		}

		update_option( sanitize_key( __CLASS__ ), $rows_arr );

		$this -> remote_data = $rows_arr;

	}

	function set_crawl_results() {

		$this -> crawl_results = array(
			'crawled' => get_option( sanitize_key( __CLASS__ ) ),
		);

	}

	function get_crawl_results() {

		if( ! isset( $this -> crawl_results ) ) { return FALSE; }

		return $this -> crawl_results;
	
	}

	function set_post_results() {

		$rows = get_option( sanitize_key( __CLASS__ ) );

		foreach( $rows as $player ) {

			$post_arr = array(
				'post_status' => 'publish',
				'post_type'   => 'player',
				'post_title'  => esc_html( $player['name'] ),
			);

			$post_id = wp_insert_post( $post_arr );

			wp_die( var_dump( $post_id ) );

		}

	}

	function get_post_results() {

		if( ! isset( $this -> post_results ) ) { return FALSE; }

		return $this -> post_results;
	
	}

}