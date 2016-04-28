<?php

namespace Library;

interface LibraryRepository
{
    /**
     * @param string $libraryId
     * @param int    $isbn
     *
     * @return BookAmount
     */
    public function getAmount($libraryId, $isbn);

    public function setAmount($libraryId, BookAmount $amount);
}
