<?php

/**
 * A class for enqueing assets.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class Enqueue {

	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'script' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'script' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_style' ) );

	}

	public function admin_style() {

		if( ! is_admin() ) { return FALSE; }

		wp_enqueue_style(
			DRAFTPRESS . '-' . __FUNCTION__,
			DRAFTPRESS_URL . 'css/admin_style.css',
			array(),
			DRAFTPRESS_VERSION,
			'all'
		);

	}

	public function style() {

		if( is_admin() ) { return FALSE; }

		wp_enqueue_style(
			DRAFTPRESS . '-' . __FUNCTION__,
			DRAFTPRESS_URL . 'css/style.css',
			array(),
			DRAFTPRESS_VERSION,
			'all'
		);

	}

	public function script() {

		wp_enqueue_script(
			DRAFTPRESS . '-' . __FUNCTION__,
			DRAFTPRESS_URL . 'js/script.js',
			array( 'jquery' ),
			DRAFTPRESS_VERSION,
			FALSE
		);

	}

}