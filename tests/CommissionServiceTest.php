<?php

use App\Dto\Transaction;
use App\Service\CommissionService;
use App\Service\ExchangeRateService;
use PHPUnit\Framework\TestCase;

class CommissionServiceTest extends TestCase
{
    private $euBin = '516793';
    private $nonEuBin = '45417360';

    private CommissionService $commissionService;

    public function testEuCommission()
    {
        $transaction = Transaction::createFromArray([
            'bin' => $this->euBin,
            'amount' => 100,
            'currency' => 'EUR'
        ]);

        $this->assertEquals(1, $this->commissionService->calculateCommission($transaction));
    }

    public function testNonEuCommission()
    {
        $transaction = Transaction::createFromArray([
            'bin' => $this->nonEuBin,
            'amount' => 100,
            'currency' => 'EUR'
        ]);

        $this->assertEquals(2, $this->commissionService->calculateCommission($transaction));
    }

    public function testNonEuroCurrencyCommission()
    {
        $exchangeRateService = new ExchangeRateService();
        $currency = 'USD';
        $currencyRate =  $exchangeRateService->getRate($currency);

        $transaction = Transaction::createFromArray([
            'bin' => $this->euBin,
            'amount' => 100,
            'currency' => $currency
        ]);
        $commission = $this->commissionService->calculateCommission($transaction);

        $this->assertEquals(100 / $currencyRate * 0.01, $commission);
    }

    protected function setUp(): void
    {
        $this->commissionService = new CommissionService();
        parent::setUp();
    }
}