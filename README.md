# vajdate-php

Lightweight PHP library for converting Gregorian dates to Jalali (Shamsi/Persian) calendar with support for Persian numbers, month names, weekdays, and customizable timezone.

## Features
- Convert Gregorian dates to Jalali
- Show Persian month and weekday names
- Option to use Persian or English numbers
- Customizable timezone
- Dependency-free (pure PHP)

## Installation

Include the file manually:

```php
require 'vajdate.php';

// 1️⃣ Get today's Jalali date with default settings
echo vajdate('Y-m-d');
// Example output: 1404-10-12

// 2️⃣ Get today's Jalali date with Persian numbers
setVajdateConfig('fa'); // numbers in Persian
echo vajdate('Y-m-d');
// Example output: ۱۴۰۴-۱۰-۱۲

// 3️⃣ Convert a specific Gregorian date to Jalali
echo vajdate('Y-m-d', '2026-01-02');
// Example output: 1404-10-12

// 4️⃣ Show Persian month and weekday names
setVajdateConfig('fa', 'fa', 'fa');
echo vajdate('z, x d, Y');
// Example output: Panjshanbe, Dey 12, 1404

// 5️⃣ Show English month and weekday names
setVajdateConfig('en', 'en', 'en');
echo vajdate('z, x d, Y');
// Example output: Thursday, January 12, 2026

// 6️⃣ Use Persian numbers with English month and weekday names
setVajdateConfig('fa', 'en', 'en');
echo vajdate('z, x d, Y');
// Example output: Thursday, January ۱۲, 1404

// 7️⃣ Change timezone
setVajdateConfig('fa', 'fa', 'fa', 'Asia/Tehran');
echo vajdate('Y-m-d H:i:s');
// Example output: 1404-10-12 14:35:22

// 8️⃣ Custom format with all elements
setVajdateConfig('fa', 'fa', 'fa');
echo vajdate('z, x d, Y - H:i:s');
// Example output: Panjshanbe, Dey 12, 1404 - 14:35:22
