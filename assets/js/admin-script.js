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
        });

        // Open the uploader dialog
        mediaUploader.open();
    });

    // Reset to Default Icon
    $('.vj-chat-reset-icon-btn').on('click', function (e) {
        e.preventDefault();
        $('#vj_chat_icon_url').val('');
        $('.vj-chat-icon-preview img').attr('src', defaultIcon);
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
        });

        avatarUploader.open();
    });

    $('.vj-chat-reset-avatar-btn').on('click', function (e) {
        e.preventDefault();
        $('#vj_chat_chat_agent_avatar').val('');
        $('.vj-chat-agent-avatar-preview-img').attr('src', defaultIcon);
    });

    $('#vj_chat_chat_agent_avatar').on('change input', function () {
        var url = $(this).val();
        if (url.length > 0) {
            $('.vj-chat-agent-avatar-preview-img').attr('src', url);
        } else {
            $('.vj-chat-agent-avatar-preview-img').attr('src', defaultIcon);
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

    $(document).on('change', '#vj_chat_button_style', updateWooPreviewStyle);
    $(document).on('change', '#vj_chat_chat_button_style', updateChatPreviewStyle);
    $(document).on('input change', '[name="vj_chat_chat_compact_size"], [name="vj_chat_chat_compact_icon_size"], [name="vj_chat_chat_icon_wrap_size"], [name="vj_chat_chat_icon_size"]', updateChatPreviewStyle);

    updateWooPreviewStyle();
    updateChatPreviewStyle();

});
