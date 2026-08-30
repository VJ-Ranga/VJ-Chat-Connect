# Country-Aware WhatsApp Validation Design

## Goal

Allow administrators to configure WhatsApp numbers using a country selector and a national number, while validating the number format for the selected country. The feature must work without WooCommerce.

## User Experience

- Provide a searchable dropdown containing all countries, country names, flags, and calling codes.
- Default the country to Sri Lanka (+94).
- Let the administrator enter only the national number. Example: select Sri Lanka (+94), then enter `771234567`.
- Display this note below the fields:

  > Select your country and enter your WhatsApp number without the country code. Example for Sri Lanka: select Sri Lanka (+94), then enter `771234567`.

- Show a clear validation error when the national number does not match the selected country's supported format.
- Preserve the existing chat widget and WhatsApp link behavior.

## Data Handling

- Store the normalized international number without a leading plus or formatting characters, such as `94771234567`.
- Store the selected country separately so the settings page can reconstruct the form value.
- Normalize spaces, parentheses, hyphens, and an optional leading plus before validation where appropriate.
- Do not call an external verification service. Validation confirms format only, not WhatsApp registration.

## Country Data

- Keep country metadata local to the plugin; do not add an external runtime dependency or API requirement.
- Include calling code and a country-specific national-number validation rule.
- Support countries with variable valid lengths by expressing length as a range or pattern.
- Reject impossible values while avoiding overly restrictive rules for countries whose numbering plans vary.

## Compatibility

- The chat-only flow must function when WooCommerce is inactive.
- WooCommerce order functionality remains unchanged.
- Existing stored international numbers must remain usable during migration. If no country metadata is stored, infer Sri Lanka as the default presentation country without changing the existing number until the administrator saves the setting.

## Security and Validation

- Continue using the WordPress Settings API, capability checks, nonces, sanitization, and escaping.
- Validate and normalize on the server; client-side validation is only for immediate feedback.
- Do not trust the country code or number supplied by JavaScript.
- Keep the final WhatsApp destination restricted to the existing WhatsApp endpoint.

## Testing Requirements

- Validate valid and invalid Sri Lankan numbers.
- Validate at least three countries with different number lengths.
- Test formatted input, leading plus signs, spaces, and hyphens.
- Test invalid country/number combinations and empty values.
- Confirm chat-only operation with WooCommerce inactive.
- Confirm existing settings remain usable after the change.
- Run PHP syntax checks and JavaScript lint/static checks available in the repository.
