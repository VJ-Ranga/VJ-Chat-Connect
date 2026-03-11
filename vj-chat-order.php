<?php
/**
 * Plugin Name: VJ Chat Connect
 * Plugin URI: https://github.com/VJ-Ranga/VJ-Chat-Connect
 * Description: Adds a WooCommerce order button and a simple WhatsApp chat button via shortcode, allowing customers to contact you directly.
 * Version: 2.1.0
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

// Define plugin constants
define('VJ_CHAT_VERSION', '2.1.0');
define('VJ_CHAT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('VJ_CHAT_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Check if WooCommerce is active
 */
function vj_chat_is_woocommerce_active()
{
    return class_exists('WooCommerce');
}

/**
 * Check if WooCommerce order features are enabled
 */
function vj_chat_is_woo_enabled()
{
    return (bool) get_option('vj_chat_enable_woo', 1);
}

/**
 * Check if general chat features are enabled
 */
function vj_chat_is_chat_enabled()
{
    return (bool) get_option('vj_chat_enable_chat', 1);
}

/**
 * Check if current request is in WooCommerce coming soon mode
 */
function vj_chat_is_woo_coming_soon_page()
{
    if (!vj_chat_is_woocommerce_active()) {
        return false;
    }

    if (class_exists('Automattic\\WooCommerce\\Internal\\ComingSoon\\ComingSoonHelper')) {
        try {
            if (function_exists('wc_get_container')) {
                $helper = wc_get_container()->get(Automattic\WooCommerce\Internal\ComingSoon\ComingSoonHelper::class);
                if ($helper && method_exists($helper, 'is_current_page_coming_soon')) {
                    return (bool) $helper->is_current_page_coming_soon();
                }
            }
        } catch (Exception $e) {
            // Fall back to option check below.
        }
    }

    // Fallback for older WooCommerce versions.
    if (get_option('woocommerce_coming_soon') === 'yes') {
        if (get_option('woocommerce_store_pages_only') === 'yes') {
            return function_exists('is_product') && is_product();
        }
        return true;
    }

    return false;
}

/**
 * Get list of pages to hide chat floating button
 */
function vj_chat_get_chat_hide_pages()
{
    $raw = (string) get_option('vj_chat_chat_hide_pages', '');
    if ($raw === '') {
        return array();
    }

    $parts = preg_split('/[\r\n,]+/', $raw);
    $items = array();
    foreach ($parts as $part) {
        $part = trim($part);
        if ($part === '') {
            continue;
        }
        $items[] = $part;
    }

    return array_values(array_unique($items));
}

/**
 * Check if chat floating button should be hidden on current page
 */
function vj_chat_is_chat_hidden_on_page()
{
    if (is_admin()) {
        return false;
    }

    $items = vj_chat_get_chat_hide_pages();
    if (empty($items)) {
        return false;
    }

    $current_id = get_queried_object_id();
    $current_slug = '';
    if ($current_id) {
        $post = get_post($current_id);
        if ($post) {
            $current_slug = $post->post_name;
        }
    }

    $request_path = '';
    if (!empty($_SERVER['REQUEST_URI'])) {
        $request_path = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $request_path = trim($request_path, '/');
    }

    $current_url = $request_path !== '' ? home_url('/' . $request_path . '/') : '';

    foreach ($items as $item) {
        if ($current_id && ctype_digit($item) && intval($item) === $current_id) {
            return true;
        }

        if ($current_slug && $item === $current_slug) {
            return true;
        }

        $item_path = trim($item, '/');
        if ($request_path !== '' && $item_path === $request_path) {
            return true;
        }

        if ($current_url !== '' && rtrim($item, '/') === rtrim($current_url, '/')) {
            return true;
        }
    }

    return false;
}

/**
 * Get user's last active tab
 */
function vj_chat_get_user_active_tab()
{
    $user_id = get_current_user_id();

    // Not logged in? Use default
    if (!$user_id) {
        return 'chat';
    }

    // Get saved preference
    $active_tab = get_user_meta($user_id, 'vj_chat_active_tab', true);

    // Validate it's a real tab
    $valid_tabs = array('chat', 'woocommerce', 'design');
    if (!empty($active_tab) && in_array($active_tab, $valid_tabs)) {
        return $active_tab;
    }

    return 'chat';
}

/**
 * Save user's active tab via AJAX
 */
function vj_chat_save_active_tab()
{
    // Security check
    check_ajax_referer('vj_chat_tab_nonce', 'nonce');

    // Permission check
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized', 403);
    }

    // Get and validate tab
    $tab = isset($_POST['tab']) ? sanitize_text_field($_POST['tab']) : 'chat';

    // Only allow valid tabs
    $valid_tabs = array('chat', 'woocommerce', 'design');
    if (!in_array($tab, $valid_tabs)) {
        wp_send_json_error('Invalid tab');
    }

    // Save to user meta
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'vj_chat_active_tab', $tab);

    wp_send_json_success(array('message' => 'Tab preference saved'));
}
add_action('wp_ajax_vj_chat_save_active_tab', 'vj_chat_save_active_tab');

/**
 * Get default icon URL (local asset)
 */
function vj_chat_get_default_icon_url()
{
    return VJ_CHAT_PLUGIN_URL . 'assets/images/whatsapp-icon.svg';
}

/**
 * Include admin settings
 */
require_once VJ_CHAT_PLUGIN_DIR . 'inc/admin-settings.php';

/**
 * Load plugin textdomain
 */
function vj_chat_load_textdomain()
{
    load_plugin_textdomain('vj-chat-order', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'vj_chat_load_textdomain');

/**
 * Check if WooCommerce is active
 */
function vj_chat_check_woocommerce()
{
    if (!vj_chat_is_woocommerce_active() && vj_chat_is_woo_enabled()) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>';
            echo __('WooCommerce features are enabled, but WooCommerce is not active. Disable WooCommerce Order in the plugin settings or activate WooCommerce.', 'vj-chat-order');
            echo '</p></div>';
        });
    }
}
add_action('admin_init', 'vj_chat_check_woocommerce');

/**
 * Declare HPOS Compatibility
 */
add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

/**
 * Activation hook - set default options
 */
function vj_chat_activate()
{
    $defaults = array(
        // Chat settings
        'vj_chat_enable_chat' => 1,
        'vj_chat_chat_phone' => '947000000000',
        'vj_chat_chat_button_text' => __('Need Help? Chat with us', 'vj-chat-order'),
        'vj_chat_chat_message' => __('Hi! I need help.', 'vj-chat-order'),
        'vj_chat_chat_agent_name' => __('Customer Support', 'vj-chat-order'),
        'vj_chat_chat_agent_role' => __('Support Agent', 'vj-chat-order'),
        'vj_chat_chat_agent_avatar' => '',
        'vj_chat_chat_placement_mode' => 'floating',
        'vj_chat_chat_floating_position' => 'bottom-right',
        'vj_chat_chat_floating_offset_x' => 20,
        'vj_chat_chat_floating_offset_y' => 20,
        'vj_chat_chat_pill_bg_style' => 'solid',
        'vj_chat_chat_pill_bg_color' => '#ffffff',
        'vj_chat_chat_text_color' => '#1d2327',
        'vj_chat_chat_icon_bg_color' => '#25D366',
        'vj_chat_chat_button_style' => 'standard',
        'vj_chat_chat_font_size' => 14,
        'vj_chat_chat_hover_color' => '#f5f7f9',
        'vj_chat_chat_border_radius' => 999,
        'vj_chat_chat_padding_vertical' => 10,
        'vj_chat_chat_padding_horizontal' => 16,
        'vj_chat_chat_margin_top' => 0,
        'vj_chat_chat_margin_bottom' => 0,
        'vj_chat_chat_icon_wrap_size' => 44,
        'vj_chat_chat_icon_size' => 24,
        'vj_chat_chat_compact_size' => 44,
        'vj_chat_chat_compact_icon_size' => 24,
        'vj_chat_chat_hide_pages' => '',
        'vj_chat_chat_widget_title' => __('Start a Conversation', 'vj-chat-order'),
        'vj_chat_chat_widget_status' => __('Typically replies within a day', 'vj-chat-order'),
        'vj_chat_chat_widget_line1' => __('Hi there!', 'vj-chat-order'),
        'vj_chat_chat_widget_line2' => __('How can I help you?', 'vj-chat-order'),
        'vj_chat_chat_widget_cta' => __('Chat on WhatsApp', 'vj-chat-order'),
        'vj_chat_chat_widget_width' => 320,
        'vj_chat_chat_widget_max_height' => 0,
        'vj_chat_chat_widget_radius' => 18,
        'vj_chat_chat_widget_header_bg' => '#25D366',
        'vj_chat_chat_widget_header_text' => '#ffffff',
        'vj_chat_chat_widget_status_text' => '#e5f4dc',
        'vj_chat_chat_widget_body_bg' => '#f0f0f0',
        'vj_chat_chat_widget_bubble_bg' => '#ffffff',
        'vj_chat_chat_widget_bubble_text' => '#1d2327',
        'vj_chat_chat_widget_cta_bg' => '#25D366',
        'vj_chat_chat_widget_cta_text' => '#ffffff',
        'vj_chat_chat_widget_close_bg' => '#25D366',
        'vj_chat_chat_widget_close_text' => '#ffffff',
        'vj_chat_chat_widget_overlay_opacity' => 0.25,
        // WooCommerce Order settings
        'vj_chat_enable_woo' => 1,
        // General settings
        'vj_chat_phone_number' => '947000000000',
        'vj_chat_button_text' => __('Order via WhatsApp', 'vj-chat-order'),
        'vj_chat_icon_url' => '', // Empty means use default local icon
        'vj_chat_intro_message' => __('Hello, I\'d like to place an order:', 'vj-chat-order'),
        // Design settings
        'vj_chat_bg_color' => '#25D366',
        'vj_chat_text_color' => '#ffffff',
        'vj_chat_hover_color' => '#1ebe5d',
        'vj_chat_border_radius' => 8,
        'vj_chat_font_size' => 16,
        'vj_chat_margin_top' => 15,
        'vj_chat_margin_bottom' => 15,
        'vj_chat_padding_vertical' => 14,
        'vj_chat_padding_horizontal' => 24,
    );

    foreach ($defaults as $option => $value) {
        if (get_option($option) === false) {
            add_option($option, $value);
        }
    }
}
register_activation_hook(__FILE__, 'vj_chat_activate');

/**
 * Add Settings link to plugins page
 */
function vj_chat_add_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=vj-chat-settings">' . __('Settings', 'vj-chat-order') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'vj_chat_add_settings_link');

/**
 * Enqueue scripts and styles on product pages
 */
function vj_chat_page_has_shortcode()
{
    if (!function_exists('has_shortcode')) {
        return false;
    }

    global $post;
    if (!$post || empty($post->post_content)) {
        return false;
    }

    return has_shortcode($post->post_content, 'vj_chat_order_button');
}

function vj_chat_enqueue_assets()
{
    $should_enqueue = false;

    if (function_exists('is_product') && is_product() && vj_chat_is_woocommerce_active() && vj_chat_is_woo_enabled()) {
        $should_enqueue = true;
    }

    if (!$should_enqueue && vj_chat_is_chat_enabled() && get_option('vj_chat_chat_placement_mode', 'floating') === 'floating' && !vj_chat_is_chat_hidden_on_page()) {
        $should_enqueue = true;
    }

    if (!$should_enqueue && vj_chat_page_has_shortcode() && (vj_chat_is_chat_enabled() || (vj_chat_is_woocommerce_active() && vj_chat_is_woo_enabled()))) {
        $should_enqueue = true;
    }

    if (!$should_enqueue) {
        return;
    }

    // Enqueue CSS
    wp_enqueue_style(
        'vj-chat-style',
        VJ_CHAT_PLUGIN_URL . 'assets/css/vj-chat-style.css',
        array(),
        VJ_CHAT_VERSION
    );

    // Enqueue JS
    wp_enqueue_script(
        'vj-chat-script',
        VJ_CHAT_PLUGIN_URL . 'assets/js/vj-chat-script.js', // Updated filename
        array('jquery'),
        VJ_CHAT_VERSION,
        true
    );

    // Get current product data safely
    global $post;
    $product = null;
    if ($post && vj_chat_is_woocommerce_active()) {
        $product = wc_get_product($post->ID);
    }

    $product_name = '';
    $product_url = '';
    $currency_symbol = '';
    if (function_exists('get_woocommerce_currency_symbol')) {
        $currency_symbol = html_entity_decode(get_woocommerce_currency_symbol());
    }

    if ($product && is_a($product, 'WC_Product')) {
        $product_name = html_entity_decode(strip_tags($product->get_name()));
        $product_url = esc_url(get_permalink($product->get_id()));
    }

    // Localize script with settings and product data
    wp_localize_script('vj-chat-script', 'vjChatData', array( // Renamed wobData to vjChatData
        'phoneNumber' => get_option('vj_chat_phone_number', '947000000000'),
        'introMessage' => get_option('vj_chat_intro_message', __('Hello, I\'d like to place an order:', 'vj-chat-order')),
        'mode' => (function_exists('is_product') && is_product() && vj_chat_is_woocommerce_active() && vj_chat_is_woo_enabled() && !vj_chat_is_woo_coming_soon_page()) ? 'order' : 'chat',
        'productName' => $product_name,
        'productUrl' => esc_url_raw($product_url),
        'currencySymbol' => $currency_symbol,
        'priceDecimalSeparator' => function_exists('wc_get_price_decimal_separator') ? wc_get_price_decimal_separator() : '.',
        'priceThousandSeparator' => function_exists('wc_get_price_thousand_separator') ? wc_get_price_thousand_separator() : ',',
        'labels' => array(
            'product' => get_option('vj_chat_label_product', _x('Product', 'WhatsApp message label', 'vj-chat-order')),
            'quantity' => get_option('vj_chat_label_quantity', _x('Quantity', 'WhatsApp message label', 'vj-chat-order')),
            'price' => get_option('vj_chat_label_price', _x('Price', 'WhatsApp message label', 'vj-chat-order')),
            'total' => get_option('vj_chat_label_total', _x('Total', 'WhatsApp message label', 'vj-chat-order')),
            'link' => get_option('vj_chat_label_link', _x('Link', 'WhatsApp message label', 'vj-chat-order')),
        ),
        'icons' => array(
            'product' => get_option('vj_chat_icon_product', '🛒'),
            'quantity' => get_option('vj_chat_icon_quantity', '🔢'),
            'price' => get_option('vj_chat_icon_price', '💰'),
            'total' => get_option('vj_chat_icon_total', '💵'),
            'link' => get_option('vj_chat_icon_link', '🔗'),
        )
    ));

    // Add dynamic inline styles
    vj_chat_add_dynamic_styles();
}

/**
 * Add dynamic inline styles from settings
 */
function vj_chat_add_dynamic_styles()
{
    $button_style = get_option('vj_chat_button_style', 'standard');

    if ($button_style === 'compact') {
        $bg_color = get_option('vj_chat_compact_bg_color', '#25D366');
        $text_color = get_option('vj_chat_compact_text_color', '#ffffff');
        $hover_color = get_option('vj_chat_compact_hover_color', '#1ebe5d');
    } else {
        $bg_color = get_option('vj_chat_bg_color', '#25D366');
        $text_color = get_option('vj_chat_text_color', '#ffffff');
        $hover_color = get_option('vj_chat_hover_color', '#1ebe5d');
    }
    $border_radius = absint(get_option('vj_chat_border_radius', 8));
    $font_size = absint(get_option('vj_chat_font_size', 16));
    $margin_top = intval(get_option('vj_chat_margin_top', 15));
    $margin_bottom = intval(get_option('vj_chat_margin_bottom', 15));
    $padding_v = absint(get_option('vj_chat_padding_vertical', 14));
    $padding_h = absint(get_option('vj_chat_padding_horizontal', 24));

    // Floating settings (WooCommerce)
    $mode = get_option('vj_chat_placement_mode', 'auto');
    $floating_pos = get_option('vj_chat_floating_position', 'bottom-right');
    // $dist = absint(get_option('vj_chat_floating_distance', 20)); // Deprecated
    $offset_x = absint(get_option('vj_chat_floating_offset_x', 20));
    $offset_y = absint(get_option('vj_chat_floating_offset_y', 20));

    // Compact Mode Settings
    $compact_size = absint(get_option('vj_chat_compact_size', 44));
    // Default icon size 24px or user setting
    $compact_icon_size = absint(get_option('vj_chat_compact_icon_size', 24));

    $custom_css = "
        .vj-chat-button {
            background-color: " . esc_attr($bg_color) . " !important;
            color: " . esc_attr($text_color) . " !important;
            font-size: " . esc_attr($font_size) . "px !important;
            margin-top: " . esc_attr($margin_top) . "px !important;
            margin-bottom: " . esc_attr($margin_bottom) . "px !important;
        }
        /* Only apply shape/padding to standard button */
        .vj-chat-button:not(.vj-chat-compact) {
            border-radius: " . esc_attr($border_radius) . "px !important;
            padding: " . esc_attr($padding_v) . "px " . esc_attr($padding_h) . "px !important;
        }
        /* Compact Button Size */
        .vj-chat-compact {
            width: " . esc_attr($compact_size) . "px !important;
            height: " . esc_attr($compact_size) . "px !important;
            min-width: " . esc_attr($compact_size) . "px !important;
        }
        .vj-chat-compact .vj-chat-icon {
            width: " . esc_attr($compact_icon_size) . "px !important;
            height: " . esc_attr($compact_icon_size) . "px !important;
        }
        .vj-chat-button:hover {
            background-color: " . esc_attr($hover_color) . " !important;
            color: " . esc_attr($text_color) . " !important;
        }
    ";

    // Add Floating Position Styles if active
    if ($mode === 'floating') {
        $pos_css = "";
        switch ($floating_pos) {
            case 'bottom-left':
                $pos_css = "bottom: {$offset_y}px; left: {$offset_x}px;";
                break;
            case 'top-right':
                $pos_css = "top: {$offset_y}px; right: {$offset_x}px;";
                break;
            case 'top-left':
                $pos_css = "top: {$offset_y}px; left: {$offset_x}px;";
                break;
            case 'bottom-right':
            default:
                $pos_css = "bottom: {$offset_y}px; right: {$offset_x}px;";
                break;
        }
        $custom_css .= "
            .vj-chat-floating {
                " . $pos_css . "
                z-index: 9999 !important;
            }
        ";
    }

    // Floating settings (Chat)
    $chat_mode = get_option('vj_chat_chat_placement_mode', 'floating');
    $chat_floating_pos = get_option('vj_chat_chat_floating_position', 'bottom-right');
    $chat_offset_x = absint(get_option('vj_chat_chat_floating_offset_x', 20));
    $chat_offset_y = absint(get_option('vj_chat_chat_floating_offset_y', 20));

    if ($chat_mode === 'floating') {
        $chat_pos_css = "";
        switch ($chat_floating_pos) {
            case 'bottom-left':
                $chat_pos_css = "bottom: {$chat_offset_y}px; left: {$chat_offset_x}px;";
                break;
            case 'top-right':
                $chat_pos_css = "top: {$chat_offset_y}px; right: {$chat_offset_x}px;";
                break;
            case 'top-left':
                $chat_pos_css = "top: {$chat_offset_y}px; left: {$chat_offset_x}px;";
                break;
            case 'bottom-right':
            default:
                $chat_pos_css = "bottom: {$chat_offset_y}px; right: {$chat_offset_x}px;";
                break;
        }
        $custom_css .= "
            .vj-chat-floating-chat {
                " . $chat_pos_css . "
                z-index: 9999 !important;
            }
        ";
    }

    $chat_pill_bg_style = get_option('vj_chat_chat_pill_bg_style', 'solid');
    $chat_pill_bg_color = get_option('vj_chat_chat_pill_bg_color', '#ffffff');
    $chat_text_color = get_option('vj_chat_chat_text_color', '#1d2327');
    $chat_icon_bg_color = get_option('vj_chat_chat_icon_bg_color', '#25D366');
    $chat_font_size = absint(get_option('vj_chat_chat_font_size', 14));
    $chat_hover_color = get_option('vj_chat_chat_hover_color', '#f5f7f9');
    $chat_border_radius = absint(get_option('vj_chat_chat_border_radius', 999));
    $chat_padding_v = absint(get_option('vj_chat_chat_padding_vertical', 10));
    $chat_padding_h = absint(get_option('vj_chat_chat_padding_horizontal', 16));
    $chat_margin_top = intval(get_option('vj_chat_chat_margin_top', 0));
    $chat_margin_bottom = intval(get_option('vj_chat_chat_margin_bottom', 0));
    $chat_icon_wrap_size = absint(get_option('vj_chat_chat_icon_wrap_size', 44));
    $chat_icon_size = absint(get_option('vj_chat_chat_icon_size', 24));
    $chat_compact_size = absint(get_option('vj_chat_chat_compact_size', 44));
    $chat_compact_icon_size = absint(get_option('vj_chat_chat_compact_icon_size', 24));
    $widget_width = absint(get_option('vj_chat_chat_widget_width', 320));
    $widget_max_height = absint(get_option('vj_chat_chat_widget_max_height', 0));
    $widget_radius = absint(get_option('vj_chat_chat_widget_radius', 18));
    $widget_header_bg = get_option('vj_chat_chat_widget_header_bg', '#25D366');
    $widget_header_text = get_option('vj_chat_chat_widget_header_text', '#ffffff');
    $widget_status_text = get_option('vj_chat_chat_widget_status_text', '#e5f4dc');
    $widget_body_bg = get_option('vj_chat_chat_widget_body_bg', '#f0f0f0');
    $widget_bubble_bg = get_option('vj_chat_chat_widget_bubble_bg', '#ffffff');
    $widget_bubble_text = get_option('vj_chat_chat_widget_bubble_text', '#1d2327');
    $widget_cta_bg = get_option('vj_chat_chat_widget_cta_bg', '#25D366');
    $widget_cta_text = get_option('vj_chat_chat_widget_cta_text', '#ffffff');
    $widget_close_bg = get_option('vj_chat_chat_widget_close_bg', '#25D366');
    $widget_close_text = get_option('vj_chat_chat_widget_close_text', '#ffffff');
    $widget_overlay_opacity = floatval(get_option('vj_chat_chat_widget_overlay_opacity', 0.25));
    if ($widget_overlay_opacity < 0) {
        $widget_overlay_opacity = 0;
    }
    if ($widget_overlay_opacity > 1) {
        $widget_overlay_opacity = 1;
    }

    if ($chat_pill_bg_style === 'transparent') {
        $chat_pill_bg_color = 'transparent';
        $chat_border_color = 'transparent';
        $chat_shadow = 'none';
        $chat_hover_color = 'transparent';
    } else {
        $chat_border_color = 'transparent';
        $chat_shadow = '0 8px 20px rgba(0, 0, 0, 0.18)';
    }

    $custom_css .= "
        .vj-chat-button.vj-chat-chat:not(.vj-chat-compact) {
            color: " . esc_attr($chat_text_color) . " !important;
            font-size: " . esc_attr($chat_font_size) . "px !important;
            margin-top: " . esc_attr($chat_margin_top) . "px !important;
            margin-bottom: " . esc_attr($chat_margin_bottom) . "px !important;
        }
        .vj-chat-button.vj-chat-chat:not(.vj-chat-compact) .vj-chat-text {
            background-color: " . esc_attr($chat_pill_bg_color) . " !important;
            border-color: " . esc_attr($chat_border_color) . " !important;
            box-shadow: " . esc_attr($chat_shadow) . " !important;
            color: " . esc_attr($chat_text_color) . " !important;
            border-radius: " . esc_attr($chat_border_radius) . "px !important;
            padding: " . esc_attr($chat_padding_v) . "px " . esc_attr($chat_padding_h) . "px !important;
        }
        .vj-chat-button.vj-chat-chat:not(.vj-chat-compact) .vj-chat-icon-wrap {
            background-color: " . esc_attr($chat_icon_bg_color) . " !important;
            width: " . esc_attr($chat_icon_wrap_size) . "px !important;
            height: " . esc_attr($chat_icon_wrap_size) . "px !important;
        }
        .vj-chat-button.vj-chat-chat:not(.vj-chat-compact) .vj-chat-icon {
            width: " . esc_attr($chat_icon_size) . "px !important;
            height: " . esc_attr($chat_icon_size) . "px !important;
        }
        .vj-chat-button.vj-chat-chat:not(.vj-chat-compact):hover {
            color: " . esc_attr($chat_text_color) . " !important;
        }
        .vj-chat-button.vj-chat-chat:not(.vj-chat-compact):hover .vj-chat-text {
            background-color: " . esc_attr($chat_hover_color) . " !important;
            color: " . esc_attr($chat_text_color) . " !important;
        }
        .vj-chat-button.vj-chat-chat.vj-chat-compact {
            width: " . esc_attr($chat_compact_size) . "px !important;
            height: " . esc_attr($chat_compact_size) . "px !important;
            min-width: " . esc_attr($chat_compact_size) . "px !important;
            background-color: transparent !important;
            box-shadow: none !important;
        }
        .vj-chat-button.vj-chat-chat.vj-chat-compact .vj-chat-icon-wrap {
            width: " . esc_attr($chat_compact_size) . "px !important;
            height: " . esc_attr($chat_compact_size) . "px !important;
            background-color: " . esc_attr($chat_icon_bg_color) . " !important;
        }
        .vj-chat-button.vj-chat-chat.vj-chat-compact .vj-chat-icon {
            width: " . esc_attr($chat_compact_icon_size) . "px !important;
            height: " . esc_attr($chat_compact_icon_size) . "px !important;
        }
        .vj-chat-widget-header {
            background-color: " . esc_attr($widget_header_bg) . " !important;
            color: " . esc_attr($widget_header_text) . " !important;
        }
        .vj-chat-widget-title {
            color: " . esc_attr($widget_header_text) . " !important;
        }
        .vj-chat-widget-close {
            background-color: " . esc_attr($widget_close_bg) . " !important;
            color: " . esc_attr($widget_close_text) . " !important;
        }
        .vj-chat-widget-cta {
            background-color: " . esc_attr($widget_cta_bg) . " !important;
            color: " . esc_attr($widget_cta_text) . " !important;
        }
        .vj-chat-widget-status-dot {
            background-color: " . esc_attr($widget_cta_bg) . " !important;
        }
        .vj-chat-widget-panel {
            background-color: " . esc_attr($widget_body_bg) . " !important;
            border-radius: " . esc_attr($widget_radius) . "px !important;
            width: " . esc_attr($widget_width) . "px !important;
            max-width: calc(100% - 32px) !important;
        }
        .vj-chat-widget-body {
            background-color: " . esc_attr($widget_body_bg) . " !important;
        }
        .vj-chat-widget-bubble {
            background-color: " . esc_attr($widget_bubble_bg) . " !important;
            color: " . esc_attr($widget_bubble_text) . " !important;
        }
        .vj-chat-widget-cta-icon img {
            filter: brightness(0) invert(1);
        }
        .vj-chat-widget-status {
            color: " . esc_attr($widget_status_text) . " !important;
        }
        .vj-chat-widget-overlay {
            background: rgba(0, 0, 0, " . esc_attr($widget_overlay_opacity) . ") !important;
        }
    ";

    if ($widget_max_height > 0) {
        $custom_css .= "
            .vj-chat-widget-panel {
                max-height: " . esc_attr($widget_max_height) . "px !important;
            }
            .vj-chat-widget-body {
                overflow-y: auto;
            }
        ";
    }

    wp_add_inline_style('vj-chat-style', $custom_css);
}

/**
 * Get the icon URL (custom or default)
 */
function vj_chat_get_icon_url()
{
    $custom_icon = get_option('vj_chat_icon_url', '');
    return !empty($custom_icon) ? $custom_icon : vj_chat_get_default_icon_url();
}

/**
 * Render WhatsApp button on product page
 */
/**
 * Get Button HTML (Helper)
 */
function vj_chat_get_button_html($extra_classes = '', $args = array())
{
    $defaults = array(
        'allow_anywhere' => false,
        'mode' => 'order',
        'text' => '',
        'phone' => '',
        'intro' => '',
    );
    $args = wp_parse_args($args, $defaults);

    $mode = ($args['mode'] === 'chat') ? 'chat' : 'order';
    if ($mode === 'chat' && strpos($extra_classes, 'vj-chat-chat') === false) {
        $extra_classes = trim($extra_classes . ' vj-chat-chat');
    }
    if ($mode === 'chat' && !vj_chat_is_chat_enabled()) {
        return '';
    }

    if ($mode === 'order') {
        if (!vj_chat_is_woocommerce_active() || !vj_chat_is_woo_enabled()) {
            return '';
        }

        if (!$args['allow_anywhere']) {
            if (!function_exists('is_product') || !is_product()) {
                return '';
            }
        }
    }
    $button_text = $args['text'] !== '' ? $args['text'] : ($mode === 'chat'
        ? get_option('vj_chat_chat_button_text', __('Need Help? Chat with us', 'vj-chat-order'))
        : get_option('vj_chat_button_text', __('Order via WhatsApp', 'vj-chat-order')));
    $button_text = esc_html($button_text);
    $icon_url = esc_url(vj_chat_get_icon_url());
    $style = $mode === 'chat'
        ? get_option('vj_chat_chat_button_style', 'standard')
        : get_option('vj_chat_button_style', 'standard');

    if ($mode === 'chat' && $style === 'compact' && strpos($extra_classes, 'vj-chat-compact') === false) {
        $extra_classes = trim($extra_classes . ' vj-chat-compact');
    }

    $phone = $args['phone'] !== '' ? $args['phone'] : ($mode === 'chat'
        ? get_option('vj_chat_chat_phone', '947000000000')
        : '');
    $intro = $args['intro'] !== '' ? $args['intro'] : ($mode === 'chat'
        ? get_option('vj_chat_chat_message', __('Hi! I need help.', 'vj-chat-order'))
        : '');

    $data_attrs = ' data-mode="' . esc_attr($mode) . '"';
    if (!empty($phone)) {
        $data_attrs .= ' data-phone="' . esc_attr($phone) . '"';
    }
    if (!empty($intro)) {
        $data_attrs .= ' data-intro="' . esc_attr($intro) . '"';
    }

    $output = '<a href="#" class="vj-chat-button vj-chat-order-btn ' . esc_attr($extra_classes) . '"' . $data_attrs . '>';
    if ($mode === 'chat' || strpos($extra_classes, 'vj-chat-chat') !== false) {
        $output .= '<span class="vj-chat-icon-wrap"><img src="' . $icon_url . '" alt="WhatsApp" class="vj-chat-icon"><span class="vj-chat-icon-close" aria-hidden="true">&times;</span></span> ';
    } else {
        $output .= '<img src="' . $icon_url . '" alt="WhatsApp" class="vj-chat-icon"> ';
    }

    if ($style !== 'compact') {
        $output .= '<span class="vj-chat-text">' . $button_text . '</span>';
    }

    $output .= '</a>';

    return $output;
}

/**
 * Render WhatsApp button (Action Hook Callback)
 */
function vj_chat_render_button()
{
    if (!vj_chat_is_woocommerce_active() || !vj_chat_is_woo_enabled()) {
        return;
    }

    if (vj_chat_is_woo_coming_soon_page()) {
        return;
    }

    $mode = get_option('vj_chat_placement_mode', 'auto');
    if ($mode === 'floating' && vj_chat_is_chat_enabled() && get_option('vj_chat_chat_placement_mode', 'floating') === 'floating' && !vj_chat_is_chat_hidden_on_page()) {
        if (function_exists('is_product') && is_product()) {
            return;
        }
    }
    $style = get_option('vj_chat_button_style', 'standard'); // Check style globally
    $classes = '';

    if ($mode === 'floating') {
        $classes = 'vj-chat-floating';
    }

    // Apply Compact Style if selected
    if ($style === 'compact') {
        $classes .= ' vj-chat-compact';
    }

    if ($mode === 'floating') {
        echo '<div class="vj-chat-floating-container">'; // Wrapper for safety
        echo vj_chat_get_button_html($classes, array('mode' => 'order'));
        echo '</div>';
    } else {
        echo vj_chat_get_button_html($classes, array('mode' => 'order'));
    }
}

/**
 * Render Chat Button (Site-wide)
 */
function vj_chat_render_chat_button()
{
    if (!vj_chat_is_chat_enabled()) {
        return;
    }

    $mode = get_option('vj_chat_chat_placement_mode', 'floating');
    if ($mode === 'shortcode') {
        return;
    }

    if ($mode === 'floating' && vj_chat_is_chat_hidden_on_page()) {
        return;
    }

    $use_order_mode = false;
    if (vj_chat_is_woocommerce_active() && vj_chat_is_woo_enabled() && function_exists('is_product') && is_product() && !vj_chat_is_woo_coming_soon_page()) {
        $woo_mode = get_option('vj_chat_placement_mode', 'auto');
        if ($woo_mode === 'floating') {
            $use_order_mode = true;
        }
    }

    $style = get_option('vj_chat_chat_button_style', 'standard');
    $classes = 'vj-chat-chat';

    if ($mode === 'floating') {
        $classes .= ' vj-chat-floating vj-chat-floating-chat';
    }

    if ($style === 'compact') {
        $classes .= ' vj-chat-compact';
    }

    echo '<div class="vj-chat-floating-container">';
    echo vj_chat_get_button_html($classes, array(
        'mode' => $use_order_mode ? 'order' : 'chat',
        'allow_anywhere' => true,
        'text' => get_option('vj_chat_chat_button_text', __('Need Help? Chat with us', 'vj-chat-order'))
    ));
    echo '</div>';
}

/**
 * Render Chat Widget (Single Agent)
 */
function vj_chat_render_chat_widget()
{
    if (!vj_chat_is_chat_enabled()) {
        return;
    }

    $chat_mode = get_option('vj_chat_chat_placement_mode', 'floating');
    if ($chat_mode === 'floating' && vj_chat_is_chat_hidden_on_page()) {
        return;
    }

    $agent_name = get_option('vj_chat_chat_agent_name', __('Customer Support', 'vj-chat-order'));
    $agent_role = get_option('vj_chat_chat_agent_role', __('Support Agent', 'vj-chat-order'));
    $agent_avatar = get_option('vj_chat_chat_agent_avatar', '');
    $agent_phone = get_option('vj_chat_chat_phone', '947000000000');
    $agent_message = get_option('vj_chat_chat_message', __('Hi! I need help.', 'vj-chat-order'));
    $widget_title = get_option('vj_chat_chat_widget_title', __('Start a Conversation', 'vj-chat-order'));
    $widget_title = trim($widget_title) !== '' ? $widget_title : $agent_name;
    $widget_status = get_option('vj_chat_chat_widget_status', __('Typically replies within a day', 'vj-chat-order'));
    $widget_line_1 = get_option('vj_chat_chat_widget_line1', __('Hi there!', 'vj-chat-order'));
    $widget_line_2 = get_option('vj_chat_chat_widget_line2', __('How can I help you?', 'vj-chat-order'));
    $widget_cta = get_option('vj_chat_chat_widget_cta', __('Chat on WhatsApp', 'vj-chat-order'));

    if (empty($agent_avatar)) {
        $agent_avatar = vj_chat_get_default_icon_url();
    }
    ?>
    <?php
    $widget_mode = 'chat';
    $widget_message = $agent_message;
    $widget_phone = $agent_phone;
    if (vj_chat_is_woocommerce_active() && vj_chat_is_woo_enabled() && function_exists('is_product') && is_product() && !vj_chat_is_woo_coming_soon_page()) {
        $woo_mode = get_option('vj_chat_placement_mode', 'auto');
        if ($woo_mode === 'floating') {
            $widget_mode = 'order';
            $widget_message = '';
            $widget_phone = '';
        }
    }
    ?>
    <div class="vj-chat-widget" id="vj-chat-widget" aria-hidden="true" data-widget-mode="<?php echo esc_attr($widget_mode); ?>">
        <div class="vj-chat-widget-overlay" data-chat-widget-close></div>
        <div class="vj-chat-widget-panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Chat with us', 'vj-chat-order'); ?>">
            <div class="vj-chat-widget-header">
                <div class="vj-chat-widget-header-main">
                    <span class="vj-chat-widget-avatar">
                        <img src="<?php echo esc_url($agent_avatar); ?>" alt="<?php echo esc_attr($agent_name); ?>">
                    </span>
                    <div class="vj-chat-widget-header-text">
                        <div class="vj-chat-widget-title"><?php echo esc_html($widget_title); ?></div>
                        <div class="vj-chat-widget-status">
                            <span class="vj-chat-widget-status-dot" aria-hidden="true"></span>
                            <?php echo esc_html($widget_status); ?>
                        </div>
                    </div>
                    <button type="button" class="vj-chat-widget-close" data-chat-widget-close aria-label="<?php esc_attr_e('Close chat', 'vj-chat-order'); ?>">×</button>
                </div>
            </div>
            <div class="vj-chat-widget-body">
                <div class="vj-chat-widget-bubbles">
                    <div class="vj-chat-widget-bubble"><?php echo esc_html($widget_line_1); ?></div>
                    <div class="vj-chat-widget-bubble"><?php echo esc_html($widget_line_2); ?></div>
                </div>
                <div class="vj-chat-widget-order" aria-hidden="true"></div>
                <a href="#" class="vj-chat-widget-cta" data-chat-agent data-mode="<?php echo esc_attr($widget_mode); ?>" data-phone="<?php echo esc_attr($widget_phone); ?>" data-message="<?php echo esc_attr($widget_message); ?>">
                    <span class="vj-chat-widget-cta-icon" aria-hidden="true">
                        <img src="<?php echo esc_url(vj_chat_get_default_icon_url()); ?>" alt="">
                    </span>
                    <span class="vj-chat-widget-cta-text"><?php echo esc_html($widget_cta); ?></span>
                </a>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Shortcode Callback
 */
function vj_chat_shortcode_callback($atts)
{
    $atts = shortcode_atts(array(
        'mode' => '',
        'text' => '',
        'message' => '',
        'phone' => ''
    ), $atts, 'vj_chat_order_button');

    $mode = $atts['mode'];
    if ($mode !== 'chat' && $mode !== 'order') {
        $mode = (function_exists('is_product') && is_product() && vj_chat_is_woocommerce_active() && vj_chat_is_woo_enabled() && !vj_chat_is_woo_coming_soon_page()) ? 'order' : 'chat';
    }

    if ($mode === 'chat' && !vj_chat_is_chat_enabled()) {
        return '';
    }

    if ($mode === 'order' && (!vj_chat_is_woocommerce_active() || !vj_chat_is_woo_enabled())) {
        return '';
    }

    return vj_chat_get_button_html('vj-chat-shortcode', array(
        'allow_anywhere' => true,
        'mode' => $mode,
        'text' => sanitize_text_field($atts['text']),
        'phone' => sanitize_text_field($atts['phone']),
        'intro' => sanitize_textarea_field($atts['message'])
    ));
}
add_shortcode('vj_chat_order_button', 'vj_chat_shortcode_callback');

/**
 * Initialize plugin hooks if WooCommerce is active
 */
function vj_chat_init()
{
    // Frontend hooks
    add_action('wp_enqueue_scripts', 'vj_chat_enqueue_assets');

    if (vj_chat_is_chat_enabled() && get_option('vj_chat_chat_placement_mode', 'floating') !== 'shortcode') {
        add_action('wp_footer', 'vj_chat_render_chat_button');
    }

    if (vj_chat_is_chat_enabled()) {
        add_action('wp_footer', 'vj_chat_render_chat_widget');
    }

    if (!vj_chat_is_woocommerce_active() || !vj_chat_is_woo_enabled()) {
        return;
    }

    // Placement Logic
    $mode = get_option('vj_chat_placement_mode', 'auto');
    $priority = absint(get_option('vj_chat_button_priority', 35));

    if ($mode === 'auto') {
        // Use specific hooks for reliable positioning across all themes
        if ($priority <= 25) {
            // Before Meta: Use woocommerce_product_meta_start (appears right before Category)
            add_action('woocommerce_product_meta_start', 'vj_chat_render_button', 10);
        } elseif ($priority <= 35) {
            // After Cart: Use woocommerce_after_add_to_cart_form (appears right after Add to Cart button)
            add_action('woocommerce_after_add_to_cart_form', 'vj_chat_render_button', 10);
        } else {
            // After Meta: Use woocommerce_product_meta_end (appears after Category/Tags)
            add_action('woocommerce_product_meta_end', 'vj_chat_render_button', 10);
        }
    } elseif ($mode === 'floating') {
        // Floating: Add to footer (will be fixed via CSS)
        add_action('wp_footer', 'vj_chat_render_button');
    }
    // 'shortcode' mode: No hook added.
}
add_action('init', 'vj_chat_init');
