<?php

namespace Library;

final class Amount
{
    private $amount;

    private function __construct()
    {
    }

    public static function fromInteger($amount)
    {
        $instance = new self();

        if (! is_int($amount)) {
            throw new \InvalidArgumentException(sprintf(
                'Amount is supposed to be int, %s given',
                gettype($amount)
            ));
        }

        if ($amount <= 0) {
            throw new \InvalidArgumentException(sprintf(
                'Amount is supposed to greater than 0, %s given',
                $amount
            ));
        }

        $instance->amount = $amount;

        return $instance;
    }

    public function toInt()
    {
        return $this->amount;
    }
}