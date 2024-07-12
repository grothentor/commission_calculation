<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->usePutenv();
$dotenv->load(__DIR__ . '/.env');
