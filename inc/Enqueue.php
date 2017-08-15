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
			CM . '-' . __FUNCTION__,
			CM_CSS_URL . 'admin_style.css',
			array(),
			CM_VERSION,
			'all'
		);

	}

	public function style() {

		if( is_admin() ) { return FALSE; }

		wp_enqueue_style(
			CM . '-' . __FUNCTION__,
			CM_CSS_URL . 'style.css',
			array(),
			CM_VERSION,
			'all'
		);

	}

	public function script() {

		wp_enqueue_script(
			CM . '-' . __FUNCTION__,
			CM_JS_URL . 'script.js',
			array( 'jquery' ),
			CM_VERSION,
			FALSE
		);

	}

}