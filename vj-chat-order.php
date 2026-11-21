<?php
/**
 * Plugin Name: VJ Chat Connect
 * Plugin URI: https://github.com/VJ-Ranga/VJ-Chat-Connect
 * Description: Adds a WooCommerce order button and a simple WhatsApp chat button via shortcode, allowing customers to contact you directly.
 * Version: 2.1.1
 * Author: VJ Ranga
 * Author URI: https://vjranga.com/
 * Text Domain: vj-chat-order
 * Domain Path: /languages
 * Requires at least: 5.8
 * Tested up to: 6.7
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 9.5
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Bail out if another copy of this plugin (or the older VJ Chat Order for
// WooCommerce, which shares the same function names) is already loaded.
// Loading both causes a "Cannot redeclare function" fatal error on activation.
if (defined('VJ_CHAT_VERSION') || function_exists('vj_chat_get_user_active_tab')) {
    add_action('admin_notices', function () {
        if (!current_user_can('activate_plugins')) {
            return;
        }
        echo '<div class="notice notice-error"><p>';
        echo esc_html__('VJ Chat Connect is not running because another copy of it (or VJ Chat Order for WooCommerce) is already active. Deactivate the other plugin, then keep only one.', 'vj-chat-order');
        echo '</p></div>';
    });
    return;
}

// Define plugin constants
define('VJ_CHAT_VERSION', '2.1.1');
define('VJ_CHAT_PLUGIN_FILE', __FILE__);
define('VJ_CHAT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('VJ_CHAT_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once VJ_CHAT_PLUGIN_DIR . 'inc/core.php';
