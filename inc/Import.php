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

		$this -> set_results();

	}

	function set_results() {

		$urls = array(
			
		);

	}

	function get_results() {

		return $this -> results;
	
	}

}