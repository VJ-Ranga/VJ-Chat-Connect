jQuery(document).ready(function ($) {

    

    // ==========================================
    // Tab Switching Logic
    // ==========================================
    // Check for saved tab (Server-Side)
    var activeTab = vjChatAdminData.activeTab || 'general';

    // Initialize: Set the saved tab as active
    function initializeTabs() {
        $('.vj-chat-tab-btn').removeClass('active');
        $('.vj-chat-tab-panel').removeClass('active');

        $('.vj-chat-tab-btn[data-tab="' + activeTab + '"]').addClass('active');
        $('#tab-' + activeTab).addClass('active');
    }

    // Initialize on page load
    initializeTabs();

    // Handle tab clicks
    $('.vj-chat-tab-btn').on('click', function (e) {
        e.preventDefault();

        var tabId = $(this).data('tab');

        // Validate tab exists
        if (!$('#tab-' + tabId).length) {
            console.warn('Tab not found: ' + tabId);
            return;
        }

        // Update UI immediately (no server delay)
        activeTab = tabId;
        initializeTabs();

        // Save to server (fire and forget)
        $.post(vjChatAdminData.ajaxUrl, {
            action: 'vj_chat_save_active_tab',
            tab: tabId,
            nonce: vjChatAdminData.nonce
        }).fail(function () {
            console.error('Failed to save tab preference');
        });
    });

    // ==========================================
    // Media Uploader Logic
    // ==========================================
    var defaultIcon = vjChatAdminData.defaultIcon;
    var defaultAvatar = vjChatAdminData.defaultAvatar || defaultIcon;
    var mediaUploader;
    var avatarUploader;

    $('.vj-chat-upload-icon-btn').on('click', function (e) {
        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Extend the wp.media object
        mediaUploader = wp.media({
            title: vjChatAdminData.uploaderTitle,
            button: {
                text: vjChatAdminData.uploaderButton
            },
            multiple: false
        });

        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#vj_chat_icon_url').val(attachment.url);
            $('.vj-chat-icon-preview img').attr('src', attachment.url);
            refreshLivePreview();
        });

        // Open the uploader dialog
        mediaUploader.open();
    });

    // Reset to Default Icon
    $('.vj-chat-reset-icon-btn').on('click', function (e) {
        e.preventDefault();
        $('#vj_chat_icon_url').val('');
        $('.vj-chat-icon-preview img').attr('src', defaultIcon);
        refreshLivePreview();
    });

    // Valid URL Manual Entry Update
    $('#vj_chat_icon_url').on('change input', function () {
        var url = $(this).val();
        if (url.length > 0) {
            $('.vj-chat-icon-preview img').attr('src', url);
        } else {
            $('.vj-chat-icon-preview img').attr('src', defaultIcon);
        }
    });

    // ==========================================
    // Agent Avatar Uploader Logic
    // ==========================================
    $('.vj-chat-upload-avatar-btn').on('click', function (e) {
        e.preventDefault();

        if (avatarUploader) {
            avatarUploader.open();
            return;
        }

        avatarUploader = wp.media({
            title: 'Select Agent Avatar',
            button: {
                text: 'Use This Avatar'
            },
            multiple: false
        });

        avatarUploader.on('select', function () {
            var attachment = avatarUploader.state().get('selection').first().toJSON();
            $('#vj_chat_chat_agent_avatar').val(attachment.url);
            $('.vj-chat-agent-avatar-preview-img').attr('src', attachment.url);
            refreshLivePreview();
        });

        avatarUploader.open();
    });

    $('.vj-chat-reset-avatar-btn').on('click', function (e) {
        e.preventDefault();
        $('#vj_chat_chat_agent_avatar').val('');
        $('.vj-chat-agent-avatar-preview-img').attr('src', defaultAvatar);
        refreshLivePreview();
    });

    $('#vj_chat_chat_agent_avatar').on('change input', function () {
        var url = $(this).val();
        if (url.length > 0) {
            $('.vj-chat-agent-avatar-preview-img').attr('src', url);
        } else {
            $('.vj-chat-agent-avatar-preview-img').attr('src', defaultAvatar);
        }
    });

    // ==========================================
    // Toast Notifications
    // ==========================================

    // Show Toasts with Animation
    setTimeout(function () {
        $('.vj-chat-toast').addClass('show');
    }, 100);

    // Auto Dismiss after 5 seconds
    setTimeout(function () {
        $('.vj-chat-toast').removeClass('show');
        setTimeout(function () {
            $('.vj-chat-toast-container').remove();
        }, 300);
    }, 5000);

    // Manual Dismiss
    $('.vj-chat-toast-dismiss').on('click', function () {
        $(this).closest('.vj-chat-toast').removeClass('show');
    });

    // ==========================================
    // Live Preview - Button Style Toggles
    // ==========================================
    function updateWooPreviewStyle() {
        var isCompact = $('#vj_chat_button_style').val() === 'compact';
        $('.vj-chat-preview-woo-full').toggle(!isCompact);
        $('.vj-chat-preview-woo-compact').toggle(isCompact);
    }

    function updateChatPreviewStyle() {
        var isCompact = $('#vj_chat_chat_button_style').val() === 'compact';
        var preview = $('.vj-chat-preview-chat-btn');
        var textEl = preview.find('.vj-chat-preview-chat-text');
        var iconWrap = preview.find('.vj-chat-preview-chat-icon');
        var iconImg = iconWrap.find('img');

        textEl.toggle(!isCompact);

        var wrapSize = parseInt(isCompact ? $('[name="vj_chat_chat_compact_size"]').val() : $('[name="vj_chat_chat_icon_wrap_size"]').val(), 10);
        var iconSize = parseInt(isCompact ? $('[name="vj_chat_chat_compact_icon_size"]').val() : $('[name="vj_chat_chat_icon_size"]').val(), 10);

        if (!isNaN(wrapSize)) {
            iconWrap.css({ width: wrapSize + 'px', height: wrapSize + 'px' });
        }
        if (!isNaN(iconSize)) {
            iconImg.css({ width: iconSize + 'px', height: iconSize + 'px' });
        }
    }

    function getFieldValue(name, fallback) {
        var $field = $('[name="' + name + '"]');
        if (!$field.length) {
            return fallback;
        }
        var value = $field.val();
        if (value === undefined || value === null || value === '') {
            return fallback;
        }
        return value;
    }

    function refreshLivePreview() {
        var iconUrl = getFieldValue('vj_chat_icon_url', '');
        if (!iconUrl) {
            iconUrl = defaultIcon;
        }

        // Shared icon updates
        $('.vj-chat-preview-full-btn img, .vj-chat-preview-icon-btn img, .vj-chat-preview-chat-icon img, .vj-chat-preview-widget-cta img').attr('src', iconUrl);

        // Woo preview updates
        $('.vj-chat-preview-full-btn').css({
            backgroundColor: getFieldValue('vj_chat_bg_color', '#25D366'),
            color: getFieldValue('vj_chat_text_color', '#ffffff'),
            borderRadius: getFieldValue('vj_chat_border_radius', 8) + 'px',
            fontSize: getFieldValue('vj_chat_font_size', 16) + 'px',
            padding: getFieldValue('vj_chat_padding_vertical', 14) + 'px ' + getFieldValue('vj_chat_padding_horizontal', 24) + 'px'
        }).contents().filter(function () {
            return this.nodeType === 3;
        }).last().replaceWith(' ' + getFieldValue('vj_chat_button_text', 'Order via WhatsApp'));

        $('.vj-chat-preview-icon-btn').css({
            backgroundColor: getFieldValue('vj_chat_compact_bg_color', '#25D366'),
            width: getFieldValue('vj_chat_compact_size', 44) + 'px',
            height: getFieldValue('vj_chat_compact_size', 44) + 'px'
        });
        $('.vj-chat-preview-icon-btn img').css({
            width: getFieldValue('vj_chat_compact_icon_size', 24) + 'px',
            height: getFieldValue('vj_chat_compact_icon_size', 24) + 'px'
        });

        // Chat button preview updates
        var chatStyle = getFieldValue('vj_chat_chat_button_style', 'standard');
        var chatBgStyle = getFieldValue('vj_chat_chat_pill_bg_style', 'solid');
        var chatBg = chatBgStyle === 'transparent' ? 'transparent' : getFieldValue('vj_chat_chat_pill_bg_color', '#ffffff');
        var chatBorder = chatBgStyle === 'transparent' ? 'transparent' : '#e5e7eb';
        var chatShadow = chatBgStyle === 'transparent' ? 'none' : '0 8px 20px rgba(0, 0, 0, 0.18)';

        $('.vj-chat-preview-chat-btn').css({
            color: getFieldValue('vj_chat_chat_text_color', '#1d2327'),
            fontSize: getFieldValue('vj_chat_chat_font_size', 14) + 'px',
            marginTop: getFieldValue('vj_chat_chat_margin_top', 0) + 'px',
            marginBottom: getFieldValue('vj_chat_chat_margin_bottom', 0) + 'px'
        });

        $('.vj-chat-preview-chat-text')
            .text(getFieldValue('vj_chat_chat_button_text', 'Need Help? Chat with us'))
            .css({
                backgroundColor: chatBg,
                borderColor: chatBorder,
                boxShadow: chatShadow,
                color: getFieldValue('vj_chat_chat_text_color', '#1d2327'),
                borderRadius: getFieldValue('vj_chat_chat_border_radius', 999) + 'px',
                padding: getFieldValue('vj_chat_chat_padding_vertical', 10) + 'px ' + getFieldValue('vj_chat_chat_padding_horizontal', 16) + 'px'
            })
            .toggle(chatStyle !== 'compact');

        $('.vj-chat-preview-chat-icon').css({
            backgroundColor: getFieldValue('vj_chat_chat_icon_bg_color', '#25D366')
        });

        // Widget preview updates
        var avatarUrl = getFieldValue('vj_chat_chat_agent_avatar', '');
        if (!avatarUrl) {
            avatarUrl = defaultAvatar;
        }

        $('.vj-chat-preview-widget').css({
            backgroundColor: getFieldValue('vj_chat_chat_widget_body_bg', '#f0f0f0'),
            borderRadius: getFieldValue('vj_chat_chat_widget_radius', 18) + 'px',
            width: getFieldValue('vj_chat_chat_widget_width', 320) + 'px'
        });
        var maxHeight = parseInt(getFieldValue('vj_chat_chat_widget_max_height', 0), 10);
        if (!isNaN(maxHeight) && maxHeight > 0) {
            $('.vj-chat-preview-widget').css('max-height', maxHeight + 'px');
        } else {
            $('.vj-chat-preview-widget').css('max-height', '');
        }

        $('.vj-chat-preview-widget-header').css({
            backgroundColor: getFieldValue('vj_chat_chat_widget_header_bg', '#25D366'),
            color: getFieldValue('vj_chat_chat_widget_header_text', '#ffffff')
        });
        $('.vj-chat-preview-widget-title').text(getFieldValue('vj_chat_chat_widget_title', 'Start a Conversation'));
        $('.vj-chat-preview-widget-status').css('color', getFieldValue('vj_chat_chat_widget_status_text', '#e5f4dc'));
        $('.vj-chat-preview-widget-status').contents().filter(function () { return this.nodeType === 3; }).remove();
        $('.vj-chat-preview-widget-status').append(document.createTextNode(' ' + getFieldValue('vj_chat_chat_widget_status', 'Typically replies within a day')));
        $('.vj-chat-preview-widget-status-dot').css('background-color', getFieldValue('vj_chat_chat_widget_cta_bg', '#25D366'));
        $('.vj-chat-preview-widget-close').css({
            backgroundColor: getFieldValue('vj_chat_chat_widget_close_bg', '#25D366'),
            color: getFieldValue('vj_chat_chat_widget_close_text', '#ffffff')
        });
        $('.vj-chat-preview-widget-body').css('background-color', getFieldValue('vj_chat_chat_widget_body_bg', '#f0f0f0'));
        $('.vj-chat-preview-widget-bubble').css({
            backgroundColor: getFieldValue('vj_chat_chat_widget_bubble_bg', '#ffffff'),
            color: getFieldValue('vj_chat_chat_widget_bubble_text', '#1d2327')
        });
        $('.vj-chat-preview-widget-bubble').eq(0).text(getFieldValue('vj_chat_chat_widget_line1', 'Hi there!'));
        $('.vj-chat-preview-widget-bubble').eq(1).text(getFieldValue('vj_chat_chat_widget_line2', 'How can I help you?'));
        $('.vj-chat-preview-widget-cta').css({
            backgroundColor: getFieldValue('vj_chat_chat_widget_cta_bg', '#25D366'),
            color: getFieldValue('vj_chat_chat_widget_cta_text', '#ffffff')
        });
        $('.vj-chat-preview-widget-cta span').text(getFieldValue('vj_chat_chat_widget_cta', 'Chat on WhatsApp'));
        $('.vj-chat-preview-widget-avatar img').attr('src', avatarUrl).css({
            width: getFieldValue('vj_chat_chat_widget_avatar_scale', 100) + '%',
            height: getFieldValue('vj_chat_chat_widget_avatar_scale', 100) + '%'
        });

        // Keep style toggles in sync
        updateWooPreviewStyle();
        updateChatPreviewStyle();
    }

    $(document).on('change', '#vj_chat_button_style', updateWooPreviewStyle);
    $(document).on('change', '#vj_chat_chat_button_style', updateChatPreviewStyle);
    $(document).on('input change', '[name="vj_chat_chat_compact_size"], [name="vj_chat_chat_compact_icon_size"], [name="vj_chat_chat_icon_wrap_size"], [name="vj_chat_chat_icon_size"]', updateChatPreviewStyle);
    $(document).on('input change', 'form[action="options.php"] [name^="vj_chat_"]', refreshLivePreview);

    // Keep preview synced when media uploads update fields programmatically
    $('#vj_chat_icon_url, #vj_chat_chat_agent_avatar').on('change input', refreshLivePreview);

    updateWooPreviewStyle();
    updateChatPreviewStyle();
    refreshLivePreview();

});
