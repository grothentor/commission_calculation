<?php

namespace App\Service;

class ThrottlerService
{
    private $requestsPerSecond;
    private $lastTimeRequest = 0.0;
    public function __construct($requestsPerSecond = 10)
    {
        $this->requestsPerSecond = $requestsPerSecond;
    }

    public function throttle(): void
    {
        $msToWait = 1000 / $this->requestsPerSecond;
        $currentTime = microtime(true);
        $fromLastRequest = $currentTime - $this->lastTimeRequest;
        if ($fromLastRequest < $msToWait) {
            usleep(round(($msToWait - $fromLastRequest) * 1000));
        }
        $this->lastTimeRequest = microtime(true);
    }
}
