<?php

/**
 * A class for managing plugin dependencies and loading the plugin.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */
namespace DraftPress;

class Bootstrap {

	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'create' ), 100 );

	}

	/**
	 * Instantiate and store a bunch of our plugin classes.
	 */
	function create() {

		global $draftpress;

		$draftpress -> meta                  = new Meta;
		$draftpress -> enqueue               = new Enqueue;
		$draftpress -> post_meta_fields      = new PostMetaFields;				
		$draftpress -> user_meta_fields      = new UserMetaFields;	

		$draftpress -> admin_query           = new AdminQuery;
		$draftpress -> post_meta_box         = new PostMetaBox;
		$draftpress -> user_meta_box         = new UserMetaBox;
		$draftpress -> post_types            = new PostTypes;
		$draftpress -> subsite_settings      = new SubsiteSettings;
		$draftpress -> subsite_control_panel = new SubsiteControlPanel;
		$draftpress -> update                = new Update;
		
		return $draftpress;

	}

}