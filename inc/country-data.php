<?php
if (!defined('ABSPATH')) { exit; }

function vj_chat_get_country_data() {
    static $data = null;
    if ($data !== null) { return $data; }
    $data = array (
  'AD' => 
  array (
    'name' => 'Andorra',
    'dial_code' => '376',
    'flag' => '🇦🇩',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:1|6\\d)\\d{7}|[135-9]\\d{5}',
  ),
  'AE' => 
  array (
    'name' => 'United Arab Emirates',
    'dial_code' => '971',
    'flag' => '🇦🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[4-7]\\d|9[0-689])\\d{7}|800\\d{2,9}|[2-4679]\\d{7}',
  ),
  'AF' => 
  array (
    'name' => 'Afghanistan',
    'dial_code' => '93',
    'flag' => '🇦🇫',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-7]\\d{8}',
  ),
  'AG' => 
  array (
    'name' => 'Antigua and Barbuda',
    'dial_code' => '1',
    'flag' => '🇦🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:268|[58]\\d\\d|900)\\d{7}',
  ),
  'AI' => 
  array (
    'name' => 'Anguilla',
    'dial_code' => '1',
    'flag' => '🇦🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:264|[58]\\d\\d|900)\\d{7}',
  ),
  'AL' => 
  array (
    'name' => 'Albania',
    'dial_code' => '355',
    'flag' => '🇦🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:700\\d\\d|900)\\d{3}|8\\d{5,7}|(?:[2-5]|6\\d)\\d{7}',
  ),
  'AM' => 
  array (
    'name' => 'Armenia',
    'dial_code' => '374',
    'flag' => '🇦🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[1-489]\\d|55|60|77)\\d{6}',
  ),
  'AO' => 
  array (
    'name' => 'Angola',
    'dial_code' => '244',
    'flag' => '🇦🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[29]\\d{8}',
  ),
  'AR' => 
  array (
    'name' => 'Argentina',
    'dial_code' => '54',
    'flag' => '🇦🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:11|[89]\\d\\d)\\d{8}|[2368]\\d{9}',
  ),
  'AS' => 
  array (
    'name' => 'American Samoa',
    'dial_code' => '1',
    'flag' => '🇦🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|684|900)\\d{7}',
  ),
  'AT' => 
  array (
    'name' => 'Austria',
    'dial_code' => '43',
    'flag' => '🇦🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1\\d{3,12}|2\\d{6,12}|43(?:(?:0\\d|5[02-9])\\d{3,9}|2\\d{4,5}|[3467]\\d{4}|8\\d{4,6}|9\\d{4,7})|5\\d{4,12}|8\\d{7,12}|9\\d{8,12}|(?:[367]\\d|4[0-24-9])\\d{4,11}',
  ),
  'AU' => 
  array (
    'name' => 'Australia',
    'dial_code' => '61',
    'flag' => '🇦🇺',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1(?:[0-79]\\d{7}(?:\\d(?:\\d{2})?)?|8[0-24-9]\\d{7})|[2-478]\\d{8}|1\\d{4,7}',
  ),
  'AW' => 
  array (
    'name' => 'Aruba',
    'dial_code' => '297',
    'flag' => '🇦🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[25-79]\\d\\d|800)\\d{4}',
  ),
  'AX' => 
  array (
    'name' => 'Åland Islands',
    'dial_code' => '358',
    'flag' => '🇦🇽',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '2\\d{4,9}|35\\d{4,5}|(?:60\\d\\d|800)\\d{4,6}|7\\d{5,11}|(?:[14]\\d|3[0-46-9]|50)\\d{4,8}',
  ),
  'AZ' => 
  array (
    'name' => 'Azerbaijan',
    'dial_code' => '994',
    'flag' => '🇦🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '365\\d{6}|(?:[124579]\\d|60|88)\\d{7}',
  ),
  'BA' => 
  array (
    'name' => 'Bosnia and Herzegovina',
    'dial_code' => '387',
    'flag' => '🇧🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '6\\d{8}|(?:[35689]\\d|49|70)\\d{6}',
  ),
  'BB' => 
  array (
    'name' => 'Barbados',
    'dial_code' => '1',
    'flag' => '🇧🇧',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:246|[58]\\d\\d|900)\\d{7}',
  ),
  'BD' => 
  array (
    'name' => 'Bangladesh',
    'dial_code' => '880',
    'flag' => '🇧🇩',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-469]\\d{9}|8[0-79]\\d{7,8}|[2-79]\\d{8}|[2-9]\\d{7}|[3-9]\\d{6}|[57-9]\\d{5}',
  ),
  'BE' => 
  array (
    'name' => 'Belgium',
    'dial_code' => '32',
    'flag' => '🇧🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '4\\d{8}|[1-9]\\d{7}',
  ),
  'BF' => 
  array (
    'name' => 'Burkina Faso',
    'dial_code' => '226',
    'flag' => '🇧🇫',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[024-7]\\d{7}',
  ),
  'BG' => 
  array (
    'name' => 'Bulgaria',
    'dial_code' => '359',
    'flag' => '🇧🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '00800\\d{7}|[2-7]\\d{6,7}|[89]\\d{6,8}|2\\d{5}',
  ),
  'BH' => 
  array (
    'name' => 'Bahrain',
    'dial_code' => '973',
    'flag' => '🇧🇭',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[136-9]\\d{7}',
  ),
  'BI' => 
  array (
    'name' => 'Burundi',
    'dial_code' => '257',
    'flag' => '🇧🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[267]\\d|31)\\d{6}',
  ),
  'BJ' => 
  array (
    'name' => 'Benin',
    'dial_code' => '229',
    'flag' => '🇧🇯',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:01\\d|8)\\d{7}',
  ),
  'BL' => 
  array (
    'name' => 'Saint Barthélemy',
    'dial_code' => '590',
    'flag' => '🇧🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '7090\\d{5}|(?:[56]9|[89]\\d)\\d{7}',
  ),
  'BM' => 
  array (
    'name' => 'Bermuda',
    'dial_code' => '1',
    'flag' => '🇧🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:441|[58]\\d\\d|900)\\d{7}',
  ),
  'BN' => 
  array (
    'name' => 'Brunei Darussalam',
    'dial_code' => '673',
    'flag' => '🇧🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-578]\\d{6}',
  ),
  'BO' => 
  array (
    'name' => 'Bolivia, Plurinational State of',
    'dial_code' => '591',
    'flag' => '🇧🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2-7]\\d\\d|8001)\\d{5}',
  ),
  'BQ' => 
  array (
    'name' => 'Bonaire, Sint Eustatius and Saba',
    'dial_code' => '599',
    'flag' => '🇧🇶',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[34]1|7\\d)\\d{5}',
  ),
  'BR' => 
  array (
    'name' => 'Brazil',
    'dial_code' => '55',
    'flag' => '🇧🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-467]\\d{9,10}|55[0-46-9]\\d{8}|[34]\\d{7}|55\\d{7,8}|(?:5[0-46-9]|[89]\\d)\\d{7,9}',
  ),
  'BS' => 
  array (
    'name' => 'Bahamas',
    'dial_code' => '1',
    'flag' => '🇧🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:242|[58]\\d\\d|900)\\d{7}',
  ),
  'BT' => 
  array (
    'name' => 'Bhutan',
    'dial_code' => '975',
    'flag' => '🇧🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[178]\\d{7}|[2-8]\\d{6}',
  ),
  'BW' => 
  array (
    'name' => 'Botswana',
    'dial_code' => '267',
    'flag' => '🇧🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:0800|(?:[37]|800)\\d)\\d{6}|(?:[2-6]\\d|90)\\d{5}',
  ),
  'BY' => 
  array (
    'name' => 'Belarus',
    'dial_code' => '375',
    'flag' => '🇧🇾',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[12]\\d|33|44|902)\\d{7}|8(?:0[0-79]\\d{5,7}|[1-7]\\d{9})|8(?:1[0-489]|[5-79]\\d)\\d{7}|8[1-79]\\d{6,7}|8[0-79]\\d{5}|8\\d{5}',
  ),
  'BZ' => 
  array (
    'name' => 'Belize',
    'dial_code' => '501',
    'flag' => '🇧🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:0800\\d|[2-8])\\d{6}',
  ),
  'CA' => 
  array (
    'name' => 'Canada',
    'dial_code' => '1',
    'flag' => '🇨🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-9]\\d{9}|3\\d{6}',
  ),
  'CC' => 
  array (
    'name' => 'Cocos (Keeling) Islands',
    'dial_code' => '61',
    'flag' => '🇨🇨',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1(?:[0-79]\\d{8}(?:\\d{2})?|8[0-24-9]\\d{7})|[148]\\d{8}|1\\d{5,7}',
  ),
  'CD' => 
  array (
    'name' => 'Congo, The Democratic Republic of the',
    'dial_code' => '243',
    'flag' => '🇨🇩',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:(?:[189]|5\\d)\\d|2)\\d{7}|[1-68]\\d{6}',
  ),
  'CF' => 
  array (
    'name' => 'Central African Republic',
    'dial_code' => '236',
    'flag' => '🇨🇫',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '8776\\d{4}|(?:[27]\\d|61)\\d{6}',
  ),
  'CG' => 
  array (
    'name' => 'Congo',
    'dial_code' => '242',
    'flag' => '🇨🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '222\\d{6}|(?:0\\d|80)\\d{7}',
  ),
  'CH' => 
  array (
    'name' => 'Switzerland',
    'dial_code' => '41',
    'flag' => '🇨🇭',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '8\\d{11}|[2-9]\\d{8}',
  ),
  'CI' => 
  array (
    'name' => 'Côte d\'Ivoire',
    'dial_code' => '225',
    'flag' => '🇨🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[02]\\d{9}',
  ),
  'CK' => 
  array (
    'name' => 'Cook Islands',
    'dial_code' => '682',
    'flag' => '🇨🇰',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-578]\\d{4}',
  ),
  'CL' => 
  array (
    'name' => 'Chile',
    'dial_code' => '56',
    'flag' => '🇨🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '12300\\d{6}|6\\d{9,10}|[2-9]\\d{8}',
  ),
  'CM' => 
  array (
    'name' => 'Cameroon',
    'dial_code' => '237',
    'flag' => '🇨🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[26]\\d{8}|88\\d{6,7}',
  ),
  'CN' => 
  array (
    'name' => 'China',
    'dial_code' => '86',
    'flag' => '🇨🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:(?:1[03-689]|2\\d)\\d\\d|6)\\d{8}|1\\d{10}|[126]\\d{6}(?:\\d(?:\\d{2})?)?|86\\d{5,6}|(?:[3-579]\\d|8[0-57-9])\\d{5,9}',
  ),
  'CO' => 
  array (
    'name' => 'Colombia',
    'dial_code' => '57',
    'flag' => '🇨🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:46|60\\d\\d)\\d{6}|(?:1\\d|[39])\\d{9}',
  ),
  'CR' => 
  array (
    'name' => 'Costa Rica',
    'dial_code' => '506',
    'flag' => '🇨🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:8\\d|90)\\d{8}|(?:[24-8]\\d{3}|3005)\\d{4}',
  ),
  'CU' => 
  array (
    'name' => 'Cuba',
    'dial_code' => '53',
    'flag' => '🇨🇺',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2-7]|8\\d\\d)\\d{7}|[2-47]\\d{6}|[34]\\d{5}',
  ),
  'CV' => 
  array (
    'name' => 'Cabo Verde',
    'dial_code' => '238',
    'flag' => '🇨🇻',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2-59]\\d\\d|800)\\d{4}',
  ),
  'CW' => 
  array (
    'name' => 'Curaçao',
    'dial_code' => '599',
    'flag' => '🇨🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[34]1|60|(?:7|9\\d)\\d)\\d{5}',
  ),
  'CX' => 
  array (
    'name' => 'Christmas Island',
    'dial_code' => '61',
    'flag' => '🇨🇽',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1(?:[0-79]\\d{8}(?:\\d{2})?|8[0-24-9]\\d{7})|[148]\\d{8}|1\\d{5,7}',
  ),
  'CY' => 
  array (
    'name' => 'Cyprus',
    'dial_code' => '357',
    'flag' => '🇨🇾',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[279]\\d|[58]0)\\d{6}',
  ),
  'CZ' => 
  array (
    'name' => 'Czechia',
    'dial_code' => '420',
    'flag' => '🇨🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2-578]\\d|60)\\d{7}|9\\d{8,11}',
  ),
  'DE' => 
  array (
    'name' => 'Germany',
    'dial_code' => '49',
    'flag' => '🇩🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2579]\\d{5,14}|49(?:[34]0|69|8\\d)\\d\\d?|49(?:37|49|60|7[089]|9\\d)\\d{1,3}|49(?:2[024-9]|3[2-689]|7[1-7])\\d{1,8}|(?:1|[368]\\d|4[0-8])\\d{3,13}|49(?:[015]\\d|2[13]|31|[46][1-8])\\d{1,9}',
  ),
  'DJ' => 
  array (
    'name' => 'Djibouti',
    'dial_code' => '253',
    'flag' => '🇩🇯',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:2\\d|77)\\d{6}',
  ),
  'DK' => 
  array (
    'name' => 'Denmark',
    'dial_code' => '45',
    'flag' => '🇩🇰',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-9]\\d{7}',
  ),
  'DM' => 
  array (
    'name' => 'Dominica',
    'dial_code' => '1',
    'flag' => '🇩🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|767|900)\\d{7}',
  ),
  'DO' => 
  array (
    'name' => 'Dominican Republic',
    'dial_code' => '1',
    'flag' => '🇩🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|900)\\d{7}',
  ),
  'DZ' => 
  array (
    'name' => 'Algeria',
    'dial_code' => '213',
    'flag' => '🇩🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[1-4]|[5-79]\\d|80)\\d{7}',
  ),
  'EC' => 
  array (
    'name' => 'Ecuador',
    'dial_code' => '593',
    'flag' => '🇪🇨',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1\\d{9,10}|(?:[2-7]|9\\d)\\d{7}',
  ),
  'EE' => 
  array (
    'name' => 'Estonia',
    'dial_code' => '372',
    'flag' => '🇪🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '8\\d{9}|[4578]\\d{7}|(?:[3-8]\\d|90)\\d{5}',
  ),
  'EG' => 
  array (
    'name' => 'Egypt',
    'dial_code' => '20',
    'flag' => '🇪🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[189]\\d{8,9}|[24-6]\\d{8}|[135]\\d{7}',
  ),
  'EH' => 
  array (
    'name' => 'Western Sahara',
    'dial_code' => '212',
    'flag' => '🇪🇭',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[5-8]\\d{8}',
  ),
  'ER' => 
  array (
    'name' => 'Eritrea',
    'dial_code' => '291',
    'flag' => '🇪🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[178]\\d{6}',
  ),
  'ES' => 
  array (
    'name' => 'Spain',
    'dial_code' => '34',
    'flag' => '🇪🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:400|[5-9]\\d\\d)\\d{6}',
  ),
  'ET' => 
  array (
    'name' => 'Ethiopia',
    'dial_code' => '251',
    'flag' => '🇪🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:11|[2-57-9]\\d)\\d{7}',
  ),
  'FI' => 
  array (
    'name' => 'Finland',
    'dial_code' => '358',
    'flag' => '🇫🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-35689]\\d{4}|7\\d{10,11}|(?:[124-7]\\d|3[0-46-9])\\d{8}|[1-9]\\d{5,8}',
  ),
  'FJ' => 
  array (
    'name' => 'Fiji',
    'dial_code' => '679',
    'flag' => '🇫🇯',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '45\\d{5}|(?:0800\\d|[235-9])\\d{6}',
  ),
  'FK' => 
  array (
    'name' => 'Falkland Islands (Malvinas)',
    'dial_code' => '500',
    'flag' => '🇫🇰',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-7]\\d{4}',
  ),
  'FM' => 
  array (
    'name' => 'Micronesia, Federated States of',
    'dial_code' => '691',
    'flag' => '🇫🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[39]\\d\\d|820)\\d{4}',
  ),
  'FO' => 
  array (
    'name' => 'Faroe Islands',
    'dial_code' => '298',
    'flag' => '🇫🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-9]\\d{5}',
  ),
  'FR' => 
  array (
    'name' => 'France',
    'dial_code' => '33',
    'flag' => '🇫🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-9]\\d{8}',
  ),
  'GA' => 
  array (
    'name' => 'Gabon',
    'dial_code' => '241',
    'flag' => '🇬🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[067]\\d|11)\\d{6}|[2-7]\\d{6}',
  ),
  'GB' => 
  array (
    'name' => 'United Kingdom',
    'dial_code' => '44',
    'flag' => '🇬🇧',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-357-9]\\d{9}|[18]\\d{8}|8\\d{6}',
  ),
  'GD' => 
  array (
    'name' => 'Grenada',
    'dial_code' => '1',
    'flag' => '🇬🇩',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:473|[58]\\d\\d|900)\\d{7}',
  ),
  'GE' => 
  array (
    'name' => 'Georgia',
    'dial_code' => '995',
    'flag' => '🇬🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[3-57]\\d\\d|800)\\d{6}',
  ),
  'GF' => 
  array (
    'name' => 'French Guiana',
    'dial_code' => '594',
    'flag' => '🇬🇫',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:694\\d|7093)\\d{5}|(?:59|[89]\\d)\\d{7}',
  ),
  'GG' => 
  array (
    'name' => 'Guernsey',
    'dial_code' => '44',
    'flag' => '🇬🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:1481|[357-9]\\d{3})\\d{6}|8\\d{6}(?:\\d{2})?',
  ),
  'GH' => 
  array (
    'name' => 'Ghana',
    'dial_code' => '233',
    'flag' => '🇬🇭',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[235]\\d{8}|800\\d{5,6}',
  ),
  'GI' => 
  array (
    'name' => 'Gibraltar',
    'dial_code' => '350',
    'flag' => '🇬🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[25]\\d|60)\\d{6}',
  ),
  'GL' => 
  array (
    'name' => 'Greenland',
    'dial_code' => '299',
    'flag' => '🇬🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:19|[2-689]\\d|70)\\d{4}',
  ),
  'GM' => 
  array (
    'name' => 'Gambia',
    'dial_code' => '220',
    'flag' => '🇬🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[48]\\d{8}|[2-9]\\d{6}',
  ),
  'GN' => 
  array (
    'name' => 'Guinea',
    'dial_code' => '224',
    'flag' => '🇬🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '722\\d{6}|(?:3|6\\d)\\d{7}',
  ),
  'GP' => 
  array (
    'name' => 'Guadeloupe',
    'dial_code' => '590',
    'flag' => '🇬🇵',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '7090\\d{5}|(?:[56]9|[89]\\d)\\d{7}',
  ),
  'GQ' => 
  array (
    'name' => 'Equatorial Guinea',
    'dial_code' => '240',
    'flag' => '🇬🇶',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '222\\d{6}|(?:3\\d|55|[89]0)\\d{7}',
  ),
  'GR' => 
  array (
    'name' => 'Greece',
    'dial_code' => '30',
    'flag' => '🇬🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '5005000\\d{3}|8\\d{9,11}|(?:[269]\\d|70)\\d{8}',
  ),
  'GT' => 
  array (
    'name' => 'Guatemala',
    'dial_code' => '502',
    'flag' => '🇬🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '80\\d{6}|(?:1\\d{3}|[2-7])\\d{7}',
  ),
  'GU' => 
  array (
    'name' => 'Guam',
    'dial_code' => '1',
    'flag' => '🇬🇺',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|671|900)\\d{7}',
  ),
  'GW' => 
  array (
    'name' => 'Guinea-Bissau',
    'dial_code' => '245',
    'flag' => '🇬🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[49]\\d{8}|4\\d{6}',
  ),
  'GY' => 
  array (
    'name' => 'Guyana',
    'dial_code' => '592',
    'flag' => '🇬🇾',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2-8]\\d{3}|9008)\\d{3}',
  ),
  'HK' => 
  array (
    'name' => 'Hong Kong',
    'dial_code' => '852',
    'flag' => '🇭🇰',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '8[0-46-9]\\d{6,7}|9\\d{4,7}|(?:[2-7]|9\\d{3})\\d{7}',
  ),
  'HN' => 
  array (
    'name' => 'Honduras',
    'dial_code' => '504',
    'flag' => '🇭🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '8\\d{10}|[237-9]\\d{7}',
  ),
  'HR' => 
  array (
    'name' => 'Croatia',
    'dial_code' => '385',
    'flag' => '🇭🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-69]\\d{8}|80\\d{5,7}|[1-79]\\d{7}|6\\d{6}',
  ),
  'HT' => 
  array (
    'name' => 'Haiti',
    'dial_code' => '509',
    'flag' => '🇭🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-589]\\d{7}',
  ),
  'HU' => 
  array (
    'name' => 'Hungary',
    'dial_code' => '36',
    'flag' => '🇭🇺',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[235-7]\\d{8}|[1-9]\\d{7}',
  ),
  'ID' => 
  array (
    'name' => 'Indonesia',
    'dial_code' => '62',
    'flag' => '🇮🇩',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '00[1-9]\\d{9,14}|(?:[1-36]|8\\d{5})\\d{6}|00\\d{9}|[1-9]\\d{8,10}|[2-9]\\d{7}',
  ),
  'IE' => 
  array (
    'name' => 'Ireland',
    'dial_code' => '353',
    'flag' => '🇮🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:1\\d|[2569])\\d{6,8}|4\\d{6,9}|7\\d{8}|8\\d{8,9}',
  ),
  'IL' => 
  array (
    'name' => 'Israel',
    'dial_code' => '972',
    'flag' => '🇮🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1\\d{6}(?:\\d{3,5})?|[57]\\d{8}|[1-489]\\d{7}',
  ),
  'IM' => 
  array (
    'name' => 'Isle of Man',
    'dial_code' => '44',
    'flag' => '🇮🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1624\\d{6}|(?:[3578]\\d|90)\\d{8}',
  ),
  'IN' => 
  array (
    'name' => 'India',
    'dial_code' => '91',
    'flag' => '🇮🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:000800|[2-9]\\d\\d)\\d{7}|1\\d{7,12}',
  ),
  'IO' => 
  array (
    'name' => 'British Indian Ocean Territory',
    'dial_code' => '246',
    'flag' => '🇮🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '3\\d{6}',
  ),
  'IQ' => 
  array (
    'name' => 'Iraq',
    'dial_code' => '964',
    'flag' => '🇮🇶',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:1|7\\d\\d)\\d{7}|[2-6]\\d{7,8}',
  ),
  'IR' => 
  array (
    'name' => 'Iran, Islamic Republic of',
    'dial_code' => '98',
    'flag' => '🇮🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-9]\\d{9}|(?:[1-8]\\d\\d|9)\\d{3,4}',
  ),
  'IS' => 
  array (
    'name' => 'Iceland',
    'dial_code' => '354',
    'flag' => '🇮🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:38\\d|[4-9])\\d{6}',
  ),
  'IT' => 
  array (
    'name' => 'Italy',
    'dial_code' => '39',
    'flag' => '🇮🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '0\\d{5,11}|1\\d{8,10}|3(?:[0-8]\\d{7,10}|9\\d{7,8})|(?:43|55|70)\\d{8}|8\\d{5}(?:\\d{2,4})?',
  ),
  'JE' => 
  array (
    'name' => 'Jersey',
    'dial_code' => '44',
    'flag' => '🇯🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1534\\d{6}|(?:[3578]\\d|90)\\d{8}',
  ),
  'JM' => 
  array (
    'name' => 'Jamaica',
    'dial_code' => '1',
    'flag' => '🇯🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|658|900)\\d{7}',
  ),
  'JO' => 
  array (
    'name' => 'Jordan',
    'dial_code' => '962',
    'flag' => '🇯🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:(?:[2689]|7\\d)\\d|32|427|53)\\d{6}',
  ),
  'JP' => 
  array (
    'name' => 'Japan',
    'dial_code' => '81',
    'flag' => '🇯🇵',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '00[1-9]\\d{6,14}|[25-9]\\d{9}|(?:00|[1-9]\\d\\d)\\d{6}',
  ),
  'KE' => 
  array (
    'name' => 'Kenya',
    'dial_code' => '254',
    'flag' => '🇰🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[17]\\d\\d|900)\\d{6}|(?:2|80)0\\d{6,7}|[4-6]\\d{6,8}',
  ),
  'KG' => 
  array (
    'name' => 'Kyrgyzstan',
    'dial_code' => '996',
    'flag' => '🇰🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '8\\d{9}|[235-9]\\d{8}',
  ),
  'KH' => 
  array (
    'name' => 'Cambodia',
    'dial_code' => '855',
    'flag' => '🇰🇭',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1\\d{9}|[1-9]\\d{7,8}',
  ),
  'KI' => 
  array (
    'name' => 'Kiribati',
    'dial_code' => '686',
    'flag' => '🇰🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[37]\\d|6[0-79])\\d{6}|(?:[2-48]\\d|50)\\d{3}',
  ),
  'KM' => 
  array (
    'name' => 'Comoros',
    'dial_code' => '269',
    'flag' => '🇰🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[3478]\\d{6}',
  ),
  'KN' => 
  array (
    'name' => 'Saint Kitts and Nevis',
    'dial_code' => '1',
    'flag' => '🇰🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|900)\\d{7}',
  ),
  'KP' => 
  array (
    'name' => 'Korea, Democratic People\'s Republic of',
    'dial_code' => '850',
    'flag' => '🇰🇵',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '85\\d{6}|(?:19\\d|[2-7])\\d{7}',
  ),
  'KR' => 
  array (
    'name' => 'Korea, Republic of',
    'dial_code' => '82',
    'flag' => '🇰🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '00[1-9]\\d{8,11}|(?:[12]|5\\d{3})\\d{7}|[13-6]\\d{9}|(?:[1-6]\\d|80)\\d{7}|[3-6]\\d{4,5}|(?:00|7)0\\d{8}',
  ),
  'KW' => 
  array (
    'name' => 'Kuwait',
    'dial_code' => '965',
    'flag' => '🇰🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '18\\d{5}|(?:[2569]\\d|41)\\d{6}',
  ),
  'KY' => 
  array (
    'name' => 'Cayman Islands',
    'dial_code' => '1',
    'flag' => '🇰🇾',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:345|[58]\\d\\d|900)\\d{7}',
  ),
  'KZ' => 
  array (
    'name' => 'Kazakhstan',
    'dial_code' => '7',
    'flag' => '🇰🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '8\\d{13}|[78]\\d{9}',
  ),
  'LA' => 
  array (
    'name' => 'Lao People\'s Democratic Republic',
    'dial_code' => '856',
    'flag' => '🇱🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[23]\\d{9}|3\\d{8}|(?:[235-8]\\d|41)\\d{6}',
  ),
  'LB' => 
  array (
    'name' => 'Lebanon',
    'dial_code' => '961',
    'flag' => '🇱🇧',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[27-9]\\d{7}|[13-9]\\d{6}',
  ),
  'LC' => 
  array (
    'name' => 'Saint Lucia',
    'dial_code' => '1',
    'flag' => '🇱🇨',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|758|900)\\d{7}',
  ),
  'LI' => 
  array (
    'name' => 'Liechtenstein',
    'dial_code' => '423',
    'flag' => '🇱🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[68]\\d{8}|(?:[2378]\\d|90)\\d{5}',
  ),
  'LK' => 
  array (
    'name' => 'Sri Lanka',
    'dial_code' => '94',
    'flag' => '🇱🇰',
    'min_length' => 9,
    'max_length' => 9,
    'pattern' => '[1-9]\\d{8}',
  ),
  'LR' => 
  array (
    'name' => 'Liberia',
    'dial_code' => '231',
    'flag' => '🇱🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2457]\\d|33|88)\\d{7}|(?:2\\d|[4-6])\\d{6}',
  ),
  'LS' => 
  array (
    'name' => 'Lesotho',
    'dial_code' => '266',
    'flag' => '🇱🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[256]\\d\\d|800)\\d{5}',
  ),
  'LT' => 
  array (
    'name' => 'Lithuania',
    'dial_code' => '370',
    'flag' => '🇱🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[3469]\\d|52|[78]0)\\d{6}',
  ),
  'LU' => 
  array (
    'name' => 'Luxembourg',
    'dial_code' => '352',
    'flag' => '🇱🇺',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '35[013-9]\\d{4,8}|6\\d{8}|35\\d{2,4}|(?:[2457-9]\\d|3[0-46-9])\\d{2,9}',
  ),
  'LV' => 
  array (
    'name' => 'Latvia',
    'dial_code' => '371',
    'flag' => '🇱🇻',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[268]\\d|78|90)\\d{6}',
  ),
  'LY' => 
  array (
    'name' => 'Libya',
    'dial_code' => '218',
    'flag' => '🇱🇾',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-9]\\d{8}',
  ),
  'MA' => 
  array (
    'name' => 'Morocco',
    'dial_code' => '212',
    'flag' => '🇲🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[5-8]\\d{8}',
  ),
  'MC' => 
  array (
    'name' => 'Monaco',
    'dial_code' => '377',
    'flag' => '🇲🇨',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[3489]|[67]\\d)\\d{7}',
  ),
  'MD' => 
  array (
    'name' => 'Moldova, Republic of',
    'dial_code' => '373',
    'flag' => '🇲🇩',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[235-7]\\d|[89]0)\\d{6}',
  ),
  'ME' => 
  array (
    'name' => 'Montenegro',
    'dial_code' => '382',
    'flag' => '🇲🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:20|[3-79]\\d)\\d{6}|80\\d{6,7}',
  ),
  'MF' => 
  array (
    'name' => 'Saint Martin (French part)',
    'dial_code' => '590',
    'flag' => '🇲🇫',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '7090\\d{5}|(?:[56]9|[89]\\d)\\d{7}',
  ),
  'MG' => 
  array (
    'name' => 'Madagascar',
    'dial_code' => '261',
    'flag' => '🇲🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[23]\\d{8}',
  ),
  'MH' => 
  array (
    'name' => 'Marshall Islands',
    'dial_code' => '692',
    'flag' => '🇲🇭',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '329\\d{4}|(?:[256]\\d|45)\\d{5}',
  ),
  'MK' => 
  array (
    'name' => 'North Macedonia',
    'dial_code' => '389',
    'flag' => '🇲🇰',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-578]\\d{7}',
  ),
  'ML' => 
  array (
    'name' => 'Mali',
    'dial_code' => '223',
    'flag' => '🇲🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[24-9]\\d{7}',
  ),
  'MM' => 
  array (
    'name' => 'Myanmar',
    'dial_code' => '95',
    'flag' => '🇲🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1\\d{5,7}|95\\d{6}|(?:[4-7]|9[0-46-9])\\d{6,8}|(?:2|8\\d)\\d{5,8}',
  ),
  'MN' => 
  array (
    'name' => 'Mongolia',
    'dial_code' => '976',
    'flag' => '🇲🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[12]\\d{7,9}|[5-9]\\d{7}',
  ),
  'MO' => 
  array (
    'name' => 'Macao',
    'dial_code' => '853',
    'flag' => '🇲🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '0800\\d{3}|(?:28|[68]\\d)\\d{6}',
  ),
  'MP' => 
  array (
    'name' => 'Northern Mariana Islands',
    'dial_code' => '1',
    'flag' => '🇲🇵',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[58]\\d{9}|(?:67|90)0\\d{7}',
  ),
  'MQ' => 
  array (
    'name' => 'Martinique',
    'dial_code' => '596',
    'flag' => '🇲🇶',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '7091\\d{5}|(?:[56]9|[89]\\d)\\d{7}',
  ),
  'MR' => 
  array (
    'name' => 'Mauritania',
    'dial_code' => '222',
    'flag' => '🇲🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2-4]\\d\\d|800)\\d{5}',
  ),
  'MS' => 
  array (
    'name' => 'Montserrat',
    'dial_code' => '1',
    'flag' => '🇲🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|664|900)\\d{7}',
  ),
  'MT' => 
  array (
    'name' => 'Malta',
    'dial_code' => '356',
    'flag' => '🇲🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '3550\\d{4}|(?:[2579]\\d\\d|800)\\d{5}',
  ),
  'MU' => 
  array (
    'name' => 'Mauritius',
    'dial_code' => '230',
    'flag' => '🇲🇺',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[57]|8\\d\\d)\\d{7}|[2-468]\\d{6}',
  ),
  'MV' => 
  array (
    'name' => 'Maldives',
    'dial_code' => '960',
    'flag' => '🇲🇻',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:800|9[0-57-9]\\d)\\d{7}|[34679]\\d{6}',
  ),
  'MW' => 
  array (
    'name' => 'Malawi',
    'dial_code' => '265',
    'flag' => '🇲🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[1289]\\d|31|77)\\d{7}|1\\d{6}',
  ),
  'MX' => 
  array (
    'name' => 'Mexico',
    'dial_code' => '52',
    'flag' => '🇲🇽',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-9]\\d{9}',
  ),
  'MY' => 
  array (
    'name' => 'Malaysia',
    'dial_code' => '60',
    'flag' => '🇲🇾',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1\\d{8,9}|(?:3\\d|[4-9])\\d{7}',
  ),
  'MZ' => 
  array (
    'name' => 'Mozambique',
    'dial_code' => '258',
    'flag' => '🇲🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:2|8\\d)\\d{7}',
  ),
  'NA' => 
  array (
    'name' => 'Namibia',
    'dial_code' => '264',
    'flag' => '🇳🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[68]\\d{7,8}',
  ),
  'NC' => 
  array (
    'name' => 'New Caledonia',
    'dial_code' => '687',
    'flag' => '🇳🇨',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:050|[2-57-9]\\d\\d)\\d{3}',
  ),
  'NE' => 
  array (
    'name' => 'Niger',
    'dial_code' => '227',
    'flag' => '🇳🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[027-9]\\d{7}',
  ),
  'NF' => 
  array (
    'name' => 'Norfolk Island',
    'dial_code' => '672',
    'flag' => '🇳🇫',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[13]\\d{5}',
  ),
  'NG' => 
  array (
    'name' => 'Nigeria',
    'dial_code' => '234',
    'flag' => '🇳🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:20|9\\d)\\d{8}|[78]\\d{9,13}',
  ),
  'NI' => 
  array (
    'name' => 'Nicaragua',
    'dial_code' => '505',
    'flag' => '🇳🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:1800|[25-8]\\d{3})\\d{4}',
  ),
  'NL' => 
  array (
    'name' => 'Netherlands',
    'dial_code' => '31',
    'flag' => '🇳🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[124-7]\\d\\d|3(?:[02-9]\\d|1[0-8]))\\d{6}|8\\d{6,9}|9\\d{6,10}|1\\d{4,5}',
  ),
  'NO' => 
  array (
    'name' => 'Norway',
    'dial_code' => '47',
    'flag' => '🇳🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:0|[2-9]\\d{3})\\d{4}',
  ),
  'NP' => 
  array (
    'name' => 'Nepal',
    'dial_code' => '977',
    'flag' => '🇳🇵',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:1\\d|9)\\d{9}|[1-9]\\d{7}',
  ),
  'NR' => 
  array (
    'name' => 'Nauru',
    'dial_code' => '674',
    'flag' => '🇳🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:222|444|(?:55|8\\d)\\d|666|777|999)\\d{4}',
  ),
  'NU' => 
  array (
    'name' => 'Niue',
    'dial_code' => '683',
    'flag' => '🇳🇺',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[4-7]|888\\d)\\d{3}',
  ),
  'NZ' => 
  array (
    'name' => 'New Zealand',
    'dial_code' => '64',
    'flag' => '🇳🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1289]\\d{9}|50\\d{5}(?:\\d{2,3})?|[27-9]\\d{7,8}|(?:[34]\\d|6[0-35-9])\\d{6}|8\\d{4,6}',
  ),
  'OM' => 
  array (
    'name' => 'Oman',
    'dial_code' => '968',
    'flag' => '🇴🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:1505|[279]\\d{3}|500)\\d{4}|800\\d{5,6}',
  ),
  'PA' => 
  array (
    'name' => 'Panama',
    'dial_code' => '507',
    'flag' => '🇵🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:00800|8\\d{3})\\d{6}|[68]\\d{7}|[1-57-9]\\d{6}',
  ),
  'PE' => 
  array (
    'name' => 'Peru',
    'dial_code' => '51',
    'flag' => '🇵🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[14-8]|9\\d)\\d{7}',
  ),
  'PF' => 
  array (
    'name' => 'French Polynesia',
    'dial_code' => '689',
    'flag' => '🇵🇫',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '4\\d{5}(?:\\d{2})?|8\\d{7,8}',
  ),
  'PG' => 
  array (
    'name' => 'Papua New Guinea',
    'dial_code' => '675',
    'flag' => '🇵🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:180|[78]\\d{3})\\d{4}|(?:[2-589]\\d|64)\\d{5}',
  ),
  'PH' => 
  array (
    'name' => 'Philippines',
    'dial_code' => '63',
    'flag' => '🇵🇭',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2-7]|9\\d)\\d{8}|2\\d{5}|(?:1800|8)\\d{7,9}',
  ),
  'PK' => 
  array (
    'name' => 'Pakistan',
    'dial_code' => '92',
    'flag' => '🇵🇰',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '122\\d{6}|[24-8]\\d{10,11}|9(?:[013-9]\\d{8,10}|2(?:[01]\\d\\d|2(?:[06-8]\\d|1[01]))\\d{7})|(?:[2-8]\\d{3}|92(?:[0-7]\\d|8[1-9]))\\d{6}|[24-9]\\d{8}|[89]\\d{7}',
  ),
  'PL' => 
  array (
    'name' => 'Poland',
    'dial_code' => '48',
    'flag' => '🇵🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:6|8\\d\\d)\\d{7}|[1-9]\\d{6}(?:\\d{2})?|[26]\\d{5}',
  ),
  'PM' => 
  array (
    'name' => 'Saint Pierre and Miquelon',
    'dial_code' => '508',
    'flag' => '🇵🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[78]\\d{8}|[2-9]\\d{5}',
  ),
  'PR' => 
  array (
    'name' => 'Puerto Rico',
    'dial_code' => '1',
    'flag' => '🇵🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[589]\\d\\d|787)\\d{7}',
  ),
  'PS' => 
  array (
    'name' => 'Palestine, State of',
    'dial_code' => '970',
    'flag' => '🇵🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2489]2\\d{6}|(?:1\\d|5)\\d{8}',
  ),
  'PT' => 
  array (
    'name' => 'Portugal',
    'dial_code' => '351',
    'flag' => '🇵🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '1693\\d{5}|(?:[26-9]\\d|30)\\d{7}',
  ),
  'PW' => 
  array (
    'name' => 'Palau',
    'dial_code' => '680',
    'flag' => '🇵🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[24-8]\\d\\d|345|900)\\d{4}',
  ),
  'PY' => 
  array (
    'name' => 'Paraguay',
    'dial_code' => '595',
    'flag' => '🇵🇾',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[36-8]\\d{5,8}|4\\d{6,8}|59\\d{6}|9\\d{5,10}|(?:2\\d|5[0-8])\\d{6,7}',
  ),
  'QA' => 
  array (
    'name' => 'Qatar',
    'dial_code' => '974',
    'flag' => '🇶🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '800\\d{4}|(?:2|800)\\d{6}|(?:0080|[3-7])\\d{7}',
  ),
  'RE' => 
  array (
    'name' => 'Réunion',
    'dial_code' => '262',
    'flag' => '🇷🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '709\\d{6}|(?:26|[689]\\d)\\d{7}',
  ),
  'RO' => 
  array (
    'name' => 'Romania',
    'dial_code' => '40',
    'flag' => '🇷🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[236-8]\\d|90)\\d{7}|[23]\\d{5}',
  ),
  'RS' => 
  array (
    'name' => 'Serbia',
    'dial_code' => '381',
    'flag' => '🇷🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '38[02-9]\\d{6,9}|6\\d{7,9}|90\\d{4,8}|38\\d{5,6}|(?:7\\d\\d|800)\\d{3,9}|(?:[12]\\d|3[0-79])\\d{5,10}',
  ),
  'RU' => 
  array (
    'name' => 'Russian Federation',
    'dial_code' => '7',
    'flag' => '🇷🇺',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '8\\d{13}|[347-9]\\d{9}',
  ),
  'RW' => 
  array (
    'name' => 'Rwanda',
    'dial_code' => '250',
    'flag' => '🇷🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:06|[27]\\d\\d|[89]00)\\d{6}',
  ),
  'SA' => 
  array (
    'name' => 'Saudi Arabia',
    'dial_code' => '966',
    'flag' => '🇸🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[15]\\d|800|92)\\d{7}',
  ),
  'SB' => 
  array (
    'name' => 'Solomon Islands',
    'dial_code' => '677',
    'flag' => '🇸🇧',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[6-9]\\d{6}|[1-6]\\d{4}',
  ),
  'SC' => 
  array (
    'name' => 'Seychelles',
    'dial_code' => '248',
    'flag' => '🇸🇨',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2489]\\d|64)\\d{5}',
  ),
  'SD' => 
  array (
    'name' => 'Sudan',
    'dial_code' => '249',
    'flag' => '🇸🇩',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[19]\\d{8}',
  ),
  'SE' => 
  array (
    'name' => 'Sweden',
    'dial_code' => '46',
    'flag' => '🇸🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[26]\\d\\d|9)\\d{9}|[1-9]\\d{8}|[1-689]\\d{7}|[1-4689]\\d{6}|2\\d{5}',
  ),
  'SG' => 
  array (
    'name' => 'Singapore',
    'dial_code' => '65',
    'flag' => '🇸🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:(?:1\\d|8)\\d\\d|7000)\\d{7}|[3689]\\d{7}',
  ),
  'SH' => 
  array (
    'name' => 'Saint Helena, Ascension and Tristan da Cunha',
    'dial_code' => '290',
    'flag' => '🇸🇭',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[256]\\d|8)\\d{3}',
  ),
  'SI' => 
  array (
    'name' => 'Slovenia',
    'dial_code' => '386',
    'flag' => '🇸🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-7]\\d{7}|8\\d{4,7}|90\\d{4,6}',
  ),
  'SJ' => 
  array (
    'name' => 'Svalbard and Jan Mayen',
    'dial_code' => '47',
    'flag' => '🇸🇯',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '0\\d{4}|(?:[489]\\d|79)\\d{6}',
  ),
  'SK' => 
  array (
    'name' => 'Slovakia',
    'dial_code' => '421',
    'flag' => '🇸🇰',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-689]\\d{8}|[2-59]\\d{6}|[2-5]\\d{5}',
  ),
  'SL' => 
  array (
    'name' => 'Sierra Leone',
    'dial_code' => '232',
    'flag' => '🇸🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[237-9]\\d|66)\\d{6}',
  ),
  'SM' => 
  array (
    'name' => 'San Marino',
    'dial_code' => '378',
    'flag' => '🇸🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:0549|[5-7]\\d)\\d{6}',
  ),
  'SN' => 
  array (
    'name' => 'Senegal',
    'dial_code' => '221',
    'flag' => '🇸🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[378]\\d|93)\\d{7}',
  ),
  'SO' => 
  array (
    'name' => 'Somalia',
    'dial_code' => '252',
    'flag' => '🇸🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[346-9]\\d{8}|[12679]\\d{7}|[1-5]\\d{6}|[1348]\\d{5}',
  ),
  'SR' => 
  array (
    'name' => 'Suriname',
    'dial_code' => '597',
    'flag' => '🇸🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2-5]|[6-9]\\d)\\d{5}',
  ),
  'SS' => 
  array (
    'name' => 'South Sudan',
    'dial_code' => '211',
    'flag' => '🇸🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[19]\\d{8}',
  ),
  'ST' => 
  array (
    'name' => 'Sao Tome and Principe',
    'dial_code' => '239',
    'flag' => '🇸🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:22|9\\d)\\d{5}',
  ),
  'SV' => 
  array (
    'name' => 'El Salvador',
    'dial_code' => '503',
    'flag' => '🇸🇻',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[25-7]\\d{7}|(?:80\\d|900)\\d{4}(?:\\d{4})?',
  ),
  'SX' => 
  array (
    'name' => 'Sint Maarten (Dutch part)',
    'dial_code' => '1',
    'flag' => '🇸🇽',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '7215\\d{6}|(?:[58]\\d\\d|900)\\d{7}',
  ),
  'SY' => 
  array (
    'name' => 'Syrian Arab Republic',
    'dial_code' => '963',
    'flag' => '🇸🇾',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-359]\\d{8}|[1-5]\\d{7}',
  ),
  'SZ' => 
  array (
    'name' => 'Eswatini',
    'dial_code' => '268',
    'flag' => '🇸🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '0800\\d{4}|(?:[237]\\d|900)\\d{6}',
  ),
  'TC' => 
  array (
    'name' => 'Turks and Caicos Islands',
    'dial_code' => '1',
    'flag' => '🇹🇨',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|649|900)\\d{7}',
  ),
  'TD' => 
  array (
    'name' => 'Chad',
    'dial_code' => '235',
    'flag' => '🇹🇩',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:22|[3689]\\d|77)\\d{6}',
  ),
  'TG' => 
  array (
    'name' => 'Togo',
    'dial_code' => '228',
    'flag' => '🇹🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[279]\\d{7}',
  ),
  'TH' => 
  array (
    'name' => 'Thailand',
    'dial_code' => '66',
    'flag' => '🇹🇭',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:001800|[2-57]|[689]\\d)\\d{7}|1\\d{7,9}',
  ),
  'TJ' => 
  array (
    'name' => 'Tajikistan',
    'dial_code' => '992',
    'flag' => '🇹🇯',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[0-57-9]\\d|66)\\d{7}',
  ),
  'TK' => 
  array (
    'name' => 'Tokelau',
    'dial_code' => '690',
    'flag' => '🇹🇰',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-47]\\d{3,6}',
  ),
  'TL' => 
  array (
    'name' => 'Timor-Leste',
    'dial_code' => '670',
    'flag' => '🇹🇱',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '7\\d{7}|(?:[2-47]\\d|[89]0)\\d{5}',
  ),
  'TM' => 
  array (
    'name' => 'Turkmenistan',
    'dial_code' => '993',
    'flag' => '🇹🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-7]\\d{7}',
  ),
  'TN' => 
  array (
    'name' => 'Tunisia',
    'dial_code' => '216',
    'flag' => '🇹🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-57-9]\\d{7}',
  ),
  'TO' => 
  array (
    'name' => 'Tonga',
    'dial_code' => '676',
    'flag' => '🇹🇴',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:0800|(?:[5-8]\\d\\d|999)\\d)\\d{3}|[2-8]\\d{4}',
  ),
  'TR' => 
  array (
    'name' => 'Türkiye',
    'dial_code' => '90',
    'flag' => '🇹🇷',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '4\\d{6}|8\\d{11,12}|(?:[2-58]\\d\\d|900)\\d{7}',
  ),
  'TT' => 
  array (
    'name' => 'Trinidad and Tobago',
    'dial_code' => '1',
    'flag' => '🇹🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|900)\\d{7}',
  ),
  'TV' => 
  array (
    'name' => 'Tuvalu',
    'dial_code' => '688',
    'flag' => '🇹🇻',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:2|7\\d\\d|90)\\d{4}',
  ),
  'TW' => 
  array (
    'name' => 'Taiwan, Province of China',
    'dial_code' => '886',
    'flag' => '🇹🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-689]\\d{8}|7\\d{9,10}|[2-8]\\d{7}|2\\d{6}',
  ),
  'TZ' => 
  array (
    'name' => 'Tanzania, United Republic of',
    'dial_code' => '255',
    'flag' => '🇹🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[25-8]\\d|41|90)\\d{7}',
  ),
  'UA' => 
  array (
    'name' => 'Ukraine',
    'dial_code' => '380',
    'flag' => '🇺🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[89]\\d{9}|[3-9]\\d{8}',
  ),
  'UG' => 
  array (
    'name' => 'Uganda',
    'dial_code' => '256',
    'flag' => '🇺🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '800\\d{6}|(?:[29]0|[347]\\d)\\d{7}',
  ),
  'US' => 
  array (
    'name' => 'United States',
    'dial_code' => '1',
    'flag' => '🇺🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[2-9]\\d{9}|3\\d{6}',
  ),
  'UY' => 
  array (
    'name' => 'Uruguay',
    'dial_code' => '598',
    'flag' => '🇺🇾',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '0004\\d{2,9}|[1249]\\d{7}|2\\d{3,4}|(?:[49]\\d|80)\\d{5}',
  ),
  'UZ' => 
  array (
    'name' => 'Uzbekistan',
    'dial_code' => '998',
    'flag' => '🇺🇿',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:20|33|[5-9]\\d)\\d{7}',
  ),
  'VA' => 
  array (
    'name' => 'Holy See (Vatican City State)',
    'dial_code' => '39',
    'flag' => '🇻🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '0\\d{5,10}|3[0-8]\\d{7,10}|55\\d{8}|8\\d{5}(?:\\d{2,4})?|(?:1\\d|39)\\d{7,8}',
  ),
  'VC' => 
  array (
    'name' => 'Saint Vincent and the Grenadines',
    'dial_code' => '1',
    'flag' => '🇻🇨',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[58]\\d\\d|784|900)\\d{7}',
  ),
  'VE' => 
  array (
    'name' => 'Venezuela, Bolivarian Republic of',
    'dial_code' => '58',
    'flag' => '🇻🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[68]00\\d{7}|(?:[24]\\d|[59]0)\\d{8}',
  ),
  'VG' => 
  array (
    'name' => 'Virgin Islands, British',
    'dial_code' => '1',
    'flag' => '🇻🇬',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:284|[58]\\d\\d|900)\\d{7}',
  ),
  'VI' => 
  array (
    'name' => 'Virgin Islands, U.S.',
    'dial_code' => '1',
    'flag' => '🇻🇮',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[58]\\d{9}|(?:34|90)0\\d{7}',
  ),
  'VN' => 
  array (
    'name' => 'Viet Nam',
    'dial_code' => '84',
    'flag' => '🇻🇳',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[12]\\d{9}|[135-9]\\d{8}|[16]\\d{6,7}|7\\d{6}',
  ),
  'VU' => 
  array (
    'name' => 'Vanuatu',
    'dial_code' => '678',
    'flag' => '🇻🇺',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[57-9]\\d{6}|(?:[238]\\d|48)\\d{3}',
  ),
  'WF' => 
  array (
    'name' => 'Wallis and Futuna',
    'dial_code' => '681',
    'flag' => '🇼🇫',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:40|72|8\\d{4})\\d{4}|[89]\\d{5}',
  ),
  'WS' => 
  array (
    'name' => 'Samoa',
    'dial_code' => '685',
    'flag' => '🇼🇸',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:[2-6]|8\\d{5})\\d{4}|[78]\\d{6}|[68]\\d{5}',
  ),
  'YE' => 
  array (
    'name' => 'Yemen',
    'dial_code' => '967',
    'flag' => '🇾🇪',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:1|7\\d)\\d{7}|[1-7]\\d{6}',
  ),
  'YT' => 
  array (
    'name' => 'Mayotte',
    'dial_code' => '262',
    'flag' => '🇾🇹',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:639\\d|7093)\\d{5}|(?:26|80|9\\d)\\d{7}',
  ),
  'ZA' => 
  array (
    'name' => 'South Africa',
    'dial_code' => '27',
    'flag' => '🇿🇦',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '[1-79]\\d{8}|8\\d{4,9}',
  ),
  'ZM' => 
  array (
    'name' => 'Zambia',
    'dial_code' => '260',
    'flag' => '🇿🇲',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '800\\d{6}|(?:21|[579]\\d|63)\\d{7}',
  ),
  'ZW' => 
  array (
    'name' => 'Zimbabwe',
    'dial_code' => '263',
    'flag' => '🇿🇼',
    'min_length' => 7,
    'max_length' => 15,
    'pattern' => '(?:13|8\\d{4})\\d{5}|[235-8]\\d{8}|[2-689]\\d{6}',
  ),
);
    return $data;
}

function vj_chat_get_country($country_code) {
    $country_code = strtoupper(preg_replace('/[^A-Za-z]/', '', (string) $country_code));
    $data = vj_chat_get_country_data();
    return isset($data[$country_code]) ? $data[$country_code] : null;
}
