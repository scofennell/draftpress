<?php

/**
 * Register our post meta boxes.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class PostMetaBox {

	use Form;

	public function __construct() {

		global $post_id;

		// Grab the list of meta fields.
		$this -> post_meta_fields = get_dp() -> post_meta_fields;
		$this -> meta_fields      = $this -> post_meta_fields -> get_fields();
		
		add_filter( 'title_edit_pre', array( $this, 'title_edit_pre' ), 10, 2 );

		add_filter( 'wp_insert_post_data' , array( $this, 'wp_insert_post_data' ), 999, 2 );
		add_filter( 'wp_insert_post_data' , array( $this, 'wp_insert_post_data' ), 1, 2 );

		// Add our meta boxes.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		
		// Handle the saving of our meta boxes.
		add_action( 'save_post', array( $this, 'save_post' ), 10, 3 );

	}

	function title_edit_pre( $title, $post_id ) {

		$post = get_post( $post_id );

		if( $post -> post_type != 'player' ) { return $title; }

		$last_name  = $this -> post_meta_fields -> get_value( $post_id, 'bio', 'last_name' );
		$first_name = $this -> post_meta_fields -> get_value( $post_id, 'bio', 'first_name' );

		$out = sprintf( esc_attr__( '%s, %s', 'dp' ), $last_name, $first_name );

		return $out;

	}

	function wp_insert_post_data( $data, $post ) {

		if( is_object( $post ) ) {
			
			if( $post -> post_type != 'player' ) { return $data; }

			$post_id = $post -> ID;

		} elseif( is_array( $post ) ) {
		
			if( $post['post_type'] != 'player' ) { return $data; }
		
			$post_id = $post['ID'];

		} else {
		
			return $data;
		
		}

		if( ! isset( $post[ DRAFTPRESS ] ) ) {
			return $data;
		}

		$last_name  = $post[ DRAFTPRESS ]['bio-last_name'];
		$first_name = $post[ DRAFTPRESS ]['bio-first_name'];
			
		$post_title = sprintf( esc_attr__( '%s, %s', 'dp' ), $last_name, $first_name );

		$data['post_title'] = $post_title;

		return $data;
	}

	/**
	 * Determine if we are on the post page.
	 * 
	 * @return boolean Returns TRUE if we are on the post page, else FALSE.
	 */
	function is_current_page( $post_type ) {

		// If we're in network admin, bail.
		if( is_multisite() ) {
			if( is_network_admin() ) { return FALSE; }
		}

		// If we're not in admin, bail.
		if( ! is_admin() ) { return FALSE; }

		if( ! function_exists( 'get_current_screen' ) ) { return FALSE; }

		$current_screen = get_current_screen();

		// If we're not on the post screen, bail.
		$base      = $current_screen -> base;
		if( $base != 'post' ) { return FALSE; }

		// If the post type is not in our allowed array, bail.
		if( $post_type != $current_screen -> post_type ) { return FALSE; }
		
		return TRUE;

	}

	/**
	 * Add the meta boxes.
	 * 
	 * @param string $post_type The post type to which we're adding meta boxes.
	 */
	public function add_meta_boxes( $post_type ) {

		foreach( $this -> meta_fields as $meta_field_post_type => $meta_box ) {

			if( $post_type != $meta_field_post_type ) { continue; }

			$id            = DRAFTPRESS . '-' . $post_type;
			$title         = $meta_box['label'];
			$callback      = array( $this, 'the_content' );
			$screen        = $post_type;
			$context       = 'advanced';
			$priority      = 'high';
			$callback_args = array();

			add_meta_box(
				$id, 
				$title, 
				$callback, 
				$screen, 
				$context,
				$priority,
				$callback_args
			);
		
		}

	}

	/**
	 * Echo the meta box content.
	 */
	public function the_content( $post ) {

		echo $this -> get_content( $post );

	}

	/**
	 * Get the meta box content.
	 * 
	 * @param  object $post A WP_POST.
	 * @return string       The meta box content.
	 */
	function get_content( $post ) {

		$out = '';

		$post_id   = absint( $post -> ID );
		$post_type = $post -> post_type;

		// Grab the meta values for this post.
		$values = array();
		if( ! empty( $post_id ) ) {
			$values = $this -> post_meta_fields -> get_values( $post_id );
		}

		// Grab the meta field inputs.
		$fields = $this -> meta_fields;

		// Loop through the array of sections and inputs.
		$count = count( $fields );
		$i     = 0;
		foreach( $fields as $meta_field_post_type => $meta_box ) {

			if( $post_type != $meta_field_post_type ) { continue; }

			foreach( $meta_box['sections'] as $section_id => $section ) {

				if( isset( $section['condition'] ) ) {
					$condition = $this -> parse_callable( $section['condition'] );
					if( ! $condition ) { continue; }
				}

				$i++;

				// The label for this section.
				$section_label = $section['label'];

				// Loop through the settings in this section.
				$settings     = $section['settings'];
				$settings_out = '';

				if( isset( $settings['items_cb'] ) ) {

					$type = $settings['type'];

					$cb_settings = $this -> parse_callable( $settings['items_cb'] );

					$cb_settings_out = array();

					foreach( $cb_settings as $setting_id => $setting ) {

						//wp_die( var_dump( $setting_id, $setting ) );

						$setting['type'] = $type;

						$cb_settings_out[ $setting_id  ] = $setting;

					}

					$settings = $cb_settings_out;

				}

				foreach( $settings as $setting_id => $setting ) {

					// Grab the value for this setting.
					$value = FALSE;
					
					$value_key = "$section_id-$setting_id";

					if( isset( $values[ $value_key ] ) ) {
						$value = $values[ $value_key ];
					}

					if( empty( $value ) ) { 
						if( isset( $setting['default'] ) ) {
							$value = $setting['default'];
						}
					}

					// Grab the input for this setting.
					$settings_out .= $this -> get_field( $post_id, $value, $section_id, $setting_id, $setting );

				}			

				// Wrap this section.
				$out .= "
					<br>
					<fieldset>
						<legend>
							<h4>$section_label</h4>
						</legend>
						<br>
						<div>$settings_out</div>
					</fieldset>
				";

				if( $i < $count ) {
					$out .= "<br><hr>";
				}

			}

		}

		// Add an nonce field so we can check for it later.
		$nonce = wp_nonce_field( 'save', DRAFTPRESS . '-meta_box', TRUE, FALSE );

		$out = "
			$nonce
			$out
			$nonce
		";

		return $out;

	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save_post( $post_id, $post, $update ) {

		// Are we on the right page?
		if( ! $this -> is_current_page( $post -> post_type ) ) { return $post_id; }

		// Was the meta box submit?
		if ( ! isset( $_POST[ DRAFTPRESS . '-meta_box' ] ) ) {
			return $post_id;
		}

		// Check the nonce.
		$nonce = $_POST[ DRAFTPRESS . '-meta_box' ];
		if ( ! wp_verify_nonce( $nonce, 'save' ) ) {
			return $post_id;
		}

		// Is this an autosave?
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Are we in ajax-land?
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return $post_id;
		}

		// Is this a revision?
		if( wp_is_post_revision( $post_id ) ) {
			return $post_id;
		}

		// Is the user allowed to do this?
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Check if there was a multisite switch before saving.
		if ( is_multisite() && ms_is_switched() ) {
			return $post_id;
		}

		$old_values = $this -> post_meta_fields -> get_values( $post_id );

		// Grab and clean the data.
		$posted_data = $_POST[ DRAFTPRESS ];

		$posted_data = $this -> sanitize( $posted_data );
		$this -> update_meta( $post_id, $posted_data );

		return $post_id;

	}

	function update_meta( $post_id, $posted_data ) {

		$out = array();

		$post_type = get_post_type( $post_id );

		$field = $this -> meta_fields[ $post_type ];

		$sections = $field[ 'sections' ];

		foreach( $sections as $section_id => $section ) {

			$condition = TRUE;
			if( isset( $section['condition'] ) ) {
				$condition = $this -> parse_callable( $section['condition'] );
				if( ! $condition ) { continue; }
			}

			$settings = $section['settings'];

			if( isset( $settings['items_cb'] ) ) {

				$type = $settings['type'];

				$cb_settings = $this -> parse_callable( $settings['items_cb'] );

				$settings = $cb_settings;

			}

			foreach( $settings as $setting_id => $setting ) {

				if( $setting['type'] != 'checkbox' ) {
					if( ! isset( $posted_data[ "$section_id-$setting_id" ] ) ) { continue; }
				}

				$value = $posted_data[ "$section_id-$setting_id" ];

				$out[ "$section_id-$setting_id" ][$value] = update_post_meta( $post_id, "$section_id-$setting_id", $value );

			}

		}

		return $out;

	}	

}