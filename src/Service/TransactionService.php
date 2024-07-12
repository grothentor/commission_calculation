<?php

namespace App\Service;

use App\Dto\Transaction;

class TransactionService
{
    /**
     * @param string $filePath
     * @return Transaction[]
     * @throws \Exception
     */
    public function readTransactionsFromFile(string $filePath): array
    {
        $transactions = [];
        $file = fopen($filePath, 'r');

        if ($file) {
            $index = 1;
            while (($line = fgets($file)) !== false) {
                $transactions[] = $this->parseTransaction($line, $index);
                $index++;
            }

            fclose($file);
        }
        return $transactions;
    }

    private function parseTransaction($line, $index): Transaction
    {
        if (json_validate($line)) {
            $line = json_decode($line, true);
            try {
                return Transaction::createFromArray($line);
            } catch (\Throwable $exception) {
                throw new \Exception('Invalid transaction data for row(' . $index . '): ' . $exception->getMessage());
            }
        } else {
            throw new \Exception('Invalid JSON format for row(' . $index . '): ' . $line);
        }
    }
}