<?php
/**
 * WordPass admin functions
 * 
 * This file is part of the WordPass plugin by Chad Butler
 * You can find out more about this plugin at http://devbitz.com
 *
 * @package WordPass
 * @author Chad Butler
 *
 * Functions Included:
 * - wordpass_add_page
 * - wordpass_render_option_page
 * - wordpass_admin_init
 * - wordpass_setting_input
 * - wordpass_case_input
 * - wordpass_validate_options
 * - wordpass_admin_plugin_links
 */


/**
 * Add a menu for the options page.
 *
 * @since 1.0
 */
function wordpass_add_page() {
	add_options_page( 
		__( 'WordPass Passwords', 'wordpass' ), // $page_title
		__( 'WordPass', 'wordpass' ),           // $menu_title
		'manage_options',                       // $capability
		'wordpass',                             // $menu_slug
		'wordpass_render_option_page'           // callback
	);
}


/**
 * Display the options page.
 *
 * @since 1.0
 */
function wordpass_render_option_page() { ?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php print $GLOBALS['title']; ?></h2>
		<form action="options.php" method="post"><?php 
			settings_fields( 'wordpass_options' );
			do_settings_sections( 'wordpass' );
			submit_button(); ?>
		</form>
	</div><?php
}


/**
 * Register and define the settings.
 *
 * @since 1.0
 *
 * @global object $wordpass The WordPass object.
 */
function wordpass_admin_init() {
	// Register settings.
	register_setting( 'wordpass_options', 'wordpass_options', 'wordpass_validate_options' );
	
	global $wordpass;
	$wordpass->get_options();
	
	add_settings_section( 'wordpass_main', '', '', 'wordpass' );
	add_settings_field( 'wordpass_word_case', __( 'Choose case setting', 'wordpass' ), 'wordpass_settings_word_case', 'wordpass', 'wordpass_main' );
	add_settings_field( 'wordpass_word_list', __( 'Enter words here, separated by commas', 'wordpass' ), 'wordpass_settings_word_list', 'wordpass', 'wordpass_main' );
}


/**
 * Display the case selection option.
 *
 * @since 1.0
 *
 * @global object $wordpass The WordPass object.
 */
function wordpass_settings_word_case() {
	global $wordpass;
	echo '
	<select name="wordpass_options[word_case]">
		<option value="1" ' . selected( $wordpass->options['word_case'], 1, false ) . '>' . __( 'All Lowercase', 'wordpass' ) . '</option>
		<option value="2" ' . selected( $wordpass->options['word_case'], 2, false ) . '>' . __( 'All Uppercase', 'wordpass' ) . '</option>
		<option value="3" ' . selected( $wordpass->options['word_case'], 3, false ) . '>' . __( 'First Letter Uppercase', 'wordpass' ) . '</option>
		<option value="4" ' . selected( $wordpass->options['word_case'], 4, false ) . '>' . __( 'Random', 'wordpass' ) . '</option>
	</select>';
}


/**
 * Display and fill the form field.
 *
 * @since 1.0
 *
 * @global object $wordpass The WordPass object.
 */
function wordpass_settings_word_list() {
	global $wordpass;
	$word_list = $wordpass->options['word_list'];
	// The word list is an array, convert it to a comma separated string.
	$word_list = ( is_array( $word_list ) ) ? implode( ', ', $word_list ) : $word_list;
	echo '<textarea id="word_list" name="wordpass_options[word_list]" rows="5" class="large-text code">' . esc_html( $word_list ) . '</textarea><br />
		<span class="description">' . __( 'WordPass will add random numbers and randomly a special character (like !, @, #, etc.) to the selected word.', 'wordpass' ) . '</span>';
}


/**
 * Validate user input (we want text only)
 *
 * @since 1.0
 *
 * @param $input
 */
function wordpass_validate_options( $input ) {
	$valid = array();
	$valid['word_case'] = intval( $input['word_case'] );
	$valid['word_list'] = preg_replace( '/[^a-zA-Z,]/', '', sanitize_text_field( $input['word_list'] ) );
	return $valid;
}


/**
 * Add settings link to plugin panel.
 *
 * @since 1.0
 *
 * @param  array  $links
 * @param  string $file
 * @static string $wordpass_plugin
 * @return array  $links
 */
function wordpass_admin_plugin_links( $links, $file ) {
	static $wordpass_plugin;
	if ( ! $wordpass_plugin ) {
		$wordpass_plugin = plugin_basename( WORDPASS_PATH . 'wordpass.php' );
	}
	if ( $file == $wordpass_plugin ) {
		$settings_link = '<a href="options-general.php?page=wordpass">' . __( 'Settings', 'wordpass' ) . '</a>';
		$links = array_merge( array( $settings_link ), $links );
	}
	return $links;
}


// End of file.