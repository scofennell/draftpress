<?php

/**
 * A class for getting player attributes.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Attributes {

	function get() {

		$out = array(
		
			'sleeper' => array(
				'label' => esc_html__( 'Sleeper', 'dp' ),
			),

			'value' => array(
				'label' => esc_html__( 'Value', 'dp' ),
			),

			'bust' => array(
				'label' => esc_html__( 'Bust', 'dp' ),
			),

			'rookie' => array(
				'label' => esc_html__( 'Rookie', 'dp' ),
			),

		);

		return $out;

	}	

}