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
	
		$this -> set_results();

	}

	function set_results() {

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

			$start_index = $per_page * $i;

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
					$name = $player_data_arr[0];
					$meta = trim( $player_data_arr[1] );

					// Split by &nbsp; .
					$meta_arr = explode( chr(0xC2).chr(0xA0), $meta );

					$team     = strtolower( $meta_arr[0] );
					$position = strtolower( $meta_arr[1] );

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

		wp_die( var_dump( $rows_arr ) );

	}

	function get_results() {

		return $this -> results;
	
	}

}