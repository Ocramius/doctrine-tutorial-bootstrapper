<?php

namespace Library;

class BookAmount
{
    private $isbn;

    private $amount;

    public function __construct($isbn, $amount)
    {
        $this->isbn = $isbn;
        $this->amount = $amount;
    }

    public function add($amount)
    {
        return new self($this->isbn, $amount + $this->amount);
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function toInt()
    {
        return $this->amount;
    }
}
