<?php
/**
 * Uninstall Plugin
 *
 * Fired when the plugin is deleted.
 *
 * @package VJ_Chat_Order
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Additional security check
if (!current_user_can('activate_plugins')) {
    exit;
}

$vj_chat_options = array(
    // General Settings
    'vj_chat_enable_chat',
    'vj_chat_chat_phone',
    'vj_chat_chat_button_text',
    'vj_chat_chat_message',
    'vj_chat_chat_agent_name',
    'vj_chat_chat_agent_role',
    'vj_chat_chat_agent_avatar',
    'vj_chat_chat_placement_mode',
    'vj_chat_chat_floating_position',
    'vj_chat_chat_floating_offset_x',
    'vj_chat_chat_floating_offset_y',
    'vj_chat_chat_pill_bg_style',
    'vj_chat_chat_pill_bg_color',
    'vj_chat_chat_text_color',
    'vj_chat_chat_icon_bg_color',
    'vj_chat_chat_button_style',
    'vj_chat_chat_font_size',
    'vj_chat_chat_hover_color',
    'vj_chat_chat_border_radius',
    'vj_chat_chat_padding_vertical',
    'vj_chat_chat_padding_horizontal',
    'vj_chat_chat_margin_top',
    'vj_chat_chat_margin_bottom',
    'vj_chat_chat_icon_wrap_size',
    'vj_chat_chat_icon_size',
    'vj_chat_chat_compact_size',
    'vj_chat_chat_compact_icon_size',
    'vj_chat_chat_hide_pages',
    'vj_chat_chat_widget_title',
    'vj_chat_chat_widget_status',
    'vj_chat_chat_widget_line1',
    'vj_chat_chat_widget_line2',
    'vj_chat_chat_widget_cta',
    'vj_chat_chat_widget_width',
    'vj_chat_chat_widget_max_height',
    'vj_chat_chat_widget_radius',
    'vj_chat_chat_widget_header_bg',
    'vj_chat_chat_widget_header_text',
    'vj_chat_chat_widget_status_text',
    'vj_chat_chat_widget_body_bg',
    'vj_chat_chat_widget_bubble_bg',
    'vj_chat_chat_widget_bubble_text',
    'vj_chat_chat_widget_cta_bg',
    'vj_chat_chat_widget_cta_text',
    'vj_chat_chat_widget_close_bg',
    'vj_chat_chat_widget_close_text',
    'vj_chat_chat_widget_overlay_opacity',
    'vj_chat_enable_woo',
    'vj_chat_phone_number',
    'vj_chat_button_text',
    'vj_chat_icon_url',
    'vj_chat_intro_message',
    // Placement Settings
    'vj_chat_placement_mode',
    'vj_chat_button_priority',
    'vj_chat_floating_position',
    'vj_chat_floating_offset_x',
    'vj_chat_floating_offset_y',
    // Standard Design Settings
    'vj_chat_button_style',
    'vj_chat_bg_color',
    'vj_chat_text_color',
    'vj_chat_hover_color',
    'vj_chat_border_radius',
    'vj_chat_font_size',
    'vj_chat_margin_top',
    'vj_chat_margin_bottom',
    'vj_chat_padding_vertical',
    'vj_chat_padding_horizontal',
    // Compact Design Settings
    'vj_chat_compact_size',
    'vj_chat_compact_icon_size',
    'vj_chat_compact_bg_color',
    'vj_chat_compact_text_color',
    'vj_chat_compact_hover_color',
    // Message Labels
    'vj_chat_label_product',
    'vj_chat_icon_product',
    'vj_chat_label_quantity',
    'vj_chat_icon_quantity',
    'vj_chat_label_price',
    'vj_chat_icon_price',
    'vj_chat_label_total',
    'vj_chat_icon_total',
    'vj_chat_label_link',
    'vj_chat_icon_link'
);

// Delete options
foreach ($vj_chat_options as $option) {
    delete_option($option);
}

// Delete user meta (active tab preference) - Using SQL for performance on large sites
global $wpdb;
$wpdb->query("DELETE FROM $wpdb->usermeta WHERE meta_key = 'vj_chat_active_tab'");
