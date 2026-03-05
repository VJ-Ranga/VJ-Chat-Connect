/**
 * VJ Chat Connect Script (Refactored to Vanilla JS)
 * 
 * Handles price calculation, variant detection, and WhatsApp message construction
 * Matches user's preferred logic structure.
 * 
 * @package VJ_Chat_Order
 */

document.addEventListener("DOMContentLoaded", function () {
    var buttons = document.querySelectorAll(".vj-chat-order-btn");
    if (!buttons.length) {
        var legacyButton = document.getElementById("vj-chat-order-btn");
        if (legacyButton) {
            buttons = [legacyButton];
        }
    }

    if (!buttons.length || typeof vjChatData === 'undefined') {
        return;
    }

    function parsePrice(rawText, decimalSeparator, thousandSeparator) {
        if (!rawText) {
            return 0;
        }

        var cleaned = rawText.replace(/[^0-9\.,]/g, '');

        if (thousandSeparator) {
            var ts = thousandSeparator.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            cleaned = cleaned.replace(new RegExp(ts, 'g'), '');
        }

        if (decimalSeparator && decimalSeparator !== '.') {
            var ds = decimalSeparator.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            cleaned = cleaned.replace(new RegExp(ds, 'g'), '.');
        }

        var parts = cleaned.split('.');
        if (parts.length > 2) {
            cleaned = parts.slice(0, -1).join('') + '.' + parts[parts.length - 1];
        }

        var number = parseFloat(cleaned);
        return isNaN(number) ? 0 : number;
    }

    function getPriceText() {
        var priceContainer = document.querySelector('.woocommerce-variation-price .price') || document.querySelector('.summary .price');
        if (!priceContainer) {
            return '';
        }

        var saleAmount = priceContainer.querySelector('ins .amount');
        if (saleAmount) {
            return saleAmount.textContent.trim();
        }

        var amountElements = priceContainer.querySelectorAll('.amount');
        if (amountElements.length) {
            return amountElements[amountElements.length - 1].textContent.trim();
        }

        return priceContainer.textContent.trim();
    }

    function getQuantity() {
        var qtyInput = document.querySelector('input.qty');
        var quantity = qtyInput ? parseInt(qtyInput.value) : 1;
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
        }
        return quantity;
    }

    function getVariantText(labels) {
        var variantText = "";
        var variationIdInput = document.querySelector('input.variation_id');

        if (variationIdInput && variationIdInput.value && variationIdInput.value !== "0") {
            var details = [];
            document.querySelectorAll(".variations select").forEach(function (select) {
                if (select.value) {
                    var attrName = select.name.replace('attribute_pa_', '')
                        .replace('attribute_', '')
                        .replace(/-/g, ' ');

                    attrName = attrName.charAt(0).toUpperCase() + attrName.slice(1);

                    var attrVal = select.options[select.selectedIndex].text;
                    details.push(attrName + ": " + attrVal);
                }
            });

            if (details.length > 0) {
                variantText = "\n📌 *" + (labels.variant || 'Variant') + ":* " + details.join(", ");
            }
        }

        return variantText;
    }

    function getVariantDetails() {
        var details = [];
        var variationIdInput = document.querySelector('input.variation_id');

        if (variationIdInput && variationIdInput.value && variationIdInput.value !== "0") {
            document.querySelectorAll(".variations select").forEach(function (select) {
                if (select.value) {
                    var attrName = select.name.replace('attribute_pa_', '')
                        .replace('attribute_', '')
                        .replace(/-/g, ' ');

                    attrName = attrName.charAt(0).toUpperCase() + attrName.slice(1);

                    var attrVal = select.options[select.selectedIndex].text;
                    details.push(attrName + ": " + attrVal);
                }
            });
        }

        return details;
    }

    function renderWidgetOrderSummary() {
        if (!chatWidget) {
            return;
        }

        var orderBox = chatWidget.querySelector('.vj-chat-widget-order');
        var bubbles = chatWidget.querySelector('.vj-chat-widget-bubbles');
        if (!orderBox || !bubbles) {
            return;
        }

        var mode = chatWidget.dataset.widgetMode || 'chat';
        if (mode !== 'order' || !vjChatData.productName) {
            orderBox.style.display = 'none';
            bubbles.style.display = 'flex';
            return;
        }

        bubbles.style.display = 'none';
        orderBox.style.display = 'block';
        orderBox.innerHTML = '';

        var labels = vjChatData.labels || {};
        var icons = vjChatData.icons || {};
        var quantity = getQuantity();
        var rawPriceText = getPriceText();
        var priceNumeric = parsePrice(rawPriceText, vjChatData.priceDecimalSeparator, vjChatData.priceThousandSeparator);
        var totalPrice = (priceNumeric * quantity).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        var currency = vjChatData.currencySymbol || '';
        var totalPrefix = currency ? currency + " " : '';
        var variantDetails = getVariantDetails();

        var intro = vjChatData.introMessage || "Hello, I'd like to place an order:";
        var introEl = document.createElement('div');
        introEl.className = 'vj-chat-widget-order-intro';
        introEl.textContent = intro;
        orderBox.appendChild(introEl);

        var lines = [
            { icon: icons.product || '🛒', label: labels.product || 'Product', value: vjChatData.productName || '' },
            { icon: icons.quantity || '🔢', label: labels.quantity || 'Quantity', value: quantity },
            { icon: icons.price || '💰', label: labels.price || 'Price', value: rawPriceText }
        ];

        if (variantDetails.length) {
            lines.push({ icon: '📌', label: labels.variant || 'Variant', value: variantDetails.join(', ') });
        }

        lines.push({ icon: icons.total || '💵', label: labels.total || 'Total', value: totalPrefix + totalPrice });
        lines.push({ icon: icons.link || '🔗', label: labels.link || 'Link', value: vjChatData.productUrl || '' });

        lines.forEach(function (line) {
            var row = document.createElement('div');
            row.className = 'vj-chat-widget-order-line';

            var iconEl = document.createElement('span');
            iconEl.className = 'vj-chat-widget-order-icon';
            iconEl.textContent = line.icon;

            var textEl = document.createElement('span');
            textEl.className = 'vj-chat-widget-order-text';
            textEl.innerHTML = '<strong>' + line.label + ':</strong> ' + line.value;

            row.appendChild(iconEl);
            row.appendChild(textEl);
            orderBox.appendChild(row);
        });
    }

    function buildOrderMessage(introOverride) {
        var labels = vjChatData.labels || {};
        var icons = vjChatData.icons || {};
        var introMessage = introOverride || vjChatData.introMessage || "Hello, I'd like to place an order:";
        var quantity = getQuantity();
        var rawPriceText = getPriceText();
        var priceNumeric = parsePrice(rawPriceText, vjChatData.priceDecimalSeparator, vjChatData.priceThousandSeparator);
        var totalPrice = (priceNumeric * quantity).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        var currency = vjChatData.currencySymbol || '';
        var totalPrefix = currency ? currency + " " : '';
        var variantText = getVariantText(labels);

        var message = introMessage + "\n\n";
        message += (icons.product || '🛒') + " *" + (labels.product || 'Product') + ":* " + (vjChatData.productName || 'Product') + "\n";
        message += (icons.quantity || '🔢') + " *" + (labels.quantity || 'Quantity') + ":* " + quantity + "\n";
        message += (icons.price || '💰') + " *" + (labels.price || 'Price') + ":* " + rawPriceText + variantText + "\n";
        message += (icons.total || '💵') + " *" + (labels.total || 'Total') + ":* " + totalPrefix + totalPrice + "\n\n";
        message += (icons.link || '🔗') + " *" + (labels.link || 'Link') + ":* " + (vjChatData.productUrl || '');

        return message;
    }

    var chatWidget = document.getElementById('vj-chat-widget');
    var chatButtons = document.querySelectorAll('.vj-chat-button.vj-chat-chat');
    function setChatWidgetOpen(isOpen) {
        if (!chatWidget) {
            return;
        }
        if (isOpen) {
            chatWidget.classList.add('is-open');
            chatWidget.setAttribute('aria-hidden', 'false');
            renderWidgetOrderSummary();
        } else {
            chatWidget.classList.remove('is-open');
            chatWidget.setAttribute('aria-hidden', 'true');
        }
        chatButtons.forEach(function (button) {
            button.classList.toggle('is-open', isOpen);
        });
    }
    var chatWidgetCloseElements = [];
    function toggleChatWidget() {
        if (!chatWidget) {
            return false;
        }
        var shouldOpen = !chatWidget.classList.contains('is-open');
        setChatWidgetOpen(shouldOpen);
        return shouldOpen;
    }

    if (chatWidget) {
        chatWidgetCloseElements = chatWidget.querySelectorAll('[data-chat-widget-close]');
        chatWidgetCloseElements.forEach(function (element) {
            element.addEventListener('click', function () {
                setChatWidgetOpen(false);
            });
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && chatWidget.classList.contains('is-open')) {
                setChatWidgetOpen(false);
            }
        });

        chatWidget.querySelectorAll('[data-chat-agent]').forEach(function (agent) {
            agent.addEventListener('click', function (event) {
                event.preventDefault();
                var mode = agent.dataset.mode || 'chat';
                var phone = agent.dataset.phone || vjChatData.phoneNumber || '';
                var message = agent.dataset.message || vjChatData.introMessage || '';

                if (mode === 'order' && vjChatData.productName) {
                    message = buildOrderMessage();
                }
                window.open("https://api.whatsapp.com/send?phone=" + phone + "&text=" + encodeURIComponent(message), "_blank");
                setChatWidgetOpen(false);
            });
        });

        renderWidgetOrderSummary();

    }

    function openChatWidget() {
        if (!chatWidget || typeof toggleChatWidget !== 'function') {
            return false;
        }
        toggleChatWidget();
        return true;
    }

    buttons.forEach(function (whatsappButton) {
        whatsappButton.addEventListener("click", function (event) {
            event.preventDefault();

            var mode = whatsappButton.dataset.mode || vjChatData.mode || 'order';
            var phone = whatsappButton.dataset.phone || vjChatData.phoneNumber || '';
            var introMessage = whatsappButton.dataset.intro || vjChatData.introMessage || "Hello, I'd like to place an order:";
            var isChatButton = whatsappButton.classList.contains('vj-chat-chat');

            if (mode === 'chat' || !vjChatData.productName) {
                if (!openChatWidget()) {
                    window.open("https://api.whatsapp.com/send?phone=" + phone + "&text=" + encodeURIComponent(introMessage), "_blank");
                }
                return;
            }

            if (mode === 'order' && isChatButton && openChatWidget()) {
                return;
            }
            var message = buildOrderMessage(introMessage);
            window.open("https://api.whatsapp.com/send?phone=" + phone + "&text=" + encodeURIComponent(message), "_blank");
        });
    });
});
