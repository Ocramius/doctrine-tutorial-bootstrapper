<?php

namespace Library;

class Library
{
    private $libraryId;

    /**
     * @var LibraryRepository
     */
    private $repository;

    public function __construct($libraryId, LibraryRepository $repository)
    {
        $this->libraryId  = $libraryId;
        $this->repository = $repository;
    }

    public function addBook($isbn, $amount)
    {
        $currentAmount = $this->repository->getAmount($this->libraryId, $isbn);

        $this->repository->setAmount($this->libraryId, $currentAmount->add($amount));
    }

    public function getBookAmount($isbn)
    {
        return $this->repository->getAmount($this->libraryId, $isbn)->toInt();
    }
}
