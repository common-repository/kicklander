<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Kicklander_Helpers
 *
 * This class contains repetitive functions that
 * are used globally within the plugin.
 *
 * @package		KICKLANDER
 * @subpackage	Classes/Kicklander_Helpers
 * @author		Kicklander
 * @since		1.0.0
 */
class Kicklander_Helpers{

	/**
	 * ######################
	 * ###
	 * #### CALLABLE FUNCTIONS
	 * ###
	 * ######################
	 */

	/**
	 * HELPER COMMENT START
	 *
	 * Within this class, you can define common functions that you are 
	 * going to use throughout the whole plugin. 
	 * 
	 * Down below you will find a demo function called output_text()
	 * To access this function from any other class, you can call it as followed:
	 * 
	 * KICKLANDER()->helpers->output_text( 'my text' );
	 * 
	 */
	 
	/**
	 * Output some text
	 *
	 * @param	string	$text	The text to output
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	 public function output_text( $text = '' ){
		 echo esc_html( $text );
	 }

	 /**
	  * HELPER COMMENT END
	  */

}
