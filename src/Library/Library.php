<?php

namespace Library;

class Library
{
    private $libraryId;

    /**
     * @var LibraryRepository
     */
    private $repository;

    public function __construct(LibraryId $libraryId, LibraryRepository $repository)
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

    public function lend(ISBN $isbn, UserId $userId, \DateTimeImmutable $lendStartTime)
    {
        // ... check if the user is allowed (quota)
        // ... check if inventory has book (also compute other lent books)
        // create "lent" track, log at which time the book was given to the user
    }
}
