<?php

namespace App\Dto;

class Transaction
{
    private array $fields;

    public static function createFromArray($transactionFields): self
    {
        $requiredFields = ['bin', 'amount', 'currency'];

        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $transactionFields)) {
                throw new \Exception('Missing required field(' . $field . ')');
            }
        }

        $transaction = new self();
        $transactionFields['amount'] = (float) $transactionFields['amount'];
        $transaction->fields = $transactionFields;

        return $transaction;
    }

    public function getBin(): string
    {
        return $this->fields['bin'];
    }

    public function getAmount(): float
    {
        return $this->fields['amount'];
    }

    public function getCurrency(): string
    {
        return $this->fields['currency'];
    }
}
