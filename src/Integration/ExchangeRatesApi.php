<?php

namespace App\Integration;

use Curl\Curl;

class ExchangeRatesApi implements RatesProviderInterface
{
    private $url = null;
    private $apiKey = null;

    public function __construct()
    {
        $this->url = getenv('EXCHANGE_RATES_API_URL');
        $this->apiKey = getenv('EXCHANGE_RATES_API_KEY');

        if (!$this->url || !$this->apiKey) {
            throw new \Exception('ExchangeRatesApi configuration is missing');
        }
    }

    public function getRates(): array
    {
        $curl = new Curl();
        $curl->get($this->getUrl('latest'), $this->getUrlParams());
        if (!$curl->isSuccess())  {
            throw new \Exception('ExchangeRatesApi error: ' . $curl->getErrorMessage());
        }
        $response = json_decode($curl->response, true);
        if (!$response['success']) {
            throw new \Exception('ExchangeRatesApi error: ' . $response['error']['info']);
        }
        return $response['rates'];
    }

    private function getUrl($url)
    {
        return $this->url . $url;
    }

    private function getUrlParams()
    {
        return [
            'access_key' => $this->apiKey,
        ];
    }
}