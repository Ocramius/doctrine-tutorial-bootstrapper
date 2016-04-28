<?php

namespace Library;

interface LibraryRepository
{
    /**
     * @param LibraryId $libraryId
     * @param int       $isbn
     *
     * @return BookAmount
     */
    public function getAmount(LibraryId $libraryId, $isbn);

    public function setAmount(LibraryId $libraryId, BookAmount $amount);
}
