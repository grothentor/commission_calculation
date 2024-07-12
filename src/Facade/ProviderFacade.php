<?php

namespace App\Facade;

use App\Integration\BinListApi;
use App\Integration\CardInformationProviderInterface;
use App\Integration\ExchangeRatesApi;
use App\Integration\MockCardInformationApi;
use App\Integration\MockExchangeRatesApi;
use App\Integration\RatesProviderInterface;

class ProviderFacade
{
    public static function getRatesProvider(): RatesProviderInterface
    {
        if (self::shouldUseMock()) {
            return new MockExchangeRatesApi();
        }

        return new ExchangeRatesApi();
    }

    public static function getCardInformationProvider(): CardInformationProviderInterface
    {
        if (self::shouldUseMock()) {
            return new MockCardInformationApi();
        }

        return new BinListApi();
    }

    private static function shouldUseMock(): bool
    {
        return getenv('APP_ENV') === 'test';
    }
}