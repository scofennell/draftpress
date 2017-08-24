<?php

/**
 * Register our post types.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class PostTypes {

	public function __construct() {

		// Add our post types.
		add_action( 'init', array( $this, 'register' ), 10 );

	}

	/**
	 * Define all of our post types in an array.
	 * 
	 * @return array All of our post types.
	 */
	public function get_post_types() {

		$out = array(

			// The ID for this post type.
			'player' => array(
				
				'labels'             => array(
					'name'               => _x( 'Players', 'post type general name', 'dp' ),
					'singular_name'      => _x( 'Players', 'post type singular name', 'dp' ),
					'menu_name'          => _x( 'Players', 'admin menu', 'dp' ),
					'name_admin_bar'     => _x( 'Players', 'add new on admin bar', 'dp' ),
					'add_new'            => _x( 'Add New', 'player', 'dp' ),
					'add_new_item'       => __( 'Add New Players', 'dp' ),
					'new_item'           => __( 'New Players', 'dp' ),
					'edit_item'          => __( 'Edit Players', 'dp' ),
					'view_item'          => __( 'View Players', 'dp' ),
					'all_items'          => __( 'All Players', 'dp' ),
					'search_items'       => __( 'Search Players', 'dp' ),
					'parent_item_colon'  => __( 'Parent Players:', 'dp' ),
					'not_found'          => __( 'No players found.', 'dp' ),
					'not_found_in_trash' => __( 'No players found in Trash.', 'dp' ),
				),
				'description'        => __( 'Players.', 'dp' ),
				'public'             => FALSE,
				'publicly_queryable' => FALSE,
				'show_ui'            => TRUE,
				'show_in_menu'       => TRUE,
				'query_var'          => FALSE,
				'rewrite'            => FALSE,
				'capability_type'    => 'post',
				'has_archive'        => FALSE,
				'hierarchical'       => FALSE,
				'menu_position'      => TRUE,
				'supports'           => array( 'title', 'thumbnail', 'editor', 'custom-fields' ),
				//'taxonomies'         => array( 'category' ),
				'menu_icon'          => 'dashicons-groups',

			),

			// The ID for this post type.
			'ranking' => array(
				
				'labels'             => array(
					'name'               => _x( 'Rankings', 'post type general name', 'dp' ),
					'singular_name'      => _x( 'Rankings', 'post type singular name', 'dp' ),
					'menu_name'          => _x( 'Rankings', 'admin menu', 'dp' ),
					'name_admin_bar'     => _x( 'Rankings', 'add new on admin bar', 'dp' ),
					'add_new'            => _x( 'Add New', 'player', 'dp' ),
					'add_new_item'       => __( 'Add New Rankings', 'dp' ),
					'new_item'           => __( 'New Rankings', 'dp' ),
					'edit_item'          => __( 'Edit Rankings', 'dp' ),
					'view_item'          => __( 'View Rankings', 'dp' ),
					'all_items'          => __( 'All Rankings', 'dp' ),
					'search_items'       => __( 'Search Rankings', 'dp' ),
					'parent_item_colon'  => __( 'Parent Rankings:', 'dp' ),
					'not_found'          => __( 'No rankings found.', 'dp' ),
					'not_found_in_trash' => __( 'No rankings found in Trash.', 'dp' ),
				),
				'description'        => __( 'Rankings.', 'dp' ),
				'public'             => FALSE,
				'publicly_queryable' => TRUE,
				'show_ui'            => TRUE,
				'show_in_menu'       => TRUE,
				'query_var'          => FALSE,
				'rewrite'            => FALSE,
				'capability_type'    => 'post',
				'has_archive'        => FALSE,
				'hierarchical'       => FALSE,
				'menu_position'      => TRUE,
				'supports'           => array( 'title', 'thumbnail', 'editor', 'custom-fields' ),
				//'taxonomies'         => array( 'category' ),
				'menu_icon'          => 'dashicons-chart-bar',

			),						

		);

		return $out;

	}

	/**
	 * Add our post types.
	 */
	function register() {

		// Grab the post types we defined above.
		$post_types = $this -> get_post_types();

		// For each post type...
		foreach( $post_types as $slug => $post_type ) {

			register_post_type( $slug, $post_type );	

		}
	
	}

}