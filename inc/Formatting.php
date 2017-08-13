<?php

/**
 * A singleton for formatting strings and dates and such.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Formatting {

	/**
	 * Parse a datetime into an "ago" date.
	 * 
	 * @param  string $date_string Any formatted date.
	 * @return string              The $date_string, as an "ago" date.
	 */
	public function agoify( $date_string ) {

		$date_string = sanitize_text_field( $date_string );

		$timestamp = strtotime( $date_string );

		$human_time = human_time_diff( $timestamp );

		$out = sprintf( esc_html__( '%s ago', 'dp' ), $human_time );

		return $out;

	}

	/**
	 * Clean and format text from a wp_editor() instance.
	 * 
	 * @param  string $editor_content The text that the user entered in a wp_editor().
	 * @return string                 The $editor_content text, ready for output.
	 */
	public function editorify( $editor_content ) {

		$out = $editor_content;

		$out = stripslashes( $out );
		$out = wpautop( $out );

		return $out;

	}

}