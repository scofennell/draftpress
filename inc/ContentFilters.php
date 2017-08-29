<?php

/**
 * Register our content filters.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class ContentFilters {

	public function __construct() {

		add_filter( 'the_content', array( $this, 'ranking' ) );
	
	}

	public function ranking( $content ) {

		#$post_type = get_post_type();
		#if( $post_type != 'ranking' ) { return $content; }

		if( ! is_singular( 'ranking' ) ) { return $content; }

		$rankings = new Rankings( get_the_ID() );
		$rankings = $rankings -> get();

		$content .= $rankings;

		return $content;

	}

}