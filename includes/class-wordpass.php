<?php
/**
 * The WordPass Class.
 *
 * This file is part of the WordPass plugin by Chad Butler
 * You can find out more about this plugin at http://devbitz.com
 *
 * @since 1.0
 *
 * @package WordPass
 * @author Chad Butler
 */
class WordPass {
	
	/**
	 * Contains the plugin options.
	 *
	 * @since 1.0
	 * @access public
	 * @var array $options An array of the plugin settings.
	 */
	public $options;

	/**
	 * Initialization function.
	 *
	 * @since 1.0
	 */	
	function __construct() {

		// Filter WP's random_password.
		add_filter( 'random_password', array( $this, 'do_wordpass'  ) );
	}
	
	/**
	 * Gets the plugin options if needed.
	 *
	 * @since 1.0
	 */
	public function get_options() {
		$options = get_option( 'wordpass_options' );
		// If no options have been saved, set up defaults.
		if ( ! $options ) {
			$options = array(
				'word_case' => 4,
				'word_list' => array( 'cryptograph', 'extravaganza', 'hypercomplex', 'inspiration', 'urbanization', 'maximization', 'vanquishable', 'nonobjective', 'maximization' ),
			);
		}
		$this->options = $options;	
	}

	/**
	 * Assembles and returns a password.
	 *
	 * @since 1.0
	 *
	 * @return string $password An assembled password.
	 */
	public function do_wordpass() {
		
		// Get plugin options.
		$this->get_options();
		
		// Get numbers.
		$number = $this->do_number();
		
		// Get special characters.
		$special = $this->do_special();
		
		// Assemble array with password.
		$password   = ( $special ) ? array_merge( $number, $special ) : $number;
		$password[] = $this->rand_word();
		
		// Shuffle the array.
		shuffle( $password );

		// Return the result as a string.
		return implode( $password );
	}

	/**
	 * Return a random word password.
	 *
	 * @since 1.0
	 *
	 * @return string $password A password consisting of a word from a given list.
	 */
	private function rand_word() {

		if ( $this->options && isset( $this->options['word_list'] ) ) {
			
			// Cast word_list as an array.
			if ( ! is_array( $this->options['word_list'] ) ) {
				$this->options['word_list'] = explode( ',', $this->options['word_list'] );
			}

			// Pick a random word from the word list.
			$root = array_rand( $this->options['word_list'], 1 );
			$root = $this->options['word_list'][ $root ];

			// Handle password case.
			$case = ( isset( $this->options['word_case'] ) ) ? $this->options['word_case'] : 1;
			$case = ( 4 == $case ) ? mt_rand( 1, 3 ) : $case;
			if ( 2 == $case ) {
				// All upper case.
				$word = strtoupper( $root );
			} elseif ( 3 == $case ) {
				// First letter uppercase.
				$word = ucfirst( $root );
			} else {
				// All lower case (default).
				$word = strtolower( $root );
			}

			// Return the word.
			return esc_html( $word );
		}
		return;
	}

	/**
	 * Generates random numbers to add to the password.
	 *
	 * @since 1.0
	 */
	private function do_number() {
		// Generate a range of numbers.
		$digits = mt_rand( 1, 3 );
		$second = ( $digits == 1 ) ? 9 : ( ( $digits == 2 ) ? 99 : 999 );
		$number = mt_rand( 0, $second );
		return array_map( 'intval', str_split( $number ) );
	}

	/**
	 * Generates random special characters to add to the password.
	 *
	 * @since 1.0
	 */
	private function do_special() {
		// Random selection to add a special character or not.
		$num_chars = mt_rand( 0, 1 );
		if ( $num_chars ) {
			$special_chars = str_split( "!@#$%&*=+?" );
			$special_array = array( 
				$special_chars[ array_rand( $special_chars, 1 )]
			);
		}
		return ( $num_chars ) ? $special_array : null;
	}
}

// End of file.