<?php
define('ABSPATH', __DIR__);
function __($text, $domain = null) { return $text; }
require_once __DIR__ . '/../inc/country-data.php';
require_once __DIR__ . '/../inc/phone-validation.php';

function expect($condition, $message)
{
    if (!$condition) {
        fwrite(STDERR, "FAIL: {$message}\n");
        exit(1);
    }
}

expect(vj_chat_get_country('LK')['dial_code'] === '94', 'Sri Lanka calling code');
expect(vj_chat_get_country('LK')['min_length'] === 9, 'Sri Lankan national number length');
expect(vj_chat_get_country('US')['dial_code'] === '1', 'United States calling code');
expect(vj_chat_get_country('ZZ') === null, 'unknown country is rejected');
expect(count(vj_chat_get_country_data()) >= 200, 'all-country metadata is present');

$lk = vj_chat_validate_phone_for_country('77123-4567', 'LK');
expect($lk['valid'] === true && $lk['phone'] === '94771234567', 'Sri Lankan number normalization');

$bad_lk = vj_chat_validate_phone_for_country('77123456', 'LK');
expect($bad_lk['valid'] === false, 'short Sri Lankan number is rejected');

$us = vj_chat_validate_phone_for_country('(202) 555-0123', 'US');
expect($us['valid'] === true && $us['phone'] === '12025550123', 'US number normalization');

$unknown = vj_chat_validate_phone_for_country('771234567', 'ZZ');
expect($unknown['valid'] === false, 'unknown country validation fails');

echo "PASS\n";
