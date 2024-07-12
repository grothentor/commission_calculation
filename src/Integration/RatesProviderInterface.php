<?php

namespace App\Integration;

interface RatesProviderInterface
{
    public function getRates(): array;
}