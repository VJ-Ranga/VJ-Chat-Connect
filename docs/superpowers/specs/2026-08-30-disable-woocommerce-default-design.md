# Disable WooCommerce By Default

## Goal

Prevent a fresh non-WooCommerce installation from showing the WooCommerce inactive warning after plugin activation.

## Behavior

- Change the activation default for `vj_chat_enable_woo` from `1` to `0`.
- Change the Settings API default for `vj_chat_enable_woo` from `1` to `0`.
- Do not overwrite the option on existing installations.
- Existing sites with `vj_chat_enable_woo = 1` continue to show the warning until the administrator disables the setting or activates WooCommerce.
- Chat functionality remains enabled and works without WooCommerce.

## Verification

- Confirm both default values are `0`.
- Confirm PHP syntax remains valid.
- Confirm the existing chat-only behavior is unchanged.
