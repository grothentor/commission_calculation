<?php

namespace App\Service;

use App\Facade\ProviderFacade;
use App\Integration\RatesProviderInterface;

class ExchangeRateService
{
    private RatesProviderInterface $rateProvider;
    private array $rates = [];
    public function __construct()
    {
        $this->rateProvider = ProviderFacade::getRatesProvider();
    }

    public function getRate(string $currency): float
    {
        if (empty($this->rates)) {
            $this->rates = $this->rateProvider->getRates();
        }

        return $this->rates[$currency] ?? 0;
    }
}
