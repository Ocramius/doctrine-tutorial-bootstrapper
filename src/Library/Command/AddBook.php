<?php

namespace Library\Command;

use Library\Amount;
use Library\ISBN;
use Library\LibraryId;

final class AddBook
{
    /**
     * @var LibraryId
     */
    private $libraryId;

    /**
     * @var ISBN
     */
    private $isbn;

    /**
     * @var Amount
     */
    private $amount;

    public function __construct(
        LibraryId $libraryId,
        ISBN $isbn,
        Amount $amount
    ) {
        $this->libraryId = $libraryId;
        $this->isbn = $isbn;
        $this->amount = $amount;
    }

    /**
     * @return LibraryId
     */
    public function getLibraryId()
    {
        return $this->libraryId;
    }

    /**
     * @return ISBN
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }
}