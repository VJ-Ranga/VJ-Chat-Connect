# VJ Chat Connect Project Details

## Project

- Plugin: VJ Chat Connect
- Repository: https://github.com/VJ-Ranga/VJ-Chat-Connect
- Local plugin path: `/home/vjranga/local/test/wp-content/plugins/VJ-Chat-Connect`
- Working branch: `feature/country-aware-whatsapp`
- WordPress use case: WhatsApp chat without WooCommerce, with optional WooCommerce order features

## What We Checked

The plugin was audited using direct CLI and local file inspection.

### Security checks

- Admin settings require `manage_options`.
- Settings use the WordPress Settings API and nonce protection.
- The AJAX tab endpoint uses a nonce and capability check.
- No `eval()`, unsafe unserialization, arbitrary file-write, or unauthenticated write endpoint was found.
- Frontend values are generally escaped correctly.
- PHP syntax checks passed for the original plugin files.

### Code-quality checks

- Main plugin file: `vj-chat-order.php`, over 1,000 lines.
- Admin settings file: `inc/admin-settings.php`, nearly 2,000 lines.
- Several settings registrations and field callbacks are repetitive.
- Some settings have duplicated or confusing names.
- The original agent role setting was saved but not displayed in the frontend widget.
- Inline JavaScript exists inside the admin settings PHP file.
- The original repository had no automated tests or coding-standard configuration.

## Completed Work In This Branch

### Country-aware WhatsApp number input

The approved feature design is recorded at:

`docs/superpowers/specs/2026-08-30-country-aware-whatsapp-validation-design.md`

The implementation plan is recorded at:

`docs/superpowers/plans/2026-08-30-country-aware-whatsapp-validation.md`

Implemented files:

- `inc/country-data.php`
  - Local metadata for 242 countries.
  - Country names, flags, calling codes, and validation patterns.
- `inc/phone-validation.php`
  - Server-side national number normalization.
  - Country-specific validation.
  - Normalized international number output without `+` or formatting.
- `tests/test-phone-validation.php`
  - Framework-free regression tests.
- `inc/admin-settings.php`
  - Country selector and national-number input.
  - Sri Lanka default: `LK`, `+94`.
  - Clear note explaining that the country code must not be entered in the number field.
  - Server-side chat phone validation.
- `assets/js/admin-script.js`
  - Country search/filter.
  - Calling-code display.
  - Immediate client-side format feedback.
- `vj-chat-order.php`
  - Loads the new validation helpers.
  - Adds the `vj_chat_chat_country` default option.
- `uninstall.php`
  - Removes the new country option on uninstall.
- `README.md` and `readme.txt`
  - Explain chat-only operation and country-aware number entry.

### Chat phone fallback fix

The original sanitizer incorrectly used the general WooCommerce phone as the fallback for invalid chat phone input.

The new chat sanitizer falls back to:

`vj_chat_chat_phone`

instead of:

`vj_chat_phone_number`

This is important for installations that use the plugin without WooCommerce.

## Required Admin Note

The settings page now displays:

> Select your country and enter your WhatsApp number without the country code. Example for Sri Lanka: select Sri Lanka (+94), then enter 771234567.

The plugin validates number format only. It does not verify whether the number is registered on WhatsApp.

## Verification Completed

From the feature worktree, these checks passed:

```text
php tests/test-phone-validation.php                  PASS
php -l vj-chat-order.php                              No syntax errors
php -l inc/admin-settings.php                         No syntax errors
php -l inc/country-data.php                           No syntax errors
php -l inc/phone-validation.php                       No syntax errors
php -l uninstall.php                                  No syntax errors
node --check assets/js/admin-script.js                PASS
node --check assets/js/vj-chat-script.js              PASS
git diff --check                                     PASS
```

## Remaining Review Items

These should be handled one at a time with separate verification:

1. Whitelist every select setting instead of relying on `sanitize_text_field()`.
2. Add `noopener,noreferrer` to WhatsApp links opened in new windows.
3. Restrict custom icon and avatar URLs to approved protocols, at minimum `http` and `https`.
4. Keep WooCommerce optional, but improve the admin warning and documentation. Do not add a mandatory `Requires Plugins: woocommerce` header because chat-only use must continue working.
5. Display the configured agent role in the frontend widget.
6. Expand automated tests for the new settings sanitizers and existing-number compatibility.
7. Add a coding-standard configuration if the project wants automated PHP style checks.
8. Refactor repeated settings registration and field callbacks.
9. Move the remaining inline admin JavaScript into `assets/js/admin-script.js`.

## Refactoring Guidance

The two large PHP files should not be rewritten all at once. Refactor only after the security and behavior fixes pass. Recommended boundaries:

- Country data and phone validation: `inc/country-data.php`, `inc/phone-validation.php`.
- Settings registration/sanitizers: a focused settings module.
- Admin field rendering: a focused fields module.
- Frontend rendering and WooCommerce hooks: keep in the main plugin file until behavior tests exist.

Avoid changing stored option names unless a migration is included. Existing saved phone numbers must continue to work.

## Git Status And Integration

The country-aware implementation is committed on:

`feature/country-aware-whatsapp`

It has not yet been merged into `main` or copied over the original plugin checkout. The current feature worktree is:

`/home/vjranga/local/test/wp-content/plugins/VJ-Chat-Connect/.worktrees/country-aware-whatsapp`

The original checkout remains at:

`/home/vjranga/local/test/wp-content/plugins/VJ-Chat-Connect`

Merge the feature branch only after the remaining review items are completed and verified.
