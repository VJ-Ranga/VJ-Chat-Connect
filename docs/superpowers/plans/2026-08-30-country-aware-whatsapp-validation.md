# Country-Aware WhatsApp Validation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add an all-country selector and country-aware national-number validation to the chat WhatsApp setting without requiring WooCommerce or an external API.

**Architecture:** Add a local country metadata provider and a server-side phone normalizer/validator under `inc/`. The admin settings page will render a country selector plus national-number input, while the existing `vj_chat_chat_phone` option will continue to hold the normalized international number and a new option will hold the selected ISO country code. Client-side JavaScript provides immediate feedback only; the Settings API remains authoritative.

**Tech Stack:** WordPress Settings API, PHP 7.4+, vanilla JavaScript, local PHP country metadata.

## Global Constraints

- The feature must work without WooCommerce.
- Provide a searchable dropdown containing all countries, country names, flags, and calling codes.
- Default the country to Sri Lanka (+94).
- The administrator enters only the national number.
- Store the normalized international number without a leading plus or formatting characters.
- Keep country metadata local to the plugin; do not add an external runtime dependency or API requirement.
- Validate and normalize on the server; client-side validation is only for immediate feedback.
- Do not trust the country code or number supplied by JavaScript.
- Existing stored international numbers must remain usable.

---

## File Map

- Create `inc/country-data.php`: local country metadata and lookup helpers only.
- Create `inc/phone-validation.php`: normalization and validation helpers only.
- Modify `vj-chat-order.php:234-245,274-351,805-810,936-940`: load helpers, add the selected country default, and keep frontend chat data sourced from the normalized option.
- Modify `inc/admin-settings.php:102-105,643-648`: register the country option and replace the single chat phone field with country plus national-number controls and the required explanatory note.
- Modify `assets/js/admin-script.js`: add country selector search/filter, number normalization preview, and immediate validation feedback without submitting settings.
- Create `tests/test-phone-validation.php`: framework-free regression tests for the pure PHP validation helpers.
- Modify `README.md`: document non-WooCommerce chat setup and country/number entry format.

### Task 1: Add Local Country Metadata

**Files:**
- Create: `inc/country-data.php`
- Test: `tests/test-phone-validation.php`

**Interfaces:**
- Produces `vj_chat_get_country_data(): array`, keyed by uppercase ISO 3166-1 alpha-2 code, with `name`, `dial_code`, `flag`, `min_length`, `max_length`, and optional `pattern` values.
- Produces `vj_chat_get_country($country_code): ?array`, returning `null` for unknown codes.

- [ ] **Step 1: Write the failing metadata assertions**

```php
require_once __DIR__ . '/../inc/country-data.php';

assert(vj_chat_get_country('LK')['dial_code'] === '94');
assert(vj_chat_get_country('LK')['min_length'] === 9);
assert(vj_chat_get_country('US')['dial_code'] === '1');
assert(vj_chat_get_country('ZZ') === null);
assert(count(vj_chat_get_country_data()) >= 200);
```

- [ ] **Step 2: Run the test to verify it fails**

Run: `php tests/test-phone-validation.php`

Expected: FAIL because `inc/country-data.php` and the lookup functions do not exist.

- [ ] **Step 3: Add the local metadata and lookups**

Implement one static country array covering all supported countries, including Sri Lanka (`LK`, `+94`, nine national digits) and country-specific length ranges/patterns. Keep the functions pure, return copies of metadata, and reject unknown country codes rather than guessing.

- [ ] **Step 4: Run the metadata test**

Run: `php tests/test-phone-validation.php`

Expected: PASS for the metadata assertions.

- [ ] **Step 5: Commit the metadata unit**

```bash
git add inc/country-data.php tests/test-phone-validation.php
git commit -m "feat: add local WhatsApp country metadata"
```

### Task 2: Add Server-Side Normalization and Validation

**Files:**
- Create: `inc/phone-validation.php`
- Modify: `tests/test-phone-validation.php`

**Interfaces:**
- Produces `vj_chat_normalize_national_phone(string $input): string`, removing spaces, parentheses, hyphens, and a leading plus while rejecting non-digit content.
- Produces `vj_chat_validate_phone_for_country(string $input, string $country_code): array`, returning `['valid' => bool, 'phone' => string, 'error' => string]`.

- [ ] **Step 1: Add failing normalization and validation cases**

```php
require_once __DIR__ . '/../inc/phone-validation.php';

$lk = vj_chat_validate_phone_for_country('77123-4567', 'LK');
assert($lk['valid'] === true);
assert($lk['phone'] === '94771234567');

$bad_lk = vj_chat_validate_phone_for_country('77123456', 'LK');
assert($bad_lk['valid'] === false);

$us = vj_chat_validate_phone_for_country('(202) 555-0123', 'US');
assert($us['valid'] === true);
assert($us['phone'] === '12025550123');

$unknown = vj_chat_validate_phone_for_country('771234567', 'ZZ');
assert($unknown['valid'] === false);
```

- [ ] **Step 2: Run the validation tests to verify they fail**

Run: `php tests/test-phone-validation.php`

Expected: FAIL because the validation helper does not exist.

- [ ] **Step 3: Implement normalization and validation**

Use the selected country metadata on the server. Strip only documented formatting characters, reject letters and other symbols, enforce the metadata length/pattern, and prepend the country dial code. Return a translatable error string without exposing raw settings or server details.

- [ ] **Step 4: Run all pure PHP validation tests**

Run: `php tests/test-phone-validation.php`

Expected: PASS for Sri Lanka, the United States, variable-length country cases, formatted input, invalid country codes, empty input, and impossible lengths.

- [ ] **Step 5: Commit the validation unit**

```bash
git add inc/phone-validation.php tests/test-phone-validation.php
git commit -m "feat: validate WhatsApp numbers by country"
```

### Task 3: Integrate the Settings API

**Files:**
- Modify: `vj-chat-order.php:274-351`
- Modify: `vj-chat-order.php:234-245`
- Modify: `inc/admin-settings.php:102-105,643-648`

**Interfaces:**
- Consumes `vj_chat_validate_phone_for_country()` and `vj_chat_get_country_data()`.
- Produces the `vj_chat_chat_country` option, defaulting to `LK`, and keeps `vj_chat_chat_phone` normalized.

- [ ] **Step 1: Add a failing settings integration check**

Add a test fixture assertion that the chat country default is `LK` and that a valid national number is saved as a normalized international number. The test must also assert that an invalid country/number combination returns the previous saved value and adds a Settings API error.

- [ ] **Step 2: Run the integration check to verify it fails**

Run: `php tests/test-phone-validation.php`

Expected: FAIL because the new option and Settings API sanitizer are not registered.

- [ ] **Step 3: Register and sanitize the country setting**

Register `vj_chat_chat_country` with a sanitizer that accepts only an ISO code present in local metadata. Update the chat phone sanitizer to read the selected country, validate the submitted national number, and return the existing normalized phone on failure. Do not use the WooCommerce/general phone as the fallback for chat validation.

- [ ] **Step 4: Update activation defaults and the admin field**

Add `vj_chat_chat_country => 'LK'`. Render a searchable country `<select>` and a national-number `<input>` while showing the normalized value only through the form’s country/number presentation. Add exactly this note below the fields:

```text
Select your country and enter your WhatsApp number without the country code. Example for Sri Lanka: select Sri Lanka (+94), then enter 771234567.
```

Preserve Settings API nonce and capability behavior.

- [ ] **Step 5: Run PHP checks**

Run: `php -l vj-chat-order.php && php -l inc/admin-settings.php && php -l inc/country-data.php && php -l inc/phone-validation.php`

Expected: No syntax errors detected for every file.

- [ ] **Step 6: Commit settings integration**

```bash
git add vj-chat-order.php inc/admin-settings.php
git commit -m "feat: add country-aware chat phone settings"
```

### Task 4: Add Admin-Side Immediate Feedback

**Files:**
- Modify: `assets/js/admin-script.js`
- Modify: `inc/admin-settings.php`

**Interfaces:**
- Consumes the country metadata localized into `vjChatAdminData.countries`.
- Produces immediate length/format feedback only; server-side Settings API validation remains authoritative.

- [ ] **Step 1: Add the country metadata to the localized admin script**

Pass only the display-safe country fields needed by the selector: ISO code, name, dial code, flag, minimum length, and maximum length.

- [ ] **Step 2: Implement selector filtering and feedback**

Filter the country list by country name, ISO code, or calling code. Update the visible country code when selection changes, strip permitted formatting for length checks, and show an accessible error/status element. Never construct the saved phone value solely in JavaScript.

- [ ] **Step 3: Test the admin behavior manually**

Verify Sri Lanka defaults to `+94`, `771234567` is accepted, `77123456` is rejected, formatted input is handled, and changing country updates the displayed calling code without a page reload.

- [ ] **Step 4: Commit admin feedback**

```bash
git add assets/js/admin-script.js inc/admin-settings.php
git commit -m "feat: add WhatsApp country selector feedback"
```

### Task 5: Verify Chat-Only Runtime and Documentation

**Files:**
- Modify: `README.md`
- Modify: `readme.txt`

- [ ] **Step 1: Verify the chat-only path**

Use the local WordPress CLI from `/home/vjranga/local/test` to confirm the plugin remains active with WooCommerce absent or inactive, then inspect the rendered settings and chat configuration. Confirm the frontend uses the normalized chat phone option and does not require WooCommerce classes.

- [ ] **Step 2: Verify existing saved numbers**

Test an existing normalized `vj_chat_chat_phone` value with no `vj_chat_chat_country` option. Confirm the settings page presents Sri Lanka as the fallback country and the existing value remains usable until the administrator saves a new country/number pair.

- [ ] **Step 3: Document setup**

Document that the plugin supports chat-only sites, that the administrator selects a country and enters a national number, and that validation confirms format only, not WhatsApp registration.

- [ ] **Step 4: Run final checks**

Run:

```bash
php tests/test-phone-validation.php
php -l vj-chat-order.php
php -l inc/admin-settings.php
php -l inc/country-data.php
php -l inc/phone-validation.php
git status --short
```

Expected: all tests pass, all PHP files report no syntax errors, and only intended files are modified.

- [ ] **Step 5: Commit documentation and final verification**

```bash
git add README.md readme.txt
git commit -m "docs: document country-aware WhatsApp setup"
```
