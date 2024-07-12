<?php

namespace App\Integration;

use App\Dto\CardInformation;
use App\Service\CountryCodeService;

class MockCardInformationApi implements CardInformationProviderInterface
{
    private CountryCodeService $countryCodeService;
    public function __construct()
    {
        $this->countryCodeService = new CountryCodeService();
    }

    public function getCardInformation(string $bankIdentificationNumber): CardInformation
    {
        $predefined = [
            '45717360' => 'DK',
            '516793' => 'LT',
            '45417360' => 'JP',
            '41417360' => 'LT',
            '4745030' => 'LT',
        ];

        $alfa2Code = $predefined[$bankIdentificationNumber] ?? null;

        if ($alfa2Code === null && strlen($bankIdentificationNumber) > 5 && strlen($bankIdentificationNumber) < 9) {
            $alfa2Code = $this->countryCodeService->getRandomCountryCode();
        }

        $cardInformation = new CardInformation();
        $cardInformation->setCountryAlfa2Code($alfa2Code);

        return $cardInformation;
    }
}
