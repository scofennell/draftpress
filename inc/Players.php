<?php

/**
 * A class for getting NFL players.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Players {

	function get() {

		$out = array( 1,2,3 );

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