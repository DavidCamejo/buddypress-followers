<?php
/**
 * Plugin Name: BuddyPress Followers
 * Plugin URI:  https://github.com/your-repo/buddypress-followers
 * Description: Follow members on your BuddyPress site.
 * Version:     2.0.0
 * Author:      Your Name
 * Author URI:  https://your-site.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: buddypress-followers
 * Domain Path: /languages/
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Requires Plugins: buddypress
 */

defined('ABSPATH') || exit;

// Define plugin constants
define('BP_FOLLOWERS_VERSION', '2.0.0');
define('BP_FOLLOWERS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BP_FOLLOWERS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('BP_FOLLOWERS_PLUGIN_FILE', __FILE__);

// Autoload classes
require_once BP_FOLLOWERS_PLUGIN_DIR . 'vendor/autoload.php';

// Initialize the plugin
add_action('bp_loaded', function() {
    if (!class_exists('BuddyPress\\Followers\\Plugin')) {
        require_once BP_FOLLOWERS_PLUGIN_DIR . 'includes/classes/Plugin.php';
    }
    
    BuddyPress\Followers\Plugin::instance();
});