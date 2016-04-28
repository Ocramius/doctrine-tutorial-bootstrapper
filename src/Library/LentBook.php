<?php

namespace Library;

class LentBook
{
    private $libraryId;
    private $isbn;
    private $userId;
    private $lentDate;
    private $returnedDate;

    public function __construct(
        LibraryId $libraryId,
        ISBN $isbn,
        UserId $userId,
        \DateTimeImmutable $lentDate
    ) {
        $this->libraryId = $libraryId;
        $this->isbn = $isbn;
        $this->userId = $userId;
        $this->lentDate = $lentDate;
    }

    public function return(\DateTimeImmutable $returnDate)
    {
        // $returnDate > $this->lentDate
        // $this->returnDate === null
        $this->returnedDate = $returnDate;
    }
}