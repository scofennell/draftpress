<?php

/**
 * A class for drawing the Waiver Alert subsite settings page.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 */

namespace DraftPress;

class SubsiteControlPanel {

	function __construct() {

		// Grab the array of settings.
		$subsite_settings                = new SubsiteSettings;
		$this -> subsite_settings_array  = $subsite_settings -> get_settings_array();
		$this -> subsite_settings_values = $subsite_settings -> get_settings_values();
		$this -> subsite_settings_slug   = $subsite_settings -> get_settings_slug();

		$this -> import = new Import;

		// Grab our plugin label.
		$meta                 = new Meta;
		$this -> plugin_label = $meta -> get_label();
		$this -> parent_page  = $meta -> get_parent_page();		

		// Add our menu item.
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		// Register our settings.
		add_action( 'admin_init', array( $this, 'register' ) );

		add_action( 'admin_notices', array( $this, 'handle_import' ) );	
		
		add_action( 'admin_notices', array( $this, 'handle_crawl' ) );				
		
	}

	/**
	 * Add our settings page to the admin menu.
	 * 
	 * It's not required to return a value, but the resulting string
	 * can be useful for debugging, as it's sniffable in WP_Screen / get_current_screen().
	 * 
	 * @return string The hookname for our settings page.
	 */
	public function admin_menu() {

		// Set up args for add_menu_page.
		$page_title = $this -> plugin_label;
		$menu_title = $this -> plugin_label;
		$capability = 'update_core';
		$menu_slug  = $this -> subsite_settings_slug;
		$function   = array( $this, 'the_page' );
	
		// Add the page and store the resultant hookname.
		$hookname = add_menu_page(
			$page_title,
			$menu_title,
			$capability,
			$menu_slug,
			$function
		);

		return $hookname;

	}

	/**
	 * Echo the admin page.
	 */
	public function the_page() {

		$out = $this -> get_page( $_POST );

		echo $out;

	}

	/**
	 * Grab the HTML output for our admin page.
	 * 
	 * @return string The HTML output for our admin page.
	 */
	public function get_page( $posted_data ) {
		
		do_action( 'before_dp_settings' );

		$out = '';

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		// Start an output buffer since some of these functions always echo.
		ob_start();

		// Dump the nonce and some other hidden form stuff into the OB.
		settings_fields( $this -> subsite_settings_slug );

		// Dump the form inputs into the OB.
		do_settings_sections( $this -> subsite_settings_slug );

		// Grab the stuff from the OB, clean the OB.
		$settings = ob_get_clean();

		// Grab a submit button.
		$submit = $this -> get_submit_button();

		// Grab a page title.
		$page_title = $this -> plugin_label;



		

		$import  = $this -> import;
		$players = $import -> get_crawl_results();

		$player_count = 0;
		if( $players['crawled'] ) {
			$player_count = count( $players['crawled'] );
		}

		$crawl_form  = '';
		$import_form = '';
		if( empty( $player_count ) ) {

			$crawl_title    = esc_html__( 'Crawl Player Data', 'dp' );
			$crawl_preamble = esc_html__( 'Crawl Player Data', 'dp' );
			$get_crawl_form  = $this -> get_crawl_form();

			$crawl_form = "
				<div class='$class-crawl'>
					<h2>$crawl_title</h2>
					<p>$crawl_preamble</p>
					$get_crawl_form
				</div>	
			";

		} else {

			$import_title    = esc_html__( 'Import Player Data', 'dp' );
			$import_preamble = sprintf( esc_html__( 'Import data for %d players.', 'dp' ), $player_count );
			$get_import_form  = $this -> get_import_form();		

			$import_form = "
				<div class='$class-import'>
					<h2>$import_title</h2>
					<p>$import_preamble</p>
					$get_import_form
				</div>
			";

		}



		// Nice!  Time to build the page!
		$out = "
			<div class='wrap'>

				<div class='$class-settings'>
					<h1>$page_title</h1>
					<form method='POST' action='options.php'>
						$settings
						<p>$submit</p>
					</form>
				</div>

				<div class='$class-import_forms'>
					$crawl_form
					$import_form			
				</div>

			</div>
		";

		return $out;

	}

	/**
	 * Get an HTML input of the submit type.
	 * 
	 * @return string An HTML input of the submit type.
	 */
	public function get_submit_button() {

		// Args for get_submit_button().
		$text             = esc_html__( 'Submit', 'dp' );
		$type             = 'primary';
		$name             = 'submit';
		$wrap             = FALSE;
		$other_attributes = array();

		// Grab the submit button.
		$out = get_submit_button(
			$text,
			$type,
			$name,
			$wrap,
			$other_attributes
		);

		return $out;

	}

	/**
	 * Loop through our settings and register them.
	 */
	public function register() {

		// For each section of settings...
		foreach( $this -> subsite_settings_array as $settings_section_id => $settings_section ) {

			// Grab the title.
			$settings_section_label = $settings_section['label'];
			
			// Add the section.
			add_settings_section(
				
				// The ID for this settings section.
				$settings_section_id,

				// The title for this settings section.
				$settings_section_label,

				// Could provide a cb function here to output some help text, but don't need to.
				FALSE,

				// Needs to match the first arg in register_setting().
				$this -> subsite_settings_slug

			);

			// For each setting in this section...
			foreach( $settings_section['settings'] as $setting_id => $setting ) {

				// The setting title.
				$label = $setting['label'];

				// The cb to draw the input for this setting.
				$callback = array( $this, 'the_field' );

				/**
				 * $args to pass to $callback.
				 * We'll pass it the setting as an array member of the settings section.
				 */
				$args[ $settings_section_id ][ $setting_id ] = $setting;

				// Add the settings field.
				add_settings_field(
					
					$setting_id,
					$label,
					
					// Echo the form input.
					$callback,
					
					// Matches the value in do_settings_sections().
					$this -> subsite_settings_slug,
					
					// Matches the first arg in add_settings_section().
					$settings_section_id,

					// Passed to $callback.
					$args
				
				);

			}

		}

		// Designate a sanitization function for our settings.
		$sanitize_callback = array( $this, 'sanitize' );

		// Register the settings!
		register_setting(

			// Matches the value in settings_fields().
			$this -> subsite_settings_slug,

			// The name for our option in the DB.
			$this -> subsite_settings_slug,
			
			// The callback function for sanitizing values.
			$sanitize_callback
		
		);

	}

	/**
	 * A sanitization callback for the third arg in register_setting().
	 * 
	 * @param  array $dirty The user-supplied values for our subsite settings.
	 * @return array        The user-supplied values for our subsite settings, cleaned.
	 */
	function sanitize( $dirty ) {

		return array_map( 'wp_kses_post', $dirty );

	}

	/**
	 * Output an HTML form field.
	 * 
	 * @param  array $args An array of args from add_settings_field(). Contains settings section and setting.
	 */
	public function the_field( $args = array() ) {
	
		$out = $this -> get_field( $args );

		echo $out;

	}

	/**
	 * Get an HTML form field.
	 * 
	 * @param  array  $args An array of args from add_settings_field(). Contains settings section and setting.
	 * @return string An HTML form field.
	 */
	public function get_field( $args = array() ) {

		$out = '';

		// Get our plugin option.  We'll need it to prepopulate the form fields.
		$data = $this -> subsite_settings_values;

		// For each settings section...
		foreach( $args as $settings_section_id => $settings ) {

			// For each setting...
			foreach( $settings as $setting_id => $setting ) {

				// What sort of input is it?
				$type = $setting['type'];

				// Some helpful UI text.
				$notes = $setting['notes'];				

				// The ID for the input, expected by the <label for=''> that get's printed via do_settings_sections().
				$id    = "$settings_section_id-$setting_id";

				/**
				 * The name of this setting.
				 * It's a member of the section array, which in turn is a member of the plugin array.
				 */
				$name = $this -> subsite_settings_slug . '[' . $settings_section_id . ']' . '[' . $setting_id . ']';			
				
				/**
				 * Reach into the database value and find the value for this setting, in this section.
				 */
				$value = '';
				if( isset( $data[ $settings_section_id ] ) ) {
					if( isset( $data[ $settings_section_id ][ $setting_id ] ) ) {
						$value = $data[ $settings_section_id ][ $setting_id ];
					}
				}

				if( $type == 'textarea' ) {

					$value = esc_textarea( $value );

					$out = "
						<textarea style='min-height: 10em;' class='widefat' name='$name' id='$id'>$value</textarea>
					";
				
				} else {

					$value = esc_attr( $value );

					$out = "
						<input type='$type' name='$name' id='$id' value='$value'>
					";

				}

				$out = "
					<div>
						$out
						<p><em>$notes</em></p>
					</div>
				";

			}

		}

		return $out;

	}

	function get_crawl_form() {

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		$nonce = wp_nonce_field( 'crawl', DRAFTPRESS . '-crawl-nonce', TRUE, FALSE );

		$name = DRAFTPRESS . '-crawl';

		$submit = get_submit_button( esc_attr( 'Crawl Player Data', 'dp' ), 'primary', $name, TRUE );

		$get_parent_page = $this -> parent_page;
		$current_url     = get_admin_url( NULL, $get_parent_page );
		$current_url     = add_query_arg( array( 'page' => $this -> subsite_settings_slug ), $current_url );

		$out = "
			<form action='$current_url' method='post'>
				$nonce
				$submit
			</form>
		";

		return $out;

	}

	function handle_crawl() {

		if( ! isset( $_POST[ DRAFTPRESS . '-crawl' ] ) ) { return FALSE; }

		check_admin_referer( 'crawl', DRAFTPRESS . '-crawl-nonce' );

		$import  = $this -> import;
		$results = json_encode( $import -> get_crawl_data() );

		$out = "
			<div class='notice is-dismissible updated'>
				<p>
				$results
				</p>
			</div>
		";

		echo $out;
		
	}

function get_import_form() {

		$class = sanitize_html_class( __CLASS__ . '-' . __FUNCTION__ );

		$nonce = wp_nonce_field( 'import', DRAFTPRESS . '-import-nonce', TRUE, FALSE );

		$name = DRAFTPRESS . '-import';

		$submit = get_submit_button( esc_attr( 'Import Player Data', 'dp' ), 'primary', $name, TRUE );

		$get_parent_page = $this -> parent_page;
		$current_url     = get_admin_url( NULL, $get_parent_page );
		$current_url     = add_query_arg( array( 'page' => $this -> subsite_settings_slug ), $current_url );

		$out = "
			<form action='$current_url' method='post'>
				$nonce
				$submit
			</form>
		";

		return $out;

	}

	function handle_import() {

		if( ! isset( $_POST[ DRAFTPRESS . '-import' ] ) ) { return FALSE; }

		check_admin_referer( 'import', DRAFTPRESS . '-import-nonce' );

		$import         = $this -> import;
		$import -> set_import_results();
		$results = json_encode( $import -> get_import_results() );

		$out = "
			<div class='notice is-dismissible updated'>
				<p>
				$results
				</p>
			</div>
		";

		echo $out;
		
	}	

}