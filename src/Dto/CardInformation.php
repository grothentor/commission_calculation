<?php

namespace App\Dto;

class CardInformation
{
    private ?string $countryAlfa2Code;

    public function getCountryAlfa2Code(): ?string
    {
        return $this->countryAlfa2Code;
    }

    public function setCountryAlfa2Code(?string $countryAlfa2Code): void
    {
        $this->countryAlfa2Code = $countryAlfa2Code;
    }
}
