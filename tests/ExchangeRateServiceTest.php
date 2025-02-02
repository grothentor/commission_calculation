<?php

use App\Service\ExchangeRateService;
use PHPUnit\Framework\TestCase;

class ExchangeRateServiceTest extends TestCase
{
    private $exchangeRateService;

    public function testGetRate()
    {
        $this->assertEquals(1, $this->exchangeRateService->getRate('EUR'));
        $this->assertGreaterThan(1, $this->exchangeRateService->getRate('USD'));
    }

    protected function setUp(): void
    {
        $this->exchangeRateService = new ExchangeRateService();
        parent::setUp();
    }
}
