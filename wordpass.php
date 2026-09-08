<?php
/*
Plugin Name: WordPass Random Word Passwords
Plugin URI:  http://devbitz.com/plugins/wordpass/
Description: Creates random word based passwords.
Version:     1.0.1
Author:      Chad Butler
Author URI:  http://butlerblog.com/
License:     GPLv2
Text Domain: wordpass
*/

 
/*  
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	You may also view the license here:
	http://www.gnu.org/licenses/gpl.html
*/


/**
 * The plugin path.
 *
 * @since 1.0
 * @var string The path to the plugin directory. 
 */
define( 'WORDPASS_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );


add_action( 'init', 'wordpass_init' );


/**
 * Initialize the plugin.
 *
 * @since 1.0
 *
 * @global object $wordpass The WordPass object.
 */
function wordpass_init() {

	global $wordpass;
	require_once( WORDPASS_PATH . 'includes/class-wordpass.php' );
	$wordpass = new WordPass();

	// Load admin if necessary.
	if ( is_admin() && current_user_can( 'manage_options' ) ) {
		require_once( WORDPASS_PATH . 'admin/admin.php' );
		add_action( 'admin_init', 'wordpass_admin_init' );
		add_action( 'admin_menu', 'wordpass_add_page' );
		add_filter( 'plugin_action_links', 'wordpass_admin_plugin_links', 10, 2 );
	}
}

// End of file.