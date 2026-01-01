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

// Optional configuration
setVajdateConfig('fa', 'fa', 'fa', 'Asia/Tehran');

// Get today's Jalali (Shamsi) date
echo vajdate('Y-m-d'); 
// Example output: 1404-10-12

// Convert a specific Gregorian date
echo vajdate('Y-m-d', '2026-01-02'); 
// Example output: 1404-10-12

// خروجی: 1404-10-12
