<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Strip formatting characters. Returns digits only, or '' if anything other
 * than digits, spaces, dots, dashes, brackets and one leading "+" was entered.
 */
function vj_chat_normalize_national_phone($input)
{
    if (!is_scalar($input)) {
        return '';
    }
    $input = trim((string) $input);
    $input = preg_replace('/[\s().\-\/]+/', '', $input);
    return preg_match('/^\+?[0-9]+$/', $input) ? ltrim($input, '+') : '';
}

/**
 * Check a national number (no country code, no trunk 0) against country rules.
 */
function vj_chat_is_valid_national_phone($national, $country)
{
    $length = strlen($national);
    return $length >= $country['min_length']
        && $length <= $country['max_length']
        && preg_match('~^(?:' . $country['pattern'] . ')$~', $national);
}

/**
 * Validate a phone number for a country and return it in international
 * format (dial code + national number, digits only) as used by wa.me.
 *
 * Accepts every format people normally type, e.g. for Sri Lanka:
 * 771234567, 0771234567, 077 123 4567, 94771234567, +94 77 123 4567, 0094771234567.
 */
function vj_chat_validate_phone_for_country($input, $country_code)
{
    $country = vj_chat_get_country($country_code);
    if (!$country) {
        return array('valid' => false, 'phone' => '', 'error' => __('Select a valid country.', 'vj-chat-order'));
    }

    $raw = is_scalar($input) ? trim((string) $input) : '';
    $digits = vj_chat_normalize_national_phone($raw);
    if ($digits === '') {
        return array('valid' => false, 'phone' => '', 'error' => __('Enter a valid phone number (digits only).', 'vj-chat-order'));
    }

    $dial = $country['dial_code'];
    $has_intl_prefix = strpos($raw, '+') === 0;
    if (!$has_intl_prefix && strpos($digits, '00') === 0) {
        $digits = substr($digits, 2);
        $has_intl_prefix = true;
    }

    // Build candidate national numbers, most specific first.
    $candidates = array();
    if (strpos($digits, $dial) === 0) {
        $candidates[] = substr($digits, strlen($dial));
    }
    if (!$has_intl_prefix) {
        $candidates[] = $digits;
    }

    foreach ($candidates as $candidate) {
        // Also try without a trunk "0", e.g. "+94 (0)77 ..." or "077 ...".
        foreach (array($candidate, ltrim($candidate, '0')) as $national) {
            if ($national !== '' && strlen($dial . $national) <= 15 && vj_chat_is_valid_national_phone($national, $country)) {
                return array('valid' => true, 'phone' => $dial . $national, 'error' => '');
            }
        }
    }

    if ($country['min_length'] === $country['max_length']) {
        /* translators: 1: country name, 2: number of digits. */
        $error = sprintf(__('Enter a valid %1$s number: %2$d digits after the country code.', 'vj-chat-order'), $country['name'], $country['min_length']);
    } else {
        /* translators: 1: country name, 2: minimum digits, 3: maximum digits. */
        $error = sprintf(__('Enter a valid %1$s number: %2$d to %3$d digits after the country code.', 'vj-chat-order'), $country['name'], $country['min_length'], $country['max_length']);
    }

    return array('valid' => false, 'phone' => '', 'error' => $error);
}
