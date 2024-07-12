<?php

namespace App\Integration;

use App\Dto\CardInformation;

interface CardInformationProviderInterface
{
    public function getCardInformation(string $bankIdentificationNumber): CardInformation;
}
