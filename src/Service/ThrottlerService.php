<?php

namespace App\Service;

class ThrottlerService
{
    private $requestsPerSecond;
    private $lastTimeRequest = 0.0;
    public function __construct($requestsPerSecond = 60)
    {
        $this->requestsPerSecond = $requestsPerSecond;
    }

    public function throttle()
    {
        $msToWait = 1000 / $this->requestsPerSecond;
        $currentTime = microtime(true);
        $fromLastRequest = $currentTime - $this->lastTimeRequest;
        if ($fromLastRequest < $msToWait) {
            var_dump('Throttling ' . round(($msToWait - $fromLastRequest) * 1000));
            usleep(round(($msToWait - $fromLastRequest) * 1000));
        }
        $this->lastTimeRequest = microtime(true);
    }
}