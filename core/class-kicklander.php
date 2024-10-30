<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * HELPER COMMENT START
 * 
 * This is the main class that is responsible for registering
 * the core functions, including the files and setting up all features. 
 * 
 * To add a new class, here's what you need to do: 
 * 1. Add your new class within the following folder: core/includes/classes
 * 2. Create a new variable you want to assign the class to (as e.g. public $helpers)
 * 3. Assign the class within the instance() function ( as e.g. self::$instance->helpers = new Kicklander_Helpers();)
 * 4. Register the class you added to core/includes/classes within the includes() function
 * 
 * HELPER COMMENT END
 */

if ( ! class_exists( 'Kicklander' ) ) :

	/**
	 * Main Kicklander Class.
	 *
	 * @package		KICKLANDER
	 * @subpackage	Classes/Kicklander
	 * @since		1.0.0
	 * @author		Kicklander
	 */
	final class Kicklander {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Kicklander
		 */
		private static $instance;

		/**
		 * KICKLANDER helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Kicklander_Helpers
		 */
		public $helpers;

		/**
		 * KICKLANDER settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Kicklander_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'kicklander' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'kicklander' ), '1.0.0' );
		}

		/**
		 * Main Kicklander Instance.
		 *
		 * Insures that only one instance of Kicklander exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Kicklander	The one true Kicklander
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Kicklander ) ) {
				self::$instance					= new Kicklander;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Kicklander_Helpers();
				self::$instance->settings		= new Kicklander_Settings();

				//Fire the plugin logic
				new Kicklander_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'KICKLANDER/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once KICKLANDER_PLUGIN_URL . 'core/includes/classes/class-kicklander-helpers.php';
			require_once KICKLANDER_PLUGIN_URL . 'core/includes/classes/class-kicklander-settings.php';

			require_once KICKLANDER_PLUGIN_URL . 'core/includes/classes/class-kicklander-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'kicklander', FALSE, dirname( plugin_basename( KICKLANDER_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.