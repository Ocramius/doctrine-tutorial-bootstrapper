<?php

namespace Library;

class BookAmount
{
    private $libraryId;
    private $isbn;

    private $amount;

    public function __construct($libraryId, $isbn, Amount $amount)
    {
        $this->libraryId = $libraryId;
        $this->isbn      = $isbn;
        $this->amount    = $amount;
    }

    public function add(Amount $amount)
    {
        $this->amount = $this->amount->add($amount);

        return $this;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function toAmount()
    {
        return $this->amount;
    }

    public function toInt()
    {
        return $this->amount->toInt();
    }
}
