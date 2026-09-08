<?php
/**
 * WordPass Uninstall
 *
 * Removes all settings WordPass added to the WP options table
 * 
 * This file is part of the WordPass plugin by Chad Butler
 * You can find out more about this plugin at http://devbitz.com
 *
 * @package WordPass
 * @author Chad Butler
 */

// If uninstall is not called from WordPress, kill the uninstall.
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die( 'invalid uninstall' );
}
 
// Uninstall process removes WordPass settings from the WordPress database (_options table).
if ( WP_UNINSTALL_PLUGIN ) {

	if ( is_multisite() ) {

		global $wpdb;
		$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
		$original_blog_id = get_current_blog_id();

		foreach ( $blog_ids as $blog_id ) {
			switch_to_blog( $blog_id );
			wordpass_uninstall_options(); 
		}
		switch_to_blog( $original_blog_id );
	
	} else {
		wordpass_uninstall_options();
	}
}


/**
 * Compartmentalizes uninstall
 *
 * @since 1.0
 */
function wordpass_uninstall_options() {
	delete_option( 'wordpass_options' );
}

// End of file.