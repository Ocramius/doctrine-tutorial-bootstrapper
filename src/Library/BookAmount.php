<?php

namespace Library;

class BookAmount
{
    private $libraryId;
    private $isbn;

    private $amount;

    public function __construct($libraryId, $isbn, $amount)
    {
        $this->libraryId = $libraryId;
        $this->isbn      = $isbn;
        $this->amount    = $amount;
    }

    public function add($amount)
    {
        $this->amount += $amount;

        return $this;
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
