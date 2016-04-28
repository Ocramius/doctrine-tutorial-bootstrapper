<?php

namespace Library;

class Library
{
    private $libraryId;

    /**
     * @var LibraryRepository
     */
    private $repository;

    /**
     * @var UserExclusionPolicy
     */
    private $exclusionPolicy;

    /**
     * @var LentBooksRepository
     */
    private $lentBooks;

    public function __construct(
        LibraryId $libraryId,
        LibraryRepository $repository
        //UserExclusionPolicy $exclusionPolicy,
        //LentBooksRepository $lentBooks
    ) {
        $this->libraryId  = $libraryId;
        $this->repository = $repository;
        //$this->exclusionPolicy = $exclusionPolicy;
        //$this->lentBooks = $lentBooks;
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
        $this->exclusionPolicy->assertUserCanLend($userId, $this->libraryId);

        if (! $amount = $this->getBookAmount($isbn)) {
            throw new \OutOfBoundsException(sprintf('Book "%s" is not available', $isbn));
        }

        if (($amount - $this->lentBooks->countByIsbnAndLibrary($isbn, $this->libraryId)) <= 0) {
            throw new \OutOfBoundsException(sprintf('Book "%s" is currently not available, all books already lent', $isbn));
        }

        $this->lentBooks->add(new LentBook($this->libraryId, $isbn, $userId, $lendStartTime));
    }
}
