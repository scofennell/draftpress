<?php

/**
 * Register our user meta boxes.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class UserMetaBox {

	use Form;

	public function __construct() {

		add_action( 'personal_options_update',  array( $this, 'update' ) );
		add_action( 'edit_user_profile_update', array( $this, 'update' ) );

		add_action( 'show_user_profile', array( $this, 'show' ) );
		add_action( 'edit_user_profile', array( $this, 'show' ) );
	
	}

	function show() {

	}

	function update() {
		
	} 

}