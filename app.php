<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use App\Service\TransactionService;
use App\Service\CommissionService;

$dotenv = new Dotenv();
$dotenv->usePutenv();
$dotenv->load(__DIR__ . '/.env');

$transactionService = new TransactionService();
$commissionService = new CommissionService();
$transactions = $transactionService->readTransactionsFromFile($argv[1]);
$commissions = $commissionService->calculateCommissions($transactions);

print_r(implode(PHP_EOL, $commissions) . PHP_EOL);
