<?php

namespace App\Integration;

use App\Dto\CardInformation;
use App\Service\ThrottlerService;
use Curl\Curl;

class BinListApi implements CardInformationProviderInterface
{
    private string $url;

    private ThrottlerService $throttlerService;

    public function __construct()
    {
        $this->throttlerService = new ThrottlerService(60);
        $this->url = getenv('BIN_LIST_API_URL');
        if (!$this->url) {
            throw new \Exception('BinListApi configuration is missing');
        }
    }

    public function getCardInformation(string $bankIdentificationNumber): CardInformation
    {
        $curl = new Curl();
        $this->throttlerService->throttle();
        $curl->get($this->getUrl($bankIdentificationNumber));

        if (!$curl->isSuccess()) {
            if ($curl->http_status_code === 429) {
                throw new \Exception($this->url . ' rate limit (5 requests per hour) exceeded' .
                    ' change your IP address, or switch to Mocks');
            }
            throw new \Exception('BinListApi error: ' . ($curl->getErrorMessage() ?: $curl->error_message));
        }

        $cardInfo = json_decode($curl->response, true);
        $cardInformation = new CardInformation();
        $cardInformation->setCountryAlfa2Code($cardInfo['country']['alpha2'] ?? null);

        return $cardInformation;
    }

    private function getUrl($url): string
    {
        return $this->url . $url;
    }
}
