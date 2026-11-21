jQuery(document).ready(function ($) {

    

    // ==========================================
    // Tab Switching Logic
    // ==========================================
    // Check for saved tab (Server-Side)
    var activeTab = vjChatAdminData.activeTab || 'chat';

    // Initialize: Set the saved tab as active
    function initializeTabs() {
        $('.vj-chat-tab-btn').removeClass('active nav-tab-active').attr({ 'aria-selected': 'false', tabindex: '-1' });
        $('.vj-chat-tab-panel').removeClass('active');

        $('.vj-chat-tab-btn[data-tab="' + activeTab + '"]').addClass('active nav-tab-active').attr({ 'aria-selected': 'true', tabindex: '0' });
        $('#tab-' + activeTab).addClass('active');
    }

    // Arrow keys move between tabs (WAI-ARIA tabs pattern).
    $('.vj-chat-tabs-nav').on('keydown', '.vj-chat-tab-btn', function (e) {
        var tabs = $('.vj-chat-tab-btn');
        var index = tabs.index(this);
        var next = null;
        if (e.key === 'ArrowRight') { next = tabs.eq((index + 1) % tabs.length); }
        if (e.key === 'ArrowLeft') { next = tabs.eq((index - 1 + tabs.length) % tabs.length); }
        if (e.key === 'Home') { next = tabs.first(); }
        if (e.key === 'End') { next = tabs.last(); }
        if (next) {
            e.preventDefault();
            next.trigger('focus').trigger('click');
        }
    });

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
    var countrySelect = $('#vj_chat_chat_country');
    var countrySearch = $('#vj_chat_chat_country_search');
    var phoneField = $('#vj_chat_chat_phone');
    var phoneFeedback = $('#vj_chat_chat_phone_feedback');

    // Mirrors vj_chat_validate_phone_for_country() in inc/phone-validation.php.
    function normalizePhone(raw, option) {
        var dial = String(option.data('dial-code') || '');
        var min = parseInt(option.data('min-length'), 10);
        var max = parseInt(option.data('max-length'), 10);
        var pattern = new RegExp('^(?:' + (option.data('pattern') || '\\d+') + ')$');
        raw = $.trim(raw || '');
        var digits = raw.replace(/[\s().\-\/]+/g, '');
        if (!/^\+?\d+$/.test(digits)) {
            return null;
        }
        var intl = digits.charAt(0) === '+';
        digits = digits.replace(/^\+/, '');
        if (!intl && digits.indexOf('00') === 0) {
            digits = digits.slice(2);
            intl = true;
        }
        var candidates = [];
        if (digits.indexOf(dial) === 0) {
            candidates.push(digits.slice(dial.length));
        }
        if (!intl) {
            candidates.push(digits);
        }
        for (var i = 0; i < candidates.length; i++) {
            var tries = [candidates[i], candidates[i].replace(/^0+/, '')];
            for (var j = 0; j < tries.length; j++) {
                var n = tries[j];
                if (n && n.length >= min && n.length <= max && (dial + n).length <= 15 && pattern.test(n)) {
                    return dial + n;
                }
            }
        }
        return null;
    }

    function updatePhoneValidation() {
        var option = countrySelect.find('option:selected');
        var value = phoneField.val() || '';
        $('#vj_chat_chat_country_code').text('+' + (option.data('dial-code') || ''));
        if (!$.trim(value)) {
            phoneFeedback.text('').removeClass('vj-chat-feedback-ok vj-chat-feedback-error');
            return;
        }
        var phone = normalizePhone(value, option);
        if (phone) {
            phoneFeedback.text((vjChatAdminData.i18n && vjChatAdminData.i18n.phoneValid ? vjChatAdminData.i18n.phoneValid : 'Valid. WhatsApp link will use:') + ' +' + phone)
                .removeClass('vj-chat-feedback-error').addClass('vj-chat-feedback-ok');
        } else {
            phoneFeedback.text(vjChatAdminData.i18n && vjChatAdminData.i18n.phoneInvalid ? vjChatAdminData.i18n.phoneInvalid : 'This number does not look valid for the selected country.')
                .removeClass('vj-chat-feedback-ok').addClass('vj-chat-feedback-error');
        }
    }

    // Filter the country list. Safari ignores hidden <option>s, so also
    // select the first match so typing "sri" or "94" picks the country.
    countrySearch.on('input', function () {
        var query = $.trim($(this).val() || '').toLowerCase().replace(/^\+/, '');
        var firstMatch = null;
        countrySelect.find('option').each(function () {
            var option = $(this);
            var text = option.text().toLowerCase();
            var matches = query === '' || text.indexOf(query) !== -1 || String(option.data('dial-code')) === query;
            option.prop('hidden', !matches);
            if (matches && !firstMatch) {
                firstMatch = option;
            }
        });
        if (query !== '' && firstMatch && !firstMatch.is(':selected')) {
            countrySelect.val(firstMatch.val()).trigger('change');
        }
    });
    // Enter in the search box must not submit the whole settings form.
    countrySearch.on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            phoneField.trigger('focus');
        }
    });
    countrySelect.on('change', updatePhoneValidation);
    phoneField.on('input', updatePhoneValidation);
    updatePhoneValidation();

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
    // Chat on/off: hide chat settings and chat preview when chat is disabled
    // ==========================================
    function toggleChatSettings() {
        var enabled = $('#vj_chat_enable_chat').is(':checked');
        $('#vj-chat-chat-settings').prop('hidden', !enabled);
        $('#vj-chat-chat-disabled-note').prop('hidden', enabled);
        $('.vj-chat-preview-chat-button, .vj-chat-preview-chat-widget').toggleClass('vj-chat-preview-off', !enabled);
    }
    function toggleWooPreview() {
        var field = $('#vj_chat_enable_woo');
        var enabled = field.length ? field.is(':checked') && !field.is(':disabled') : false;
        $('.vj-chat-preview-woo-full, .vj-chat-preview-woo-compact').toggleClass('vj-chat-preview-off', !enabled);
    }

    function updatePreviewEmptyState() {
        var anyVisible = $('.vj-chat-preview-section').not('.vj-chat-preview-off').length > 0;
        $('#vj-chat-preview-empty').prop('hidden', anyVisible);
    }

    $('#vj_chat_enable_chat').on('change', function () { toggleChatSettings(); updatePreviewEmptyState(); });
    $('#vj_chat_enable_woo').on('change', function () { toggleWooPreview(); updatePreviewEmptyState(); });
    toggleChatSettings();
    toggleWooPreview();
    updatePreviewEmptyState();

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
