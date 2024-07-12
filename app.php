<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->usePutenv();
$dotenv->load(__DIR__ . '/.env');

$testService = new App\Service\TestService();
$testService->test();
$rates = @json_decode(file_get_contents('http://api.exchangeratesapi.io/latest?access_key=' . getenv('EXCHANGE_RATES_API_KEY')), true);
var_dump($rates);

foreach (explode("\n", file_get_contents($argv[1])) as $row) {

    if (empty($row)) break;
    $p = explode(",",$row);
    $p2 = explode(':', $p[0]);
    $value[0] = trim($p2[1], '"');
    $p2 = explode(':', $p[1]);
    $value[1] = trim($p2[1], '"');
    $p2 = explode(':', $p[2]);
    $value[2] = trim($p2[1], '"}');

    $binResults = file_get_contents('https://lookup.binlist.net/' .$value[0]);
    sleep(1);
    var_dump($binResults);
    if (!$binResults)
        die('error!');
    $r = json_decode($binResults);
    $isEu = isEu($r->country->alpha2);

    $currencyRate = $rates['rates'][$value[2]];
    if ($value[2] == 'EUR' or $currencyRate == 0) {
        $amntFixed = $value[1];
    }
    if ($value[2] != 'EUR' or $currencyRate > 0) {
        $amntFixed = $value[1] / $currencyRate;
    }

    echo $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02);
    print "\n";
}

function isEu($c) {
    $result = false;
    switch($c) {
        case 'AT':
        case 'BE':
        case 'BG':
        case 'CY':
        case 'CZ':
        case 'DE':
        case 'DK':
        case 'EE':
        case 'ES':
        case 'FI':
        case 'FR':
        case 'GR':
        case 'HR':
        case 'HU':
        case 'IE':
        case 'IT':
        case 'LT':
        case 'LU':
        case 'LV':
        case 'MT':
        case 'NL':
        case 'PO':
        case 'PT':
        case 'RO':
        case 'SE':
        case 'SI':
        case 'SK':
            $result = 'yes';
            return $result;
        default:
            $result = 'no';
    }
    return $result;
}