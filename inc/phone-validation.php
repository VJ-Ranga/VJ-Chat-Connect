<?php
if (!defined('ABSPATH')) {
    exit;
}

function vj_chat_normalize_national_phone($input)
{
    $input = trim((string) $input);
    $input = preg_replace('/[\s().-]+/', '', $input);
    return preg_match('/^\+?[0-9]+$/', $input) ? ltrim($input, '+') : '';
}

function vj_chat_validate_phone_for_country($input, $country_code)
{
    $country = vj_chat_get_country($country_code);
    $national = vj_chat_normalize_national_phone($input);

    if (!$country) {
        return array('valid' => false, 'phone' => '', 'error' => __('Select a valid country.', 'vj-chat-order'));
    }
    if ($national === '') {
        return array('valid' => false, 'phone' => '', 'error' => __('Enter a valid phone number.', 'vj-chat-order'));
    }
    $length = strlen($national);
    if ($length < $country['min_length'] || $length > $country['max_length'] || !preg_match('~^(?:' . $country['pattern'] . ')$~', $national)) {
        return array('valid' => false, 'phone' => '', 'error' => __('Enter a valid phone number for the selected country.', 'vj-chat-order'));
    }

    return array('valid' => true, 'phone' => $country['dial_code'] . $national, 'error' => '');
}
