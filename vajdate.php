<?php
/*
[2024] seovaj. All rights reserved.

This code is provided by seovaj (seovaj.com). You are free to use this code for personal and commercial purposes, however, modifications to the code are not allowed without explicit written permission from seovaj.

For any inquiries regarding modifications or permissions, please contact us at [seovaj@gmail.com].
*/

if (!function_exists('vajdateJalali')) {
    function vajdateJalali($gy, $gm, $gd) {
        $g_d_m = array(0,31,59,90,120,151,181,212,243,273,304,334);
        $jy = ($gy <= 1600) ? 0 : 979;
        $gy -= ($gy <= 1600) ? 621 : 1600;
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = (365 * $gy) + (int)(($gy2 + 3) / 4) - (int)(($gy2 + 99) / 100) + (int)(($gy2 + 399) / 400) - 80 + $gd + $g_d_m[$gm - 1];
        $jy += 33 * (int)($days / 12053); 
        $days %= 12053;
        $jy += 4 * (int)($days / 1461); 
        $days %= 1461;
        $jy += (int)(($days - 1) / 365);
        if ($days > 365) $days = ($days - 1) % 365;
        $jm = ($days < 186) ? 1 + (int)($days / 31) : 7 + (int)(($days - 186) / 30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));
        return array($jy, $jm, $jd);
    }
}

if (!function_exists('vajdateNumbers')) {
    function vajdateNumbers($string) {
        $englishNumbers = range(0, 9);
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return str_replace($englishNumbers, $persianNumbers, $string);
    }
}

if (!function_exists('setVajdateConfig')) {
    function setVajdateConfig($number = 'en', $mon = 'fa', $week = 'fa', $zone = 'Asia/Tehran') {
        global $vajdate_config;

        // Check and set the timezone
        if (!empty($zone)) {
            $vajdate_config['zone'] = $zone;
        } else {
            // Set default timezone if none provided
            $vajdate_config['zone'] = 'Asia/Tehran';
        }
        
        $vajdate_config['number'] = $number;
        $vajdate_config['mon'] = $mon;
        $vajdate_config['week'] = $week;
    }
}

if (!function_exists('vajdate')) {
    function vajdate($format, $gregorianDate = null) {
        global $vajdate_config;

        // Validate timezone
        if (!isset($vajdate_config['zone']) || empty($vajdate_config['zone'])) {
            $vajdate_config['zone'] = 'Asia/Tehran';
        }
        
        // Set timezone
        date_default_timezone_set($vajdate_config['zone']);

        $weekdaysFa = ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'];
        $weekdaysEn = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        
        $jalaliMonthsFa = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
        $gregorianMonthsEn = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Get current date if no date is passed
        if ($gregorianDate === null) {
            $gregorianDate = date('Y-m-d H:i:s');
        } else {
            $gregorianDate .= ' 00:00:00';
        }

        list($gy, $gm, $gd) = explode('-', substr($gregorianDate, 0, 10));
        list($jy, $jm, $jd) = vajdateJalali($gy, $gm, $gd);

        $timestamp = strtotime($gregorianDate);

        // Check if the configuration array keys exist, otherwise set default values
        $monType = isset($vajdate_config['mon']) ? $vajdate_config['mon'] : 'fa';
        $weekType = isset($vajdate_config['week']) ? $vajdate_config['week'] : 'fa';
        $numberType = isset($vajdate_config['number']) ? $vajdate_config['number'] : 'en';

        // Select month and weekday names based on config
        $selectedMonth = ($monType === 'fa') ? $jalaliMonthsFa[$jm - 1] : $gregorianMonthsEn[$gm - 1];
        $selectedWeekday = ($weekType === 'fa') ? $weekdaysFa[date('w', $timestamp)] : $weekdaysEn[date('w', $timestamp)];

        $time = [
            'Y' => str_pad($jy, 4, '0', STR_PAD_LEFT),
            'm' => str_pad($jm, 2, '0', STR_PAD_LEFT),
            'd' => str_pad($jd, 2, '0', STR_PAD_LEFT),
            'H' => str_pad(date('H', $timestamp), 2, '0', STR_PAD_LEFT),
            'i' => str_pad(date('i', $timestamp), 2, '0', STR_PAD_LEFT),
            's' => str_pad(date('s', $timestamp), 2, '0', STR_PAD_LEFT),
            'z' => $selectedWeekday,
            'x' => $selectedMonth
        ];

        // Replace format placeholders
        $formatted = $format;
        foreach ($time as $key => $value) {
            $formatted = str_replace($key, $value, $formatted);
        }

        // Convert numbers to Persian if needed
        if ($numberType === 'fa') {
            $formatted = vajdateNumbers($formatted);
        }

        return $formatted;
    }
}
