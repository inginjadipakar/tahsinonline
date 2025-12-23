<?php

namespace App\Helpers;

class PhoneHelper
{
    /**
     * Normalize phone number to Indonesian format (628xxx)
     * 
     * Handles different input formats:
     * - 08xxx → 628xxx
     * - 8xxx → 628xxx (user typed without 0 since UI shows +62)
     * - 628xxx → 628xxx (already correct)
     * - +628xxx → 628xxx (with plus sign)
     *
     * @param string|null $phone
     * @return string
     */
    public static function normalize(?string $phone): string
    {
        if (empty($phone)) {
            return '';
        }

        // Remove any non-numeric characters (spaces, dashes, plus sign, etc.)
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Handle different input formats
        if (str_starts_with($phone, '0')) {
            // 08xxx → 628xxx
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            // 8xxx → 628xxx
            $phone = '62' . $phone;
        }
        // else: already starts with 62, keep as is

        return $phone;
    }

    /**
     * Format phone for display (628xxx → +62 8xxx)
     *
     * @param string|null $phone
     * @return string
     */
    public static function formatForDisplay(?string $phone): string
    {
        if (empty($phone)) {
            return '';
        }

        // Ensure normalized first
        $phone = self::normalize($phone);

        // Format: +62 812-3456-7890
        if (strlen($phone) >= 10) {
            $countryCode = substr($phone, 0, 2);
            $rest = substr($phone, 2);
            return '+' . $countryCode . ' ' . $rest;
        }

        return $phone;
    }

    /**
     * Validate Indonesian phone number format
     *
     * @param string|null $phone
     * @return bool
     */
    public static function isValid(?string $phone): bool
    {
        if (empty($phone)) {
            return false;
        }

        $normalized = self::normalize($phone);

        // Indonesian mobile numbers: 62 + 8xx + 8-10 digits = 11-13 total
        return preg_match('/^628[0-9]{8,11}$/', $normalized) === 1;
    }
}
