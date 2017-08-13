<?php

/**
 * A fantasy football rankings plugin.
 *
 * @package WordPress
 * @subpackage DraftPress
 * @since DraftPress 0.1
 * 
 * Plugin Name: DraftPress
 * Description: A fantasy football rankings plugin.
 * Author: Scott Fennell
 * Version: 0.1
 * Author URI: http://scottfennell.org
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
	
// Peace out if you're trying to access this up front.
if( ! defined( 'ABSPATH' ) ) { exit; }

// Watch out for plugin naming collisions.
if( defined( 'DRAFTPRESS' ) ) { exit; }
if( isset( $draftpress ) ) { exit; }

// A slug for our plugin.
define( 'DRAFTPRESS', 'DraftPress' );

// Establish a value for plugin version to bust file caches.
define( 'DRAFTPRESS_VERSION', '0.1' );

// A constant to define the paths to our plugin folders.
define( 'DRAFTPRESS_FILE', __FILE__ );
define( 'DRAFTPRESS_PATH', trailingslashit( plugin_dir_path( DRAFTPRESS_FILE ) ) );

// A constant to define the urls to our plugin folders.
define( 'DRAFTPRESS_URL', trailingslashit( plugin_dir_url( DRAFTPRESS_FILE ) ) );

// Our master plugin object, which will own instances of various classes in our plugin.
$draftpress  = new stdClass();
$draftpress -> bootstrap = DRAFTPRESS . '\Bootstrap';

function get_dp() {

	global $draftpress;

	return $draftpress;

}

// Register an autoloader.
require_once( DRAFTPRESS_PATH . 'autoload.php' );

// Execute the plugin code!
new $draftpress -> bootstrap;