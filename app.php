<?php

require 'autoload.php';

use App\Service\TransactionService;
use App\Service\CommissionService;

$transactionService = new TransactionService();
$commissionService = new CommissionService();
$transactions = $transactionService->readTransactionsFromFile($argv[1]);
$commissions = $commissionService->calculateCommissions($transactions);

print_r(implode(PHP_EOL, $commissions) . PHP_EOL);
