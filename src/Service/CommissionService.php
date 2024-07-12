<?php

namespace App\Service;

use App\Dto\Transaction;
use App\Facade\ProviderFacade;
use App\Integration\CardInformationProviderInterface;

class CommissionService
{
    public const float EU_COMMISSION_RATE = 0.01;
    public const float NON_EU_COMMISSION_RATE = 0.02;
    private ExchangeRateService $exchangeRateService;
    private CardInformationProviderInterface $cardInformationProvider;
    private CountryCodeService $countryCodeService;
    private $shouldCeilCommissions;

    public function __construct()
    {
        $this->exchangeRateService = new ExchangeRateService();
        $this->cardInformationProvider = ProviderFacade::getCardInformationProvider();
        $this->countryCodeService = new CountryCodeService();
        $this->shouldCeilCommissions = getenv('CEIL_COMMISSIONS') === 'true';
    }

    /**
     * @param Transaction[] $transactions
     * @return float[]
     */
    public function calculateCommissions(array $transactions): array
    {
        return array_map(fn(Transaction $transaction) => $this->calculateCommission($transaction), $transactions);
    }

    public function calculateCommission(Transaction $transaction): float
    {
        $precision = 0.01;
        $cardInformation = $this->cardInformationProvider->getCardInformation($transaction->getBin());
        $commissionRate = $this->getCommissionRate($cardInformation->getCountryAlfa2Code());
        $currencyRate = $this->exchangeRateService->getRate($transaction->getCurrency());
        $amount = $transaction->getAmount();
        $amountInEUR = $currencyRate > 0 ? $amount / $currencyRate : $amount;
        $commissionInEUR = $amountInEUR * $commissionRate;

        if ($this->shouldCeilCommissions) {
            return ceil($commissionInEUR / $precision) * $precision;
        } else {
            return $commissionInEUR;
        }
    }

    public function getCommissionRate(?string $countryCode): float
    {
        return $this->countryCodeService->isEUCode($countryCode) ? self::EU_COMMISSION_RATE : self::NON_EU_COMMISSION_RATE;
    }
}
