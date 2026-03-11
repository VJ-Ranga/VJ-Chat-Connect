<?php
/**
 * Admin Settings for VJ Chat Connect
 * 
 * @package VJ_Chat_Order
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sanitize hex color with smart fallback
 */
function vj_chat_sanitize_hex_color($color, $key = '', $default = '')
{
    // 3 or 6 hex digits
    if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color)) {
        return $color;
    }

    // Invalid input: try to revert to saved value
    if (!empty($key)) {
        $saved = get_option($key);
        if ($saved && preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $saved)) {
            return $saved;
        }
    }

    // Fallback to default
    return $default;
}

/**
 * Add settings menu under Settings
 */
function vj_chat_add_settings_menu()
{
    add_options_page(
        __('Chat Connect Settings', 'vj-chat-order'),
        __('Chat Connect', 'vj-chat-order'),
        'manage_options',
        'vj-chat-settings',
        'vj_chat_render_settings_page'
    );
}
add_action('admin_menu', 'vj_chat_add_settings_menu');

/**
 * Enqueue media uploader and admin styles on settings page
 */
function vj_chat_admin_enqueue_scripts($hook)
{
    if ($hook !== 'settings_page_vj-chat-settings') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_style(
        'vj-chat-admin-style',
        VJ_CHAT_PLUGIN_URL . 'assets/css/admin-style.css',
        array(),
        VJ_CHAT_VERSION
    );

    wp_enqueue_script(
        'vj-chat-admin-script',
        VJ_CHAT_PLUGIN_URL . 'assets/js/admin-script.js',
        array('jquery'),
        VJ_CHAT_VERSION,
        true
    );

    wp_localize_script('vj-chat-admin-script', 'vjChatAdminData', array(
        'defaultIcon' => vj_chat_get_default_icon_url(),
        'defaultAvatar' => vj_chat_get_default_agent_avatar_url(),
        'uploaderTitle' => __('Select Chat Icon', 'vj-chat-order'),
        'uploaderButton' => __('Use This Icon', 'vj-chat-order'),
        'activeTab' => vj_chat_get_user_active_tab(),
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('vj_chat_tab_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'vj_chat_admin_enqueue_scripts');

/**
 * Register Settings and Fields
 */
function vj_chat_register_settings_init()
{
    // Register Settings
    register_setting('vj_chat_settings_group', 'vj_chat_phone_number', array(
        'sanitize_callback' => 'vj_chat_sanitize_phone',
        'default' => '947000000000'
    ));

    // Chat Settings
    register_setting('vj_chat_settings_group', 'vj_chat_enable_chat', array(
        'sanitize_callback' => 'absint',
        'default' => 1
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_phone', array(
        'sanitize_callback' => 'vj_chat_sanitize_phone',
        'default' => '947000000000'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_button_text', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'Need Help? Chat with us'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_message', array(
        'sanitize_callback' => 'sanitize_textarea_field',
        'default' => 'Hi! I need help.'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_button_style', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'standard'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_font_size', array(
        'sanitize_callback' => 'absint',
        'default' => 14
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_hover_color', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_hover_color', '#f5f7f9');
        },
        'default' => '#f5f7f9'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_border_radius', array(
        'sanitize_callback' => 'absint',
        'default' => 999
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_padding_vertical', array(
        'sanitize_callback' => 'absint',
        'default' => 10
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_padding_horizontal', array(
        'sanitize_callback' => 'absint',
        'default' => 16
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_margin_top', array(
        'sanitize_callback' => 'absint',
        'default' => 0
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_margin_bottom', array(
        'sanitize_callback' => 'absint',
        'default' => 0
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_icon_wrap_size', array(
        'sanitize_callback' => 'absint',
        'default' => 44
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_icon_size', array(
        'sanitize_callback' => 'absint',
        'default' => 24
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_compact_size', array(
        'sanitize_callback' => 'absint',
        'default' => 44
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_compact_icon_size', array(
        'sanitize_callback' => 'absint',
        'default' => 24
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_hide_pages', array(
        'sanitize_callback' => 'sanitize_textarea_field',
        'default' => ''
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_title', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'Start a Conversation'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_status', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'Typically replies within a day'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_line1', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'Hi there!'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_line2', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'How can I help you?'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_cta', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'Chat on WhatsApp'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_width', array(
        'sanitize_callback' => 'absint',
        'default' => 320
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_max_height', array(
        'sanitize_callback' => 'absint',
        'default' => 0
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_radius', array(
        'sanitize_callback' => 'absint',
        'default' => 18
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_header_bg', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_header_bg', '#25D366');
        },
        'default' => '#25D366'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_header_text', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_header_text', '#ffffff');
        },
        'default' => '#ffffff'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_status_text', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_status_text', '#e5f4dc');
        },
        'default' => '#e5f4dc'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_body_bg', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_body_bg', '#f0f0f0');
        },
        'default' => '#f0f0f0'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_bubble_bg', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_bubble_bg', '#ffffff');
        },
        'default' => '#ffffff'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_bubble_text', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_bubble_text', '#1d2327');
        },
        'default' => '#1d2327'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_cta_bg', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_cta_bg', '#25D366');
        },
        'default' => '#25D366'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_cta_text', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_cta_text', '#ffffff');
        },
        'default' => '#ffffff'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_close_bg', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_close_bg', '#25D366');
        },
        'default' => '#25D366'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_close_text', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_widget_close_text', '#ffffff');
        },
        'default' => '#ffffff'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_overlay_opacity', array(
        'sanitize_callback' => function ($val) {
            $float = floatval($val);
            if ($float < 0) {
                $float = 0;
            }
            if ($float > 1) {
                $float = 1;
            }
            return $float;
        },
        'default' => 0.25
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_widget_avatar_scale', array(
        'sanitize_callback' => function ($val) {
            $int = absint($val);
            if ($int < 40) {
                $int = 40;
            }
            if ($int > 100) {
                $int = 100;
            }
            return $int;
        },
        'default' => 100
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_agent_name', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'Customer Support'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_agent_role', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'Support Agent'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_agent_avatar', array(
        'sanitize_callback' => 'esc_url_raw',
        'default' => ''
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_placement_mode', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'floating'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_floating_position', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'bottom-right'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_floating_offset_x', array(
        'sanitize_callback' => 'absint',
        'default' => 20
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_floating_offset_y', array(
        'sanitize_callback' => 'absint',
        'default' => 20
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_pill_bg_style', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'solid'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_pill_bg_color', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_pill_bg_color', '#ffffff');
        },
        'default' => '#ffffff'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_text_color', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_text_color', '#1d2327');
        },
        'default' => '#1d2327'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_chat_icon_bg_color', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_chat_icon_bg_color', '#25D366');
        },
        'default' => '#25D366'
    ));

    // WooCommerce Order Settings
    register_setting('vj_chat_settings_group', 'vj_chat_enable_woo', array(
        'sanitize_callback' => 'absint',
        'default' => 1
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_button_text', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'Order via WhatsApp'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_icon_url', array(
        'sanitize_callback' => 'esc_url_raw',
        'default' => ''
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_intro_message', array(
        'sanitize_callback' => 'sanitize_textarea_field',
        'default' => 'Hello, I\'d like to place an order:'
    ));

    // Placement Settings
    register_setting('vj_chat_settings_group', 'vj_chat_placement_mode', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'auto'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_button_priority', array(
        'sanitize_callback' => 'absint',
        'default' => 35
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_floating_position', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'bottom-right'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_floating_offset_x', array(
        'sanitize_callback' => 'absint',
        'default' => 20
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_floating_offset_y', array(
        'sanitize_callback' => 'absint',
        'default' => 20
    ));

    // Design Settings
    register_setting('vj_chat_settings_group', 'vj_chat_bg_color', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_bg_color', '#25D366');
        },
        'default' => '#25D366'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_text_color', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_text_color', '#ffffff');
        },
        'default' => '#ffffff'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_hover_color', array(
        'sanitize_callback' => function ($val) {
            return vj_chat_sanitize_hex_color($val, 'vj_chat_hover_color', '#1ebe5d');
        },
        'default' => '#1ebe5d'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_button_style', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'standard'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_compact_size', array(
        'sanitize_callback' => 'absint',
        'default' => 44
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_compact_icon_size', array(
        'sanitize_callback' => 'absint',
        'default' => 24
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_compact_bg_color', array(
        'sanitize_callback' => 'sanitize_hex_color',
        'default' => '#25D366'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_compact_text_color', array(
        'sanitize_callback' => 'sanitize_hex_color',
        'default' => '#ffffff'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_compact_hover_color', array(
        'sanitize_callback' => 'sanitize_hex_color',
        'default' => '#1ebe5d'
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_border_radius', array(
        'sanitize_callback' => 'absint',
        'default' => 8
    ));


    register_setting('vj_chat_settings_group', 'vj_chat_font_size', array(
        'sanitize_callback' => 'absint',
        'default' => 16
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_margin_top', array(
        'sanitize_callback' => 'absint',
        'default' => 15
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_margin_bottom', array(
        'sanitize_callback' => 'absint',
        'default' => 15
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_padding_vertical', array(
        'sanitize_callback' => 'absint',
        'default' => 14
    ));

    register_setting('vj_chat_settings_group', 'vj_chat_padding_horizontal', array(
        'sanitize_callback' => 'absint',
        'default' => 24
    ));

    // ===== Message Customization Settings =====
    $message_settings = array(
        'vj_chat_label_product' => __('Product', 'vj-chat-order'),
        'vj_chat_icon_product' => '🛒',
        'vj_chat_label_quantity' => _x('Quantity', 'WhatsApp message label', 'vj-chat-order'),
        'vj_chat_icon_quantity' => '🔢',
        'vj_chat_label_price' => _x('Price', 'WhatsApp message label', 'vj-chat-order'),
        'vj_chat_icon_price' => '💰',
        'vj_chat_label_total' => _x('Total', 'WhatsApp message label', 'vj-chat-order'),
        'vj_chat_icon_total' => '💵',
        'vj_chat_label_link' => _x('Link', 'WhatsApp message label', 'vj-chat-order'),
        'vj_chat_icon_link' => '🔗'
    );

    foreach ($message_settings as $key => $default) {
        register_setting('vj_chat_settings_group', $key, array(
            'sanitize_callback' => 'sanitize_text_field', // Assuming icons and labels are text fields
            'default' => $default
        ));
    }

}
add_action('admin_init', 'vj_chat_register_settings_init');

/**
 * Sanitize Phone Number
 */
function vj_chat_sanitize_phone($input)
{
    $sanitized = sanitize_text_field($input);
    if (!preg_match('/^[0-9]{10,15}$/', $sanitized)) {
        add_settings_error(
            'vj_chat_phone_number',
            'vj_chat_phone_error',
            __('Invalid phone number. Please enter 10-15 digits only.', 'vj-chat-order')
        );
        return get_option('vj_chat_phone_number');
    }
    return $sanitized;
}

/**
 * General field callbacks
 */
function vj_chat_phone_field_callback()
{
    $value = get_option('vj_chat_phone_number', '947000000000');
    echo '<input type="text" name="vj_chat_phone_number" value="' . esc_attr($value) . '" class="regular-text" placeholder="947000000000">';
    echo '<p class="description">' . __('Enter the WhatsApp number with country code (no + or spaces). Example: 947000000000', 'vj-chat-order') . '</p>';
}

function vj_chat_button_text_field_callback()
{
    $value = get_option('vj_chat_button_text', 'Order via WhatsApp');
    echo '<input type="text" name="vj_chat_button_text" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr__('Order via WhatsApp', 'vj-chat-order') . '">';
    echo '<p class="description">' . __('Text displayed on the WhatsApp button.', 'vj-chat-order') . '</p>';
}

function vj_chat_icon_url_field_callback()
{
    $default_icon = vj_chat_get_default_icon_url();
    $saved_value = get_option('vj_chat_icon_url', '');
    $display_url = !empty($saved_value) ? $saved_value : $default_icon;
    ?>
    <div class="vj-chat-icon-upload-wrap">
        <input type="url" id="vj_chat_icon_url" name="vj_chat_icon_url" value="<?php echo esc_attr($saved_value); ?>"
            class="regular-text" placeholder="<?php esc_attr_e('Leave empty for default icon', 'vj-chat-order'); ?>">
        <button type="button" class="button vj-chat-upload-icon-btn"><?php _e('Upload Icon', 'vj-chat-order'); ?></button>
        <button type="button"
            class="button vj-chat-reset-icon-btn"><?php _e('Reset to Default', 'vj-chat-order'); ?></button>
    </div>
    <div class="vj-chat-icon-preview" style="margin-top: 10px;">
        <img src="<?php echo esc_url($display_url); ?>" alt="Icon Preview" loading="lazy"
            style="max-width: 40px; max-height: 40px; background: #25D366; padding: 8px; border-radius: 8px;">
    </div>
    <p class="description">
        <?php _e('Upload your own icon or leave empty to use the default local icon. SVG or PNG recommended.', 'vj-chat-order'); ?>
    </p>
    <?php
}

function vj_chat_intro_message_field_callback()
{
    $value = get_option('vj_chat_intro_message', 'Hello, I\'d like to place an order:');
    echo '<textarea name="vj_chat_intro_message" rows="3" class="large-text" placeholder="' . esc_attr__('Hello, I\'d like to place an order:', 'vj-chat-order') . '">' . esc_textarea($value) . '</textarea>';
    echo '<p class="description">' . __('Opening message for the WhatsApp order. Product details will be added automatically.', 'vj-chat-order') . '</p>';
}

function vj_chat_enable_chat_field_callback()
{
    $value = get_option('vj_chat_enable_chat', 1);
    echo '<label><input type="checkbox" id="vj_chat_enable_chat" name="vj_chat_enable_chat" value="1" ' . checked(1, $value, false) . '> ' . esc_html__('Enable Chat (works without WooCommerce)', 'vj-chat-order') . '</label>';
    echo '<p class="description">' . __('When enabled, the chat button can be used anywhere via shortcode.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_agent_name_field_callback()
{
    $value = get_option('vj_chat_chat_agent_name', 'Customer Support');
    echo '<input type="text" name="vj_chat_chat_agent_name" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr__('Customer Support', 'vj-chat-order') . '">';
    echo '<p class="description">' . __('Agent name for the chat option.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_agent_role_field_callback()
{
    $value = get_option('vj_chat_chat_agent_role', 'Support Agent');
    echo '<input type="text" name="vj_chat_chat_agent_role" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr__('Support Agent', 'vj-chat-order') . '">';
    echo '<p class="description">' . __('Agent role/label for the chat option.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_agent_avatar_field_callback()
{
    $value = get_option('vj_chat_chat_agent_avatar', '');
    $fallback = vj_chat_get_default_agent_avatar_url();
    $preview = !empty($value) ? $value : $fallback;
    ?>
    <div class="vj-chat-avatar-upload-wrap">
        <input type="url" id="vj_chat_chat_agent_avatar" name="vj_chat_chat_agent_avatar"
            value="<?php echo esc_attr($value); ?>" class="regular-text"
            placeholder="<?php esc_attr_e('Avatar image URL (optional)', 'vj-chat-order'); ?>">
        <button type="button" class="button vj-chat-upload-avatar-btn"><?php _e('Upload Avatar', 'vj-chat-order'); ?></button>
        <button type="button" class="button vj-chat-reset-avatar-btn"><?php _e('Reset', 'vj-chat-order'); ?></button>
    </div>
    <div class="vj-chat-agent-avatar-preview" style="margin-top: 10px;">
        <img src="<?php echo esc_url($preview); ?>" alt="Agent Avatar" class="vj-chat-agent-avatar-preview-img" loading="lazy"
            style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 1px solid #dcdcde; background: #fff;">
    </div>
    <p class="description"><?php _e('Upload from Media Library or paste an image URL. Recommended size: square image (at least 200x200 px).', 'vj-chat-order'); ?></p>
    <?php
}

function vj_chat_chat_phone_field_callback()
{
    $value = get_option('vj_chat_chat_phone', '947000000000');
    echo '<input type="text" name="vj_chat_chat_phone" value="' . esc_attr($value) . '" class="regular-text" placeholder="947000000000">';
    echo '<p class="description">' . __('WhatsApp number with country code (no + or spaces).', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_message_field_callback()
{
    $value = get_option('vj_chat_chat_message', 'Hi! I need help.');
    echo '<textarea name="vj_chat_chat_message" rows="3" class="large-text" placeholder="' . esc_attr__('Hi! I need help.', 'vj-chat-order') . '">' . esc_textarea($value) . '</textarea>';
    echo '<p class="description">' . __('Default message used for the simple chat button.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_button_text_field_callback()
{
    $value = get_option('vj_chat_chat_button_text', 'Need Help? Chat with us');
    echo '<input type="text" name="vj_chat_chat_button_text" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr__('Need Help? Chat with us', 'vj-chat-order') . '">';
    echo '<p class="description">' . __('Text displayed on the chat button.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_button_style_field_callback()
{
    $option = get_option('vj_chat_chat_button_style', 'standard');
    ?>
    <select name="vj_chat_chat_button_style" id="vj_chat_chat_button_style">
        <option value="standard" <?php selected($option, 'standard'); ?>>
            <?php _e('Standard (Text + Icon)', 'vj-chat-order'); ?>
        </option>
        <option value="compact" <?php selected($option, 'compact'); ?>><?php _e('Compact (Icon Only)', 'vj-chat-order'); ?>
        </option>
    </select>
    <p class="description"><?php _e('Chat button style. Compact shows only the icon.', 'vj-chat-order'); ?></p>
    <?php
}

function vj_chat_chat_font_size_field_callback()
{
    $value = get_option('vj_chat_chat_font_size', 14);
    echo '<input type="number" name="vj_chat_chat_font_size" value="' . esc_attr($value) . '" min="10" max="22" style="width: 80px;"> px';
    echo '<p class="description">' . __('Chat button text size. Default: 14px', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_hover_color_field_callback()
{
    $value = get_option('vj_chat_chat_hover_color', '#f5f7f9');
    echo '<input type="color" name="vj_chat_chat_hover_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Chat button background on hover.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_border_radius_field_callback()
{
    $value = get_option('vj_chat_chat_border_radius', 999);
    echo '<input type="number" name="vj_chat_chat_border_radius" value="' . esc_attr($value) . '" min="0" max="999" style="width: 80px;"> px';
    echo '<p class="description">' . __('Chat pill corner radius. Default: 999px', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_padding_field_callback()
{
    $vertical = get_option('vj_chat_chat_padding_vertical', 10);
    $horizontal = get_option('vj_chat_chat_padding_horizontal', 16);
    echo '<input type="number" name="vj_chat_chat_padding_vertical" value="' . esc_attr($vertical) . '" min="4" max="30" style="width: 70px;"> px (vertical) &nbsp;&nbsp;';
    echo '<input type="number" name="vj_chat_chat_padding_horizontal" value="' . esc_attr($horizontal) . '" min="6" max="40" style="width: 70px;"> px (horizontal)';
    echo '<p class="description">' . __('Padding inside the chat text pill. Default: 10px / 16px', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_margin_field_callback()
{
    $top = get_option('vj_chat_chat_margin_top', 0);
    $bottom = get_option('vj_chat_chat_margin_bottom', 0);
    echo '<input type="number" name="vj_chat_chat_margin_top" value="' . esc_attr($top) . '" style="width: 70px;"> px (top) &nbsp;&nbsp;';
    echo '<input type="number" name="vj_chat_chat_margin_bottom" value="' . esc_attr($bottom) . '" style="width: 70px;"> px (bottom)';
    echo '<p class="description">' . __('Space above and below the chat button.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_icon_wrap_size_field_callback()
{
    $value = get_option('vj_chat_chat_icon_wrap_size', 44);
    echo '<input type="number" name="vj_chat_chat_icon_wrap_size" value="' . esc_attr($value) . '" min="30" max="80" style="width: 80px;"> px';
    echo '<p class="description">' . __('Chat icon bubble size. Default: 44px', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_icon_size_field_callback()
{
    $value = get_option('vj_chat_chat_icon_size', 24);
    echo '<input type="number" name="vj_chat_chat_icon_size" value="' . esc_attr($value) . '" min="10" max="40" style="width: 80px;"> px';
    echo '<p class="description">' . __('Chat icon size. Default: 24px', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_compact_size_field_callback()
{
    $value = get_option('vj_chat_chat_compact_size', 44);
    echo '<input type="number" name="vj_chat_chat_compact_size" value="' . esc_attr($value) . '" min="30" max="100" style="width: 80px;"> px';
    echo '<p class="description">' . __('Chat compact button size. Default: 44px', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_compact_icon_size_field_callback()
{
    $value = get_option('vj_chat_chat_compact_icon_size', 24);
    echo '<input type="number" name="vj_chat_chat_compact_icon_size" value="' . esc_attr($value) . '" min="10" max="80" style="width: 80px;"> px';
    echo '<p class="description">' . __('Chat compact icon size. Default: 24px', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_hide_pages_field_callback()
{
    $value = get_option('vj_chat_chat_hide_pages', '');
    echo '<textarea name="vj_chat_chat_hide_pages" rows="3" class="large-text" placeholder="contact\nabout-us\n123">' . esc_textarea($value) . '</textarea>';
    echo '<p class="description">' . __('Hide floating chat button on these pages. Enter page IDs, slugs, or full URLs (comma or new line separated). Only applies to Floating mode.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_title_field_callback()
{
    $value = get_option('vj_chat_chat_widget_title', 'Start a Conversation');
    echo '<input type="text" name="vj_chat_chat_widget_title" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr__('Start a Conversation', 'vj-chat-order') . '">';
    echo '<p class="description">' . __('Widget header title.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_status_field_callback()
{
    $value = get_option('vj_chat_chat_widget_status', 'Typically replies within a day');
    echo '<input type="text" name="vj_chat_chat_widget_status" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr__('Typically replies within a day', 'vj-chat-order') . '">';
    echo '<p class="description">' . __('Short status line below the agent name.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_line1_field_callback()
{
    $value = get_option('vj_chat_chat_widget_line1', 'Hi there!');
    echo '<input type="text" name="vj_chat_chat_widget_line1" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr__('Hi there!', 'vj-chat-order') . '">';
    echo '<p class="description">' . __('First message bubble text.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_line2_field_callback()
{
    $value = get_option('vj_chat_chat_widget_line2', 'How can I help you?');
    echo '<input type="text" name="vj_chat_chat_widget_line2" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr__('How can I help you?', 'vj-chat-order') . '">';
    echo '<p class="description">' . __('Second message bubble text.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_cta_field_callback()
{
    $value = get_option('vj_chat_chat_widget_cta', 'Chat on WhatsApp');
    echo '<input type="text" name="vj_chat_chat_widget_cta" value="' . esc_attr($value) . '" class="regular-text" placeholder="' . esc_attr__('Chat on WhatsApp', 'vj-chat-order') . '">';
    echo '<p class="description">' . __('CTA button label in the chat widget.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_width_field_callback()
{
    $value = get_option('vj_chat_chat_widget_width', 320);
    echo '<input type="number" name="vj_chat_chat_widget_width" value="' . esc_attr($value) . '" min="240" max="480" style="width: 80px;"> px';
    echo '<p class="description">' . __('Widget width. Default: 320px', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_max_height_field_callback()
{
    $value = get_option('vj_chat_chat_widget_max_height', 0);
    echo '<input type="number" name="vj_chat_chat_widget_max_height" value="' . esc_attr($value) . '" min="0" max="800" style="width: 80px;"> px';
    echo '<p class="description">' . __('Maximum height (0 = auto).', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_radius_field_callback()
{
    $value = get_option('vj_chat_chat_widget_radius', 18);
    echo '<input type="number" name="vj_chat_chat_widget_radius" value="' . esc_attr($value) . '" min="0" max="40" style="width: 80px;"> px';
    echo '<p class="description">' . __('Widget corner radius. Default: 18px', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_header_bg_field_callback()
{
    $value = get_option('vj_chat_chat_widget_header_bg', '#25D366');
    echo '<input type="color" name="vj_chat_chat_widget_header_bg" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Header background color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_header_text_field_callback()
{
    $value = get_option('vj_chat_chat_widget_header_text', '#ffffff');
    echo '<input type="color" name="vj_chat_chat_widget_header_text" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Header text color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_status_text_field_callback()
{
    $value = get_option('vj_chat_chat_widget_status_text', '#e5f4dc');
    echo '<input type="color" name="vj_chat_chat_widget_status_text" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Status text color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_body_bg_field_callback()
{
    $value = get_option('vj_chat_chat_widget_body_bg', '#f0f0f0');
    echo '<input type="color" name="vj_chat_chat_widget_body_bg" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Widget body background color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_bubble_bg_field_callback()
{
    $value = get_option('vj_chat_chat_widget_bubble_bg', '#ffffff');
    echo '<input type="color" name="vj_chat_chat_widget_bubble_bg" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Message bubble background color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_bubble_text_field_callback()
{
    $value = get_option('vj_chat_chat_widget_bubble_text', '#1d2327');
    echo '<input type="color" name="vj_chat_chat_widget_bubble_text" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Message bubble text color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_cta_bg_field_callback()
{
    $value = get_option('vj_chat_chat_widget_cta_bg', '#25D366');
    echo '<input type="color" name="vj_chat_chat_widget_cta_bg" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('CTA button background color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_cta_text_field_callback()
{
    $value = get_option('vj_chat_chat_widget_cta_text', '#ffffff');
    echo '<input type="color" name="vj_chat_chat_widget_cta_text" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('CTA button text color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_close_bg_field_callback()
{
    $value = get_option('vj_chat_chat_widget_close_bg', '#25D366');
    echo '<input type="color" name="vj_chat_chat_widget_close_bg" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Close button background color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_close_text_field_callback()
{
    $value = get_option('vj_chat_chat_widget_close_text', '#ffffff');
    echo '<input type="color" name="vj_chat_chat_widget_close_text" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Close icon color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_overlay_opacity_field_callback()
{
    $value = get_option('vj_chat_chat_widget_overlay_opacity', 0.25);
    echo '<input type="number" step="0.05" min="0" max="1" name="vj_chat_chat_widget_overlay_opacity" value="' . esc_attr($value) . '" style="width: 80px;">';
    echo '<p class="description">' . __('Overlay opacity (0 to 1). Default: 0.25', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_widget_avatar_scale_field_callback()
{
    $value = absint(get_option('vj_chat_chat_widget_avatar_scale', 100));
    echo '<input type="number" min="40" max="100" name="vj_chat_chat_widget_avatar_scale" value="' . esc_attr($value) . '" style="width: 80px;"> %';
    echo '<p class="description">' . __('Avatar image fill inside the circle. 100% fills full circle, 60% gives smaller icon look.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_placement_mode_callback()
{
    $option = get_option('vj_chat_chat_placement_mode', 'floating');
    ?>
    <select name="vj_chat_chat_placement_mode" id="vj_chat_chat_placement_mode">
        <option value="floating" <?php selected($option, 'floating'); ?>><?php _e('Floating (Site-wide)', 'vj-chat-order'); ?>
        </option>
        <option value="shortcode" <?php selected($option, 'shortcode'); ?>><?php _e('Shortcode Only', 'vj-chat-order'); ?>
        </option>
    </select>
    <p class="description">
        <?php _e('<strong>Floating:</strong> Fixed to the corner of the screen on all pages.', 'vj-chat-order'); ?><br>
        <?php _e('<strong>Shortcode:</strong> Use <code>[vj_chat_order_button mode="chat"]</code> to place manually.', 'vj-chat-order'); ?>
    </p>
    <?php
}

function vj_chat_chat_floating_position_callback()
{
    $option = get_option('vj_chat_chat_floating_position', 'bottom-right');
    ?>
    <select name="vj_chat_chat_floating_position" id="vj_chat_chat_floating_position">
        <option value="bottom-right" <?php selected($option, 'bottom-right'); ?>>
            <?php _e('Bottom Right', 'vj-chat-order'); ?>
        </option>
        <option value="bottom-left" <?php selected($option, 'bottom-left'); ?>><?php _e('Bottom Left', 'vj-chat-order'); ?>
        </option>
        <option value="top-right" <?php selected($option, 'top-right'); ?>><?php _e('Top Right', 'vj-chat-order'); ?>
        </option>
        <option value="top-left" <?php selected($option, 'top-left'); ?>><?php _e('Top Left', 'vj-chat-order'); ?></option>
    </select>
    <?php
}

function vj_chat_chat_floating_offset_x_callback()
{
    $val = get_option('vj_chat_chat_floating_offset_x', 20);
    echo '<input type="number" name="vj_chat_chat_floating_offset_x" id="vj_chat_chat_floating_offset_x" value="' . esc_attr($val) . '" min="0" max="500" style="width: 70px;"> px';
    echo '<p class="description">' . __('Distance from the left or right edge (depending on position).', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_floating_offset_y_callback()
{
    $val = get_option('vj_chat_chat_floating_offset_y', 20);
    echo '<input type="number" name="vj_chat_chat_floating_offset_y" id="vj_chat_chat_floating_offset_y" value="' . esc_attr($val) . '" min="0" max="500" style="width: 70px;"> px';
    echo '<p class="description">' . __('Distance from the top or bottom edge (depending on position).', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_pill_bg_style_field_callback()
{
    $option = get_option('vj_chat_chat_pill_bg_style', 'solid');
    ?>
    <select name="vj_chat_chat_pill_bg_style" id="vj_chat_chat_pill_bg_style">
        <option value="solid" <?php selected($option, 'solid'); ?>><?php _e('Solid Background', 'vj-chat-order'); ?>
        </option>
        <option value="transparent" <?php selected($option, 'transparent'); ?>><?php _e('Transparent', 'vj-chat-order'); ?>
        </option>
    </select>
    <p class="description">
        <?php _e('Choose whether the chat pill has a background or is transparent.', 'vj-chat-order'); ?>
    </p>
    <?php
}

function vj_chat_chat_pill_bg_color_field_callback()
{
    $value = get_option('vj_chat_chat_pill_bg_color', '#ffffff');
    echo '<input type="color" name="vj_chat_chat_pill_bg_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Chat button background color (when Solid).', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_text_color_field_callback()
{
    $value = get_option('vj_chat_chat_text_color', '#1d2327');
    echo '<input type="color" name="vj_chat_chat_text_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Chat button text color.', 'vj-chat-order') . '</p>';
}

function vj_chat_chat_icon_bg_color_field_callback()
{
    $value = get_option('vj_chat_chat_icon_bg_color', '#25D366');
    echo '<input type="color" name="vj_chat_chat_icon_bg_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Background color of the round WhatsApp icon.', 'vj-chat-order') . '</p>';
}

function vj_chat_enable_woo_field_callback()
{
    $value = get_option('vj_chat_enable_woo', 1);
    $woo_active = function_exists('vj_chat_is_woocommerce_active') && vj_chat_is_woocommerce_active();
    echo '<label><input type="checkbox" id="vj_chat_enable_woo" name="vj_chat_enable_woo" value="1" ' . checked(1, $value, false) . '> ' . esc_html__('Enable WooCommerce Order Button', 'vj-chat-order') . '</label>';
    if (!$woo_active) {
        echo '<p class="description">' . __('WooCommerce is not active. You can disable this or activate WooCommerce to use order features.', 'vj-chat-order') . '</p>';
    } else {
        echo '<p class="description">' . __('Controls product page button and floating mode.', 'vj-chat-order') . '</p>';
    }
}

// ===== Placement Callbacks =====

function vj_chat_placement_mode_callback()
{
    $option = get_option('vj_chat_placement_mode', 'auto');
    ?>
    <select name="vj_chat_placement_mode" id="vj_chat_placement_mode">
        <option value="auto" <?php selected($option, 'auto'); ?>>
            <?php _e('Auto (Priority 25 - Between Desc & Cart)', 'vj-chat-order'); ?>
        </option>
        <option value="shortcode" <?php selected($option, 'shortcode'); ?>><?php _e('Shortcode Only', 'vj-chat-order'); ?>
        </option>
        <option value="floating" <?php selected($option, 'floating'); ?>><?php _e('Floating Button', 'vj-chat-order'); ?>
        </option>
    </select>
    <p class="description">
        <?php _e('<strong>Auto:</strong> Automatically placed in product summary.', 'vj-chat-order'); ?><br>
        <?php _e('<strong>Shortcode:</strong> Use <code>[vj_chat_order_button]</code> to place manually.', 'vj-chat-order'); ?><br>
        <?php _e('<strong>Floating:</strong> Fixed to the corner of the screen.', 'vj-chat-order'); ?>
    </p>

    <!-- Simple JS to toggle floating fields visibility -->
    <script>
        jQuery(document).ready(function ($) {
            function toggleWooFields() {
                var isEnabled = $('#vj_chat_enable_woo').length ? $('#vj_chat_enable_woo').is(':checked') : true;
                if (isEnabled) {
                    $('#vj-chat-woo-settings').show();
                } else {
                    $('#vj-chat-woo-settings').hide();
                }
            }

            function toggleFloatingFields() {
                var mode = $('#vj_chat_placement_mode').val();
                if (mode === 'floating') {
                    $('tr:has(#vj_chat_floating_position), tr:has(#vj_chat_floating_offset_x), tr:has(#vj_chat_floating_offset_y)').show();
                    $('tr:has(#vj_chat_button_priority)').hide(); // Not relevant for floating
                } else if (mode === 'auto') {
                    $('tr:has(#vj_chat_floating_position), tr:has(#vj_chat_floating_offset_x), tr:has(#vj_chat_floating_offset_y)').hide();
                    $('tr:has(#vj_chat_button_priority)').show(); // Only relevant for auto
                } else {
                    // Shortcode mode - hide all placement options
                    $('tr:has(#vj_chat_floating_position), tr:has(#vj_chat_floating_offset_x), tr:has(#vj_chat_floating_offset_y)').hide();
                    $('tr:has(#vj_chat_button_priority)').hide();
                }
            }

            function toggleChatFloatingFields() {
                var mode = $('#vj_chat_chat_placement_mode').val();
                if (mode === 'floating') {
                    $('tr:has(#vj_chat_chat_floating_position), tr:has(#vj_chat_chat_floating_offset_x), tr:has(#vj_chat_chat_floating_offset_y)').show();
                } else {
                    $('tr:has(#vj_chat_chat_floating_position), tr:has(#vj_chat_chat_floating_offset_x), tr:has(#vj_chat_chat_floating_offset_y)').hide();
                }
            }

            function toggleChatStyleFields() {
                var style = $('#vj_chat_chat_button_style').val();
                if (style === 'compact') {
                    $('tr:has([name="vj_chat_chat_pill_bg_style"])').hide();
                    $('tr:has([name="vj_chat_chat_pill_bg_color"])').hide();
                    $('tr:has([name="vj_chat_chat_text_color"])').hide();
                    $('tr:has([name="vj_chat_chat_font_size"])').hide();
                    $('tr:has([name="vj_chat_chat_hover_color"])').hide();
                    $('tr:has([name="vj_chat_chat_border_radius"])').hide();
                    $('tr:has([name="vj_chat_chat_padding_vertical"])').hide();
                    $('tr:has([name="vj_chat_chat_padding_horizontal"])').hide();
                    $('tr:has([name="vj_chat_chat_icon_bg_color"])').show();
                    $('tr:has([name="vj_chat_chat_icon_wrap_size"])').hide();
                    $('tr:has([name="vj_chat_chat_icon_size"])').hide();
                    $('tr:has([name="vj_chat_chat_compact_size"])').show();
                    $('tr:has([name="vj_chat_chat_compact_icon_size"])').show();
                } else {
                    $('tr:has([name="vj_chat_chat_pill_bg_style"])').show();
                    $('tr:has([name="vj_chat_chat_pill_bg_color"])').show();
                    $('tr:has([name="vj_chat_chat_text_color"])').show();
                    $('tr:has([name="vj_chat_chat_font_size"])').show();
                    $('tr:has([name="vj_chat_chat_hover_color"])').show();
                    $('tr:has([name="vj_chat_chat_border_radius"])').show();
                    $('tr:has([name="vj_chat_chat_padding_vertical"])').show();
                    $('tr:has([name="vj_chat_chat_padding_horizontal"])').show();
                    $('tr:has([name="vj_chat_chat_icon_bg_color"])').show();
                    $('tr:has([name="vj_chat_chat_icon_wrap_size"])').show();
                    $('tr:has([name="vj_chat_chat_icon_size"])').show();
                    $('tr:has([name="vj_chat_chat_compact_size"])').hide();
                    $('tr:has([name="vj_chat_chat_compact_icon_size"])').hide();
                }
            }

            function toggleCompactFields() {
                var style = $('#vj_chat_button_style').val();
                if (style === 'compact') {
                    // Toggle Groups
                    $('#vj-standard-design-table').hide();
                    $('#vj-compact-design-table').show();

                    // Hide Button Text in General Tab
                    $('tr:has([name="vj_chat_button_text"])').hide();

                    // Get Compact Colors for Preview
                    var bgColor = $('[name="vj_chat_compact_bg_color"]').val() || '#25D366';

                    // Update Preview to Circle
                    var size = parseInt($('[name="vj_chat_compact_size"]').val() || 44);
                    var iconSize = parseInt($('[name="vj_chat_compact_icon_size"]').val() || 24);

                    // Prevent negative padding
                    if (iconSize > size) iconSize = size - 10;

                    var padding = (size - iconSize) / 2;

                    $('.vj-chat-icon-preview img').css({
                        'border-radius': '50%',
                        'width': size + 'px',
                        'height': size + 'px',
                        'padding': padding + 'px',
                        'box-sizing': 'border-box',
                        'background-color': bgColor
                    });
                } else {
                    // Toggle Groups
                    $('#vj-standard-design-table').show();
                    $('#vj-compact-design-table').hide();

                    // Show Button Text in General Tab
                    $('tr:has([name="vj_chat_button_text"])').show();

                    // Get Standard Colors for Preview
                    var bgColor = $('[name="vj_chat_bg_color"]').val() || '#25D366';

                    // Reset Preview to Square/Rounded
                    var radius = $('[name="vj_chat_border_radius"]').val() || 8;
                    $('.vj-chat-icon-preview img').css({
                        'border-radius': radius + 'px',
                        'width': 'auto',
                        'height': 'auto',
                        'max-width': '40px',
                        'padding': '8px',
                        'box-sizing': 'content-box',
                        'background-color': bgColor
                    });
                }
            }

            // Sync preview on input change
            $('[name="vj_chat_compact_size"], [name="vj_chat_compact_icon_size"]').on('input change', toggleCompactFields);
            $('[name="vj_chat_compact_bg_color"], [name="vj_chat_bg_color"]').on('input change', toggleCompactFields);
            $('[name="vj_chat_border_radius"]').on('input change', toggleCompactFields);

            $('#vj_chat_placement_mode').on('change', toggleFloatingFields);
            $('#vj_chat_chat_placement_mode').on('change', toggleChatFloatingFields);
            $('#vj_chat_chat_button_style').on('change', toggleChatStyleFields);
            $('#vj_chat_button_style').on('change', toggleCompactFields);
            $('#vj_chat_enable_woo').on('change', function () {
                toggleWooFields();
                toggleFloatingFields();
            });

            // Run on load
            toggleWooFields();
            toggleFloatingFields();
            toggleChatFloatingFields();
            toggleChatStyleFields();
            setTimeout(toggleCompactFields, 100); // Small delay to ensure DOM is ready
        });
    </script>
    <?php
}

function vj_chat_floating_position_callback()
{
    $option = get_option('vj_chat_floating_position', 'bottom-right');
    ?>
    <select name="vj_chat_floating_position" id="vj_chat_floating_position">
        <option value="bottom-right" <?php selected($option, 'bottom-right'); ?>>
            <?php _e('Bottom Right', 'vj-chat-order'); ?>
        </option>
        <option value="bottom-left" <?php selected($option, 'bottom-left'); ?>><?php _e('Bottom Left', 'vj-chat-order'); ?>
        </option>
        <option value="top-right" <?php selected($option, 'top-right'); ?>><?php _e('Top Right', 'vj-chat-order'); ?>
        </option>
        <option value="top-left" <?php selected($option, 'top-left'); ?>><?php _e('Top Left', 'vj-chat-order'); ?></option>
    </select>
    <?php
}

function vj_chat_floating_offset_x_callback()
{
    $val = get_option('vj_chat_floating_offset_x', 20);
    echo '<input type="number" name="vj_chat_floating_offset_x" id="vj_chat_floating_offset_x" value="' . esc_attr($val) . '" min="0" max="500" style="width: 70px;"> px';
    echo '<p class="description">' . __('Distance from the left or right edge (depending on position).', 'vj-chat-order') . '</p>';
}

function vj_chat_floating_offset_y_callback()
{
    $val = get_option('vj_chat_floating_offset_y', 20);
    echo '<input type="number" name="vj_chat_floating_offset_y" id="vj_chat_floating_offset_y" value="' . esc_attr($val) . '" min="0" max="500" style="width: 70px;"> px';
    echo '<p class="description">' . __('Distance from the top or bottom edge (depending on position). Increase this to move the button up/down.', 'vj-chat-order') . '</p>';
}

function vj_chat_button_priority_callback()
{
    $option = get_option('vj_chat_button_priority', 35);
    ?>
    <select name="vj_chat_button_priority" id="vj_chat_button_priority">
        <option value="25" <?php selected($option, 25); ?>>
            <?php _e('Before Category (inside meta section)', 'vj-chat-order'); ?></option>
        <option value="35" <?php selected($option, 35); ?>>
            <?php _e('After Add to Cart Button - Recommended', 'vj-chat-order'); ?></option>
        <option value="45" <?php selected($option, 45); ?>><?php _e('After Category/Tags', 'vj-chat-order'); ?></option>
    </select>
    <p class="description">
        <?php _e('Choose where the button appears on product pages. Works reliably with Astra and other themes.', 'vj-chat-order'); ?>
    </p>
    <?php
}

/**
 * Design field callbacks
 */
function vj_chat_bg_color_field_callback()
{
    $value = get_option('vj_chat_bg_color', '#25D366');
    echo '<input type="color" name="vj_chat_bg_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Button background color. Default: WhatsApp Green (#25D366)', 'vj-chat-order') . '</p>';
}

function vj_chat_text_color_field_callback()
{
    $value = get_option('vj_chat_text_color', '#ffffff');
    echo '<input type="color" name="vj_chat_text_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Button text and icon color. Default: White (#ffffff)', 'vj-chat-order') . '</p>';
}

function vj_chat_hover_color_field_callback()
{
    $value = get_option('vj_chat_hover_color', '#1ebe5d');
    echo '<input type="color" name="vj_chat_hover_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Button color on hover. Default: Darker Green (#1ebe5d)', 'vj-chat-order') . '</p>';
}

function vj_chat_button_style_field_callback()
{
    $option = get_option('vj_chat_button_style', 'standard');
    ?>
    <select name="vj_chat_button_style" id="vj_chat_button_style">
        <option value="standard" <?php selected($option, 'standard'); ?>>
            <?php _e('Standard (Text + Icon)', 'vj-chat-order'); ?>
        </option>
        <option value="compact" <?php selected($option, 'compact'); ?>><?php _e('Compact (Icon Only)', 'vj-chat-order'); ?>
        </option>
    </select>
    <p class="description"><?php _e('Choose "Compact" for a round, floating-style button. Applies to WooCommerce only.', 'vj-chat-order'); ?></p>
    <?php
}


function vj_chat_compact_size_field_callback()
{
    $value = get_option('vj_chat_compact_size', 44);
    echo '<input type="number" name="vj_chat_compact_size" value="' . esc_attr($value) . '" min="30" max="100" style="width: 80px;"> px';
    echo '<p class="description">' . __('Diameter of the round button. Default: 44px', 'vj-chat-order') . '</p>';
}

function vj_chat_compact_icon_size_field_callback()
{
    $value = get_option('vj_chat_compact_icon_size', 24);
    echo '<input type="number" name="vj_chat_compact_icon_size" value="' . esc_attr($value) . '" min="10" max="80" style="width: 80px;"> px';
    echo '<p class="description">' . __('Size of the icon inside the button. Default: 24px', 'vj-chat-order') . '</p>';
}

function vj_chat_compact_bg_color_field_callback()
{
    $value = get_option('vj_chat_compact_bg_color', '#25D366');
    echo '<input type="color" name="vj_chat_compact_bg_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Button background color for Compact mode. Default: WhatsApp Green (#25D366)', 'vj-chat-order') . '</p>';
}

function vj_chat_compact_text_color_field_callback()
{
    $value = get_option('vj_chat_compact_text_color', '#ffffff');
    echo '<input type="color" name="vj_chat_compact_text_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Icon color for Compact mode. Default: White (#ffffff)', 'vj-chat-order') . '</p>';
}

function vj_chat_compact_hover_color_field_callback()
{
    $value = get_option('vj_chat_compact_hover_color', '#1ebe5d');
    echo '<input type="color" name="vj_chat_compact_hover_color" value="' . esc_attr($value) . '" style="width: 60px; height: 40px; padding: 0; border: 1px solid #ccc; cursor: pointer;">';
    echo '<code style="margin-left: 10px;">' . esc_html($value) . '</code>';
    echo '<p class="description">' . __('Button color on hover for Compact mode. Default: Darker Green (#1ebe5d)', 'vj-chat-order') . '</p>';
}


function vj_chat_border_radius_field_callback()
{
    $value = get_option('vj_chat_border_radius', 8);
    echo '<input type="number" name="vj_chat_border_radius" value="' . esc_attr($value) . '" min="0" max="50" style="width: 80px;"> px';
    echo '<p class="description">' . __('Corner roundness. 0 = square, 25+ = pill shape. Default: 8px', 'vj-chat-order') . '</p>';
}

function vj_chat_font_size_field_callback()
{
    $value = get_option('vj_chat_font_size', 16);
    echo '<input type="number" name="vj_chat_font_size" value="' . esc_attr($value) . '" min="12" max="24" style="width: 80px;"> px';
    echo '<p class="description">' . __('Button text size. Default: 16px', 'vj-chat-order') . '</p>';
}

function vj_chat_margin_field_callback()
{
    $top = get_option('vj_chat_margin_top', 15);
    $bottom = get_option('vj_chat_margin_bottom', 15);
    echo '<input type="number" name="vj_chat_margin_top" value="' . esc_attr($top) . '" style="width: 70px;"> px (top) &nbsp;&nbsp;';
    echo '<input type="number" name="vj_chat_margin_bottom" value="' . esc_attr($bottom) . '" style="width: 70px;"> px (bottom)';
    echo '<p class="description">' . __('Space above and below the button. Default: 15px each', 'vj-chat-order') . '</p>';
}

function vj_chat_padding_field_callback()
{
    $vertical = get_option('vj_chat_padding_vertical', 14);
    $horizontal = get_option('vj_chat_padding_horizontal', 24);
    echo '<input type="number" name="vj_chat_padding_vertical" value="' . esc_attr($vertical) . '" min="5" max="30" style="width: 70px;"> px (vertical) &nbsp;&nbsp;';
    echo '<input type="number" name="vj_chat_padding_horizontal" value="' . esc_attr($horizontal) . '" min="10" max="50" style="width: 70px;"> px (horizontal)';
    echo '<p class="description">' . __('Inner spacing of the button. Default: 14px / 24px', 'vj-chat-order') . '</p>';
}



/**
 * Helper function to render field rows
 */
function vj_chat_render_field_row($label, $callback)
{
    ?>
    <tr>
        <th scope="row"><?php echo esc_html($label); ?></th>
        <td><?php call_user_func($callback); ?></td>
    </tr>
    <?php
}

/**
 * Helper to render message customization row (Label + Icon)
 */
function vj_chat_render_message_field_row($title, $label_key, $label_default, $icon_key, $icon_default)
{
    $label_val = get_option($label_key, $label_default);
    $icon_val = get_option($icon_key, $icon_default);
    ?>
    <tr>
        <th scope="row"><?php echo esc_html($title); ?></th>
        <td>
            <div style="display: flex; gap: 15px; align-items: center;">
                <div style="flex: 1;">
                    <label
                        style="display: block; font-size: 11px; color: #666; margin-bottom: 4px;"><?php esc_html_e('Label Text', 'vj-chat-order'); ?></label>
                    <input type="text" name="<?php echo esc_attr($label_key); ?>"
                        value="<?php echo esc_attr($label_val); ?>" class="regular-text" style="width: 100%;">
                </div>
                <div style="width: 80px;">
                    <label
                        style="display: block; font-size: 11px; color: #666; margin-bottom: 4px;"><?php esc_html_e('Icon', 'vj-chat-order'); ?></label>
                    <input type="text" name="<?php echo esc_attr($icon_key); ?>" value="<?php echo esc_attr($icon_val); ?>"
                        class="regular-text" style="width: 100%; text-align: center;">
                </div>
            </div>
        </td>
    </tr>
    <?php
}

/**
 * Render settings page
 */
function vj_chat_render_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Check if form was submitted
    if (isset($_POST['submit'])) {
        check_admin_referer('vj_chat_settings_group-options');
    }

    // Get current values for preview
    $bg_color = get_option('vj_chat_bg_color', '#25D366');
    $text_color = get_option('vj_chat_text_color', '#ffffff');
    $border_radius = get_option('vj_chat_border_radius', 8);
    $font_size = get_option('vj_chat_font_size', 16);
    $padding_v = get_option('vj_chat_padding_vertical', 14);
    $padding_h = get_option('vj_chat_padding_horizontal', 24);
    $button_text = get_option('vj_chat_button_text', 'Order via WhatsApp');
    $button_style = get_option('vj_chat_button_style', 'standard');
    $icon_url = vj_chat_get_icon_url();
    $chat_button_text = get_option('vj_chat_chat_button_text', 'Need Help? Chat with us');
    $chat_button_style = get_option('vj_chat_chat_button_style', 'standard');
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
    $agent_avatar = get_option('vj_chat_chat_agent_avatar', '');
    if (empty($agent_avatar) || $agent_avatar === vj_chat_get_default_icon_url()) {
        $agent_avatar = vj_chat_get_default_agent_avatar_url();
    }
    $widget_title = get_option('vj_chat_chat_widget_title', 'Start a Conversation');
    $widget_status = get_option('vj_chat_chat_widget_status', 'Typically replies within a day');
    $widget_line_1 = get_option('vj_chat_chat_widget_line1', 'Hi there!');
    $widget_line_2 = get_option('vj_chat_chat_widget_line2', 'How can I help you?');
    $widget_cta = get_option('vj_chat_chat_widget_cta', 'Chat on WhatsApp');
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
    $widget_avatar_scale = absint(get_option('vj_chat_chat_widget_avatar_scale', 100));
    if ($widget_avatar_scale < 40) {
        $widget_avatar_scale = 40;
    }
    if ($widget_avatar_scale > 100) {
        $widget_avatar_scale = 100;
    }
    if ($widget_overlay_opacity < 0) {
        $widget_overlay_opacity = 0;
    }
    if ($widget_overlay_opacity > 1) {
        $widget_overlay_opacity = 1;
    }
    $chat_bg_style = get_option('vj_chat_chat_pill_bg_style', 'solid');
    $chat_bg_color = get_option('vj_chat_chat_pill_bg_color', '#ffffff');
    $chat_text_color = get_option('vj_chat_chat_text_color', '#1d2327');
    $chat_icon_bg_color = get_option('vj_chat_chat_icon_bg_color', '#25D366');
    $chat_border_color = $chat_bg_style === 'transparent' ? 'transparent' : '#e5e7eb';
    $chat_shadow = $chat_bg_style === 'transparent' ? 'none' : '0 8px 20px rgba(0, 0, 0, 0.18)';
    $chat_bg_final = $chat_bg_style === 'transparent' ? 'transparent' : $chat_bg_color;
    ?>
    <div class="wrap">
        <div class="vj-chat-settings-wrap">
        <?php
        // Toast Notifications Logic
        $vj_chat_errors = get_settings_errors();
        $show_success_toast = isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true';
        $toast_errors = array();

        if (!empty($vj_chat_errors)) {
            foreach ($vj_chat_errors as $error) {
                $is_success = in_array($error['type'], array('success', 'updated'), true);
                if ($is_success && $show_success_toast) {
                    continue;
                }
                $toast_errors[] = $error;
            }
        }

        if ($show_success_toast || !empty($toast_errors)) {
            ?>
            <div class="vj-chat-toast-container">
                <?php if ($show_success_toast) : ?>
                    <div class="vj-chat-toast show">
                        <div class="vj-chat-toast-icon">✅</div>
                        <div class="vj-chat-toast-message"><?php echo esc_html__('Settings saved.', 'vj-chat-order'); ?></div>
                        <button type="button" class="vj-chat-toast-dismiss">&times;</button>
                    </div>
                <?php endif; ?>
                <?php
                $seen_codes = array();
                foreach ($toast_errors as $error) {
                    if (in_array($error['code'], $seen_codes))
                        continue;
                    $seen_codes[] = $error['code'];

                    $type = $error['type'];
                    $message = $error['message'];
                    $icon = ($type === 'success' || $type === 'updated') ? '✅' : '⚠️';
                    $is_error = ($type === 'error') ? 'error' : '';
                    ?>
                    <div class="vj-chat-toast <?php echo esc_attr($is_error); ?>">
                        <div class="vj-chat-toast-icon"><?php echo $icon; ?></div>
                        <div class="vj-chat-toast-message"><?php echo esc_html($message); ?></div>
                        <button type="button" class="vj-chat-toast-dismiss">&times;</button>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>

        <!-- Main Content Area -->
        <div class="vj-chat-main-content">

            <!-- Page Header -->
            <div class="vj-chat-page-header">
                <h1><?php esc_html_e('VJ Chat Connect', 'vj-chat-order'); ?></h1>
                <p><?php esc_html_e('Configure chat and WooCommerce order buttons', 'vj-chat-order'); ?>
                </p>
            </div>

            <form action="options.php" method="post">
                <?php settings_fields('vj_chat_settings_group'); ?>

                <!-- Tabs Navigation -->
                <div class="vj-chat-tabs-nav">
                    <button type="button" class="vj-chat-tab-btn active" data-tab="chat">
                        <span class="tab-icon">💬</span> <?php esc_html_e('Chat', 'vj-chat-order'); ?>
                    </button>
                    <button type="button" class="vj-chat-tab-btn" data-tab="woocommerce">
                        <span class="tab-icon">🛒</span> <?php esc_html_e('WooCommerce', 'vj-chat-order'); ?>
                    </button>
                    <button type="button" class="vj-chat-tab-btn" data-tab="design">
                        <span class="tab-icon">🎨</span> <?php esc_html_e('Design', 'vj-chat-order'); ?>
                    </button>
                </div>

                <!-- Tabs Content -->
                <div class="vj-chat-tabs-content">
                    <!-- Chat Tab -->
                    <div class="vj-chat-tab-panel active" id="tab-chat">
                        <table class="form-table">
                            <?php
                            vj_chat_render_field_row(__('Enable Chat', 'vj-chat-order'), 'vj_chat_enable_chat_field_callback');
                            vj_chat_render_field_row(__('Chat Button Text', 'vj-chat-order'), 'vj_chat_chat_button_text_field_callback');
                            vj_chat_render_field_row(__('Chat Button Style', 'vj-chat-order'), 'vj_chat_chat_button_style_field_callback');
                            vj_chat_render_field_row(__('Chat Phone Number', 'vj-chat-order'), 'vj_chat_chat_phone_field_callback');
                            vj_chat_render_field_row(__('Predefined Message', 'vj-chat-order'), 'vj_chat_chat_message_field_callback');
                            ?>
                        </table>

                        <h3 class="vj-chat-section-title"
                            style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                            <?php esc_html_e('Chat Placement', 'vj-chat-order'); ?>
                        </h3>

                        <table class="form-table">
                            <?php
                            vj_chat_render_field_row(__('Placement Mode', 'vj-chat-order'), 'vj_chat_chat_placement_mode_callback');
                            vj_chat_render_field_row(__('Floating Position', 'vj-chat-order'), 'vj_chat_chat_floating_position_callback');
                            vj_chat_render_field_row(__('Horizontal Offset', 'vj-chat-order'), 'vj_chat_chat_floating_offset_x_callback');
                            vj_chat_render_field_row(__('Vertical Offset', 'vj-chat-order'), 'vj_chat_chat_floating_offset_y_callback');
                            vj_chat_render_field_row(__('Hide on Pages', 'vj-chat-order'), 'vj_chat_chat_hide_pages_field_callback');
                            ?>
                        </table>

                        <h3 class="vj-chat-section-title"
                            style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                            <?php esc_html_e('Agent Information', 'vj-chat-order'); ?>
                        </h3>

                        <table class="form-table">
                            <?php
                            vj_chat_render_field_row(__('Agent Name', 'vj-chat-order'), 'vj_chat_chat_agent_name_field_callback');
                            vj_chat_render_field_row(__('Agent Role', 'vj-chat-order'), 'vj_chat_chat_agent_role_field_callback');
                            vj_chat_render_field_row(__('Agent Avatar URL', 'vj-chat-order'), 'vj_chat_chat_agent_avatar_field_callback');
                            ?>
                        </table>

                        <h3 class="vj-chat-section-title"
                            style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                            <?php esc_html_e('Chat Widget Content', 'vj-chat-order'); ?>
                        </h3>

                        <table class="form-table">
                            <?php
                            vj_chat_render_field_row(__('Widget Title', 'vj-chat-order'), 'vj_chat_chat_widget_title_field_callback');
                            vj_chat_render_field_row(__('Widget Status Text', 'vj-chat-order'), 'vj_chat_chat_widget_status_field_callback');
                            vj_chat_render_field_row(__('Message Line 1', 'vj-chat-order'), 'vj_chat_chat_widget_line1_field_callback');
                            vj_chat_render_field_row(__('Message Line 2', 'vj-chat-order'), 'vj_chat_chat_widget_line2_field_callback');
                            vj_chat_render_field_row(__('CTA Button Text', 'vj-chat-order'), 'vj_chat_chat_widget_cta_field_callback');
                            ?>
                        </table>

                        <p class="description" style="margin-top: 16px;">
                            <?php esc_html_e('Use shortcode', 'vj-chat-order'); ?>
                            <code>[vj_chat_order_button mode="chat"]</code>
                            <?php esc_html_e('to place the chat button anywhere.', 'vj-chat-order'); ?>
                        </p>
                    </div>

                    <!-- WooCommerce Tab -->
                    <div class="vj-chat-tab-panel" id="tab-woocommerce">
                        <table class="form-table">
                            <?php
                            vj_chat_render_field_row(__('Enable WooCommerce Order', 'vj-chat-order'), 'vj_chat_enable_woo_field_callback');
                            ?>
                        </table>

                        <div id="vj-chat-woo-settings">
                            <table class="form-table">
                                <?php
                                vj_chat_render_field_row(__('WhatsApp Phone Number', 'vj-chat-order'), 'vj_chat_phone_field_callback');
                                vj_chat_render_field_row(__('Button Text', 'vj-chat-order'), 'vj_chat_button_text_field_callback');
                                vj_chat_render_field_row(__('WhatsApp Icon', 'vj-chat-order'), 'vj_chat_icon_url_field_callback');
                                vj_chat_render_field_row(__('Button Style', 'vj-chat-order'), 'vj_chat_button_style_field_callback');
                                ?>
                            </table>

                            <h3 class="vj-chat-section-title"
                                style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                                <?php esc_html_e('Placement Configuration', 'vj-chat-order'); ?>
                            </h3>

                            <table class="form-table">
                                <?php
                                vj_chat_render_field_row(__('Placement Mode', 'vj-chat-order'), 'vj_chat_placement_mode_callback');
                                vj_chat_render_field_row(__('Button Position', 'vj-chat-order'), 'vj_chat_button_priority_callback');
                                vj_chat_render_field_row(__('Floating Position', 'vj-chat-order'), 'vj_chat_floating_position_callback');
                                vj_chat_render_field_row(__('Horizontal Offset', 'vj-chat-order'), 'vj_chat_floating_offset_x_callback');
                                vj_chat_render_field_row(__('Vertical Offset', 'vj-chat-order'), 'vj_chat_floating_offset_y_callback');
                                ?>
                            </table>

                            <h3 class="vj-chat-section-title"
                                style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                                <?php esc_html_e('Message Settings', 'vj-chat-order'); ?>
                            </h3>

                            <table class="form-table">
                                <?php
                                vj_chat_render_field_row(__('Intro Message', 'vj-chat-order'), 'vj_chat_intro_message_field_callback');
                                ?>
                            </table>

                            <h3 class="vj-chat-section-title"
                                style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                                <?php esc_html_e('Message Labels & Icons', 'vj-chat-order'); ?>
                            </h3>

                            <div
                                style="background: #f0f6fc; border: 1px solid #e0e0e0; border-left: 4px solid #25D366; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px;">
                                <p style="margin: 0; font-size: 13px; color: #1d2327;">
                                    <strong>💡 <?php esc_html_e('Pro Tip:', 'vj-chat-order'); ?></strong>
                                    <?php esc_html_e('Use emojis to make your message stand out!', 'vj-chat-order'); ?>
                                </p>
                                <p style="margin: 8px 0 0; font-size: 12px; color: #646970;">
                                    • <strong>Windows:</strong> <?php esc_html_e('Press', 'vj-chat-order'); ?> <code
                                        style="background: #fff; padding: 2px 6px; border-radius: 3px; border: 1px solid #ccc;">Win</code>
                                    + <code
                                        style="background: #fff; padding: 2px 6px; border-radius: 3px; border: 1px solid #ccc;">.</code>
                                    <?php esc_html_e('to open the emoji picker.', 'vj-chat-order'); ?><br>
                                    • <strong>Mac:</strong> <?php esc_html_e('Press', 'vj-chat-order'); ?> <code
                                        style="background: #fff; padding: 2px 6px; border-radius: 3px; border: 1px solid #ccc;">Cmd</code>
                                    + <code
                                        style="background: #fff; padding: 2px 6px; border-radius: 3px; border: 1px solid #ccc;">Ctrl</code>
                                    + <code
                                        style="background: #fff; padding: 2px 6px; border-radius: 3px; border: 1px solid #ccc;">Space</code><br>
                                    • <strong>Web:</strong> <?php printf(
                                        /* translators: %s: Emojipedia URL */
                                        esc_html__('Visit %s to copy and paste emojis.', 'vj-chat-order'),
                                        '<a href="https://emojipedia.org/" target="_blank" style="text-decoration: none; color: #2271b1;">Emojipedia.org <span style="font-size: 10px;">↗</span></a>'
                                    ); ?>
                                </p>
                            </div>

                            <p class="description" style="margin-bottom: 20px;">
                                <?php esc_html_e('Customize the text and icons used in the WhatsApp message.', 'vj-chat-order'); ?>
                            </p>

                            <table class="form-table">
                                <?php
                                vj_chat_render_message_field_row(__('Product', 'vj-chat-order'), 'vj_chat_label_product', 'Product', 'vj_chat_icon_product', '🛒');
                                vj_chat_render_message_field_row(__('Quantity', 'vj-chat-order'), 'vj_chat_label_quantity', 'Quantity', 'vj_chat_icon_quantity', '🔢');
                                vj_chat_render_message_field_row(__('Price', 'vj-chat-order'), 'vj_chat_label_price', 'Price', 'vj_chat_icon_price', '💰');
                                vj_chat_render_message_field_row(__('Total', 'vj-chat-order'), 'vj_chat_label_total', 'Total', 'vj_chat_icon_total', '💵');
                                vj_chat_render_message_field_row(__('Link', 'vj-chat-order'), 'vj_chat_label_link', 'Link', 'vj_chat_icon_link', '🔗');
                                ?>
                            </table>
                        </div>
                    </div>

                    <!-- Design Tab -->
                    <div class="vj-chat-tab-panel" id="tab-design">
                        <h3 class="vj-chat-section-title"
                            style="margin: 0 0 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                            <?php esc_html_e('Chat Button Style', 'vj-chat-order'); ?>
                        </h3>

                        <table class="form-table">
                            <?php
                            vj_chat_render_field_row(__('Chat Background Style', 'vj-chat-order'), 'vj_chat_chat_pill_bg_style_field_callback');
                            vj_chat_render_field_row(__('Chat Background Color', 'vj-chat-order'), 'vj_chat_chat_pill_bg_color_field_callback');
                            vj_chat_render_field_row(__('Chat Text Color', 'vj-chat-order'), 'vj_chat_chat_text_color_field_callback');
                            vj_chat_render_field_row(__('Chat Font Size', 'vj-chat-order'), 'vj_chat_chat_font_size_field_callback');
                            vj_chat_render_field_row(__('Chat Hover Color', 'vj-chat-order'), 'vj_chat_chat_hover_color_field_callback');
                            vj_chat_render_field_row(__('Chat Border Radius', 'vj-chat-order'), 'vj_chat_chat_border_radius_field_callback');
                            vj_chat_render_field_row(__('Chat Padding', 'vj-chat-order'), 'vj_chat_chat_padding_field_callback');
                            vj_chat_render_field_row(__('Chat Margin', 'vj-chat-order'), 'vj_chat_chat_margin_field_callback');
                            vj_chat_render_field_row(__('Chat Icon Bubble Size', 'vj-chat-order'), 'vj_chat_chat_icon_wrap_size_field_callback');
                            vj_chat_render_field_row(__('Chat Icon Size', 'vj-chat-order'), 'vj_chat_chat_icon_size_field_callback');
                            vj_chat_render_field_row(__('Chat Compact Size', 'vj-chat-order'), 'vj_chat_chat_compact_size_field_callback');
                            vj_chat_render_field_row(__('Chat Compact Icon Size', 'vj-chat-order'), 'vj_chat_chat_compact_icon_size_field_callback');
                            vj_chat_render_field_row(__('Chat Icon Background', 'vj-chat-order'), 'vj_chat_chat_icon_bg_color_field_callback');
                            ?>
                        </table>

                        <h3 class="vj-chat-section-title"
                            style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                            <?php esc_html_e('Chat Widget Style', 'vj-chat-order'); ?>
                        </h3>

                        <table class="form-table">
                            <?php
                            vj_chat_render_field_row(__('Widget Width', 'vj-chat-order'), 'vj_chat_chat_widget_width_field_callback');
                            vj_chat_render_field_row(__('Widget Max Height', 'vj-chat-order'), 'vj_chat_chat_widget_max_height_field_callback');
                            vj_chat_render_field_row(__('Widget Border Radius', 'vj-chat-order'), 'vj_chat_chat_widget_radius_field_callback');
                            vj_chat_render_field_row(__('Header Background', 'vj-chat-order'), 'vj_chat_chat_widget_header_bg_field_callback');
                            vj_chat_render_field_row(__('Header Text Color', 'vj-chat-order'), 'vj_chat_chat_widget_header_text_field_callback');
                            vj_chat_render_field_row(__('Status Text Color', 'vj-chat-order'), 'vj_chat_chat_widget_status_text_field_callback');
                            vj_chat_render_field_row(__('Body Background', 'vj-chat-order'), 'vj_chat_chat_widget_body_bg_field_callback');
                            vj_chat_render_field_row(__('Bubble Background', 'vj-chat-order'), 'vj_chat_chat_widget_bubble_bg_field_callback');
                            vj_chat_render_field_row(__('Bubble Text Color', 'vj-chat-order'), 'vj_chat_chat_widget_bubble_text_field_callback');
                            vj_chat_render_field_row(__('CTA Background', 'vj-chat-order'), 'vj_chat_chat_widget_cta_bg_field_callback');
                            vj_chat_render_field_row(__('CTA Text Color', 'vj-chat-order'), 'vj_chat_chat_widget_cta_text_field_callback');
                            vj_chat_render_field_row(__('Close Button Background', 'vj-chat-order'), 'vj_chat_chat_widget_close_bg_field_callback');
                            vj_chat_render_field_row(__('Close Icon Color', 'vj-chat-order'), 'vj_chat_chat_widget_close_text_field_callback');
                            vj_chat_render_field_row(__('Avatar Image Size', 'vj-chat-order'), 'vj_chat_chat_widget_avatar_scale_field_callback');
                            vj_chat_render_field_row(__('Overlay Opacity', 'vj-chat-order'), 'vj_chat_chat_widget_overlay_opacity_field_callback');
                            ?>
                        </table>

                        <h3 class="vj-chat-section-title"
                            style="margin: 30px 0 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                            <?php esc_html_e('WooCommerce Button Style', 'vj-chat-order'); ?>
                        </h3>

                        <!-- Standard Design Settings -->
                        <table class="form-table" id="vj-standard-design-table">
                            <?php
                            vj_chat_render_field_row(__('Background Color', 'vj-chat-order'), 'vj_chat_bg_color_field_callback');
                            vj_chat_render_field_row(__('Text Color', 'vj-chat-order'), 'vj_chat_text_color_field_callback');
                            vj_chat_render_field_row(__('Hover Color', 'vj-chat-order'), 'vj_chat_hover_color_field_callback');
                            vj_chat_render_field_row(__('Border Radius', 'vj-chat-order'), 'vj_chat_border_radius_field_callback');
                            vj_chat_render_field_row(__('Font Size', 'vj-chat-order'), 'vj_chat_font_size_field_callback');
                            vj_chat_render_field_row(__('Margin', 'vj-chat-order'), 'vj_chat_margin_field_callback');
                            vj_chat_render_field_row(__('Padding', 'vj-chat-order'), 'vj_chat_padding_field_callback');
                            ?>
                        </table>

                        <!-- Compact Design Settings -->
                        <table class="form-table" id="vj-compact-design-table" style="display:none;">
                            <?php
                            vj_chat_render_field_row(__('Compact Button Size', 'vj-chat-order'), 'vj_chat_compact_size_field_callback');
                            vj_chat_render_field_row(__('Compact Icon Size', 'vj-chat-order'), 'vj_chat_compact_icon_size_field_callback');
                            vj_chat_render_field_row(__('Background Color', 'vj-chat-order'), 'vj_chat_compact_bg_color_field_callback');
                            vj_chat_render_field_row(__('Icon Color', 'vj-chat-order'), 'vj_chat_compact_text_color_field_callback');
                            vj_chat_render_field_row(__('Hover Color', 'vj-chat-order'), 'vj_chat_compact_hover_color_field_callback');
                            ?>
                        </table>
                    </div>
                </div>

                <div style="margin-top: 24px;">
                    <?php submit_button(__('Save Settings', 'vj-chat-order'), 'primary', 'submit', false); ?>
                </div>
            </form>
        </div>

        <!-- Sidebar Preview -->
        <div class="vj-chat-sidebar">
            <div class="vj-chat-card">
                <div class="vj-chat-card-header">
                    <div class="vj-chat-card-icon preview">
                        <span style="color: #fff; font-size: 18px;">👁️</span>
                    </div>
                    <div>
                        <h2 class="vj-chat-card-title"><?php esc_html_e('Live Preview', 'vj-chat-order'); ?></h2>
                        <p class="vj-chat-card-description"><?php esc_html_e('Save to update', 'vj-chat-order'); ?></p>
                    </div>
                </div>

                <div class="vj-chat-preview-sections">
                    <!-- Chat Button Preview -->
                    <div class="vj-chat-preview-section vj-chat-preview-chat-button">
                        <div class="vj-chat-preview-label"><?php esc_html_e('Chat Button', 'vj-chat-order'); ?></div>
                        <div class="vj-chat-preview-box">
                            <a href="#" onclick="return false;" class="vj-chat-preview-chat-btn" style="
                                color: <?php echo esc_attr($chat_text_color); ?>;
                                font-size: <?php echo esc_attr($chat_font_size); ?>px;
                                margin-top: <?php echo esc_attr($chat_margin_top); ?>px;
                                margin-bottom: <?php echo esc_attr($chat_margin_bottom); ?>px;
                            ">
                                <span class="vj-chat-preview-chat-text" style="
                                    background-color: <?php echo esc_attr($chat_bg_final); ?>;
                                    border-color: <?php echo esc_attr($chat_border_color); ?>;
                                    box-shadow: <?php echo esc_attr($chat_shadow); ?>;
                                    color: <?php echo esc_attr($chat_text_color); ?>;
                                    border-radius: <?php echo esc_attr($chat_border_radius); ?>px;
                                    padding: <?php echo esc_attr($chat_padding_v); ?>px <?php echo esc_attr($chat_padding_h); ?>px;
                                "><?php echo esc_html($chat_button_text); ?></span>
                                <span class="vj-chat-preview-chat-icon" style="background-color: <?php echo esc_attr($chat_icon_bg_color); ?>; width: <?php echo esc_attr($chat_button_style === 'compact' ? $chat_compact_size : $chat_icon_wrap_size); ?>px; height: <?php echo esc_attr($chat_button_style === 'compact' ? $chat_compact_size : $chat_icon_wrap_size); ?>px;">
                                    <img src="<?php echo esc_url($icon_url); ?>" alt="WhatsApp" style="width: <?php echo esc_attr($chat_button_style === 'compact' ? $chat_compact_icon_size : $chat_icon_size); ?>px; height: <?php echo esc_attr($chat_button_style === 'compact' ? $chat_compact_icon_size : $chat_icon_size); ?>px;">
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="vj-chat-preview-section vj-chat-preview-chat-widget">
                        <div class="vj-chat-preview-label"><?php esc_html_e('Chat Widget', 'vj-chat-order'); ?></div>
                        <div class="vj-chat-preview-widget" style="
                            background-color: <?php echo esc_attr($widget_body_bg); ?>;
                            border-radius: <?php echo esc_attr($widget_radius); ?>px;
                            width: <?php echo esc_attr($widget_width); ?>px;
                            max-width: 100%;
                        ">
                            <div class="vj-chat-preview-widget-header" style="background-color: <?php echo esc_attr($widget_header_bg); ?>; color: <?php echo esc_attr($widget_header_text); ?>;">
                                <div class="vj-chat-preview-widget-header-main">
                                    <span class="vj-chat-preview-widget-avatar">
                                        <img src="<?php echo esc_url($agent_avatar); ?>" alt="" style="width: <?php echo esc_attr($widget_avatar_scale); ?>%; height: <?php echo esc_attr($widget_avatar_scale); ?>%;">
                                    </span>
                                    <div class="vj-chat-preview-widget-header-text">
                                        <div class="vj-chat-preview-widget-title"><?php echo esc_html($widget_title); ?></div>
                                        <div class="vj-chat-preview-widget-status" style="color: <?php echo esc_attr($widget_status_text); ?>;">
                                            <span class="vj-chat-preview-widget-status-dot" style="background-color: <?php echo esc_attr($widget_cta_bg); ?>;"></span>
                                            <?php echo esc_html($widget_status); ?>
                                        </div>
                                    </div>
                                    <span class="vj-chat-preview-widget-close" style="background-color: <?php echo esc_attr($widget_close_bg); ?>; color: <?php echo esc_attr($widget_close_text); ?>;">×</span>
                                </div>
                            </div>
                            <div class="vj-chat-preview-widget-body" style="background-color: <?php echo esc_attr($widget_body_bg); ?>;">
                                <div class="vj-chat-preview-widget-bubble" style="background-color: <?php echo esc_attr($widget_bubble_bg); ?>; color: <?php echo esc_attr($widget_bubble_text); ?>;">
                                    <?php echo esc_html($widget_line_1); ?>
                                </div>
                                <div class="vj-chat-preview-widget-bubble" style="background-color: <?php echo esc_attr($widget_bubble_bg); ?>; color: <?php echo esc_attr($widget_bubble_text); ?>;">
                                    <?php echo esc_html($widget_line_2); ?>
                                </div>
                                <div class="vj-chat-preview-widget-cta" style="background-color: <?php echo esc_attr($widget_cta_bg); ?>; color: <?php echo esc_attr($widget_cta_text); ?>;">
                                    <img src="<?php echo esc_url($icon_url); ?>" alt="" style="width: 18px; height: 18px; filter: brightness(0) invert(1);">
                                    <span><?php echo esc_html($widget_cta); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Full Button Preview -->
                    <div class="vj-chat-preview-section vj-chat-preview-woo-full">
                        <div class="vj-chat-preview-label"><?php esc_html_e('Full Button', 'vj-chat-order'); ?></div>
                        <div class="vj-chat-preview-box">
                            <a href="#" onclick="return false;" class="vj-chat-preview-full-btn" style="
                                background-color: <?php echo esc_attr($bg_color); ?>;
                                color: <?php echo esc_attr($text_color); ?>;
                                padding: <?php echo esc_attr($padding_v); ?>px <?php echo esc_attr($padding_h); ?>px;
                                border-radius: <?php echo esc_attr($border_radius); ?>px;
                                font-size: <?php echo esc_attr($font_size); ?>px;
                            ">
                                <img src="<?php echo esc_url($icon_url); ?>" alt="WhatsApp"
                                    style="width: 20px; height: 20px; filter: brightness(0) invert(1);">
                                <?php echo esc_html($button_text); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Compact Icon Preview -->
                    <div class="vj-chat-preview-section vj-chat-preview-woo-compact">
                        <div class="vj-chat-preview-label"><?php esc_html_e('Compact Button', 'vj-chat-order'); ?>
                        </div>
                        <div class="vj-chat-preview-box sticky-preview">
                            <a href="#" onclick="return false;" class="vj-chat-preview-icon-btn" style="
                                background-color: <?php echo esc_attr($bg_color); ?>;
                            ">
                                <img src="<?php echo esc_url($icon_url); ?>" alt="WhatsApp">
                            </a>
                        </div>
                    </div>
                </div>

                <p class="description" style="margin-top: 16px; text-align: center; font-size: 11px;">
                    <?php _e('Standard: Full button with text + icon', 'vj-chat-order'); ?><br>
                    <?php _e('Compact: Round icon button (great for floating)', 'vj-chat-order'); ?>
                </p>
            </div>
        </div>
        </div>
    </div>
    <?php
}
