<?php
/**
 * Kicklander
 *
 * @package       KICKLANDER
 * @author        Kicklander
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Kicklander
 * Plugin URI:    https://www.kicklander.com
 * Description:   Create In-Site FOMO Notifications to Leverage Your ROI.
 * Version:       1.0.0
 * Author:        Kicklander
 * Author URI:    https://www.kicklander.com
 * Text Domain:   kicklander
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with Kicklander. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * HELPER COMMENT START
 * 
 * This file contains the main information about the plugin.
 * It is used to register all components necessary to run the plugin.
 * 
 * The comment above contains all information about the plugin 
 * that are used by WordPress to differenciate the plugin and register it properly.
 * It also contains further PHPDocs parameter for a better documentation
 * 
 * The function KICKLANDER() is the main function that you will be able to 
 * use throughout your plugin to extend the logic. Further information
 * about that is available within the sub classes.
 * 
 * HELPER COMMENT END
 */

// Plugin name
define( 'KICKLANDER_NAME',          'Kicklander' );

// Plugin version
define( 'KICKLANDER_VERSION',       '1.0.0' );

// Plugin Root File
define( 'KICKLANDER_PLUGIN_FILE',   __FILE__ );

// Plugin base
define( 'KICKLANDER_PLUGIN_BASE',   plugin_basename( KICKLANDER_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'KICKLANDER_PLUGIN_DIR',    plugin_dir_path( KICKLANDER_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'KICKLANDER_PLUGIN_URL',    plugin_dir_url( KICKLANDER_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once KICKLANDER_PLUGIN_DIR . 'core/class-kicklander.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Kicklander
 * @since   1.0.0
 * @return  object|Kicklander
 */
// Add a new menu item to the admin menu
function kicklander_add_menu_item() {
    add_menu_page(
        'Settings',
        'Kicklander',
        'manage_options',
        'kicklander-settings',
        'kicklander_render_settings_page',
        KICKLANDER_PLUGIN_URL . 'core/includes/assets/images/favicon.png',
        99
    );
}
add_action( 'admin_menu', 'kicklander_add_menu_item' );

// Render the settings page
function kicklander_enqueue_scripts() {
    // Enqueue CSS
    wp_enqueue_style('kicklander', plugins_url('core/includes/assets/css/kicklander.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'kicklander_enqueue_scripts');

function kicklander_render_settings_page() {
    ?>

    <div id="kicklander" class="wrap">
        <img src="<?php echo KICKLANDER_PLUGIN_URL . 'core/includes/assets/images/kicklander.svg'; ?>" class="kicklander-logo">

        <form method="post" action="options.php">
            <?php settings_fields( 'kicklander-settings-group' ); ?>
            <?php do_settings_sections( 'kicklander-settings-group' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e( 'API Key', 'kicklander' ); ?></th>
                    <td><input type="text" name="kicklander_api_key" value="<?php echo esc_attr( get_option( 'kicklander_api_key' ) ); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register settings
function kicklander_register_settings() {
    register_setting( 'kicklander-settings-group', 'kicklander_api_key' );
}
add_action( 'admin_init', 'kicklander_register_settings' );

// Embed script on front-end
function kicklander_enqueue_script() {
    $api_key = get_option( 'kicklander_api_key' );
    if ( $api_key ) {
        $escaped_url = esc_url( 'https://app.kicklander.com/pixel/' . $api_key );
        wp_enqueue_script( 'kicklander-script', $escaped_url, array(), '', true );
    }
}
add_action( 'wp_enqueue_scripts', 'kicklander_enqueue_script' );

