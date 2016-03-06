<?php

namespace VelovitoBundle\Exception;

class InsufficientFundsException extends \Exception
{
    private $amount;

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}