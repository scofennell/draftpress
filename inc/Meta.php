<?php

/**
 * A singleton for getting meta data about this plugin.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Meta {

	/**
	 * Get the slug for our plugin.
	 * 
	 * @return string The URL slug for our plugin.
	 */
	function get_slug() {
		return esc_html__( 'dp', 'dp' );
	}
	
	/**
	 * Get the label for our plugin.
	 * 
	 * @return string The admin-facing name for our plugin.
	 */
	function get_label() {
	   
        $label = 'DraftPress';
       
       return esc_html__( $label, 'draftpress' );
	}
	
	function get_icon() {
    	
    	$icon = DRAFTPRESS_URL . 'images/favicon.png';
    	
    	return esc_url( $icon );
	
	}

	/**
	 * Get the capability for managing our plugin.
	 * 
	 * @return string The cap name for managing our plugin.
	 */
	function get_capability() {
		return 'update_core';
	}

	/**
	 * Get the parent settings page for our plugin.
	 * 
	 * @return string The parent settings page for our plugin.
	 */
	function get_parent_page() {
		return 'admin.php';
	}		

}