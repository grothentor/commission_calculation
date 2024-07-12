<?php

namespace App\Service;

class CountryCodeService
{
    private const array EU_COUNTRIES_CODES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public function isEUCode(?string $alfa2Code): bool
    {
        return $alfa2Code && in_array($alfa2Code, self::EU_COUNTRIES_CODES);
    }

    /**
     * Generate a random string from AA to ZZ, which is looks like a country alfa2 code
     * ~ 36% of them are real country codes
     * @return string
     */
    public function getRandomCountryCode(): string
    {
        $ordA = ord('A');
        $ordZ = ord('Z');
        return chr(rand($ordA, $ordZ)) . chr(rand($ordA, $ordZ));
    }

    public function getRandomEUCode(): string
    {
        $randomKey = array_rand(self::EU_COUNTRIES_CODES);

        return self::EU_COUNTRIES_CODES[$randomKey];
    }
}
