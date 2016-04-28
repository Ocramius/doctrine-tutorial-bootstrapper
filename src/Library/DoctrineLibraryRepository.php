<?php

namespace Library;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class DoctrineLibraryRepository implements LibraryRepository
{
    /**
     * @var ObjectRepository
     */
    private $bookAmountRepository;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(
        ObjectRepository $bookAmountRepository,
        ObjectManager $objectManager
    ) {
        $this->bookAmountRepository = $bookAmountRepository;
        $this->objectManager        = $objectManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getAmount(LibraryId $libraryId, $isbn)
    {
        return $this->getOrCreateAmount($libraryId, $isbn);
    }

    public function setAmount(LibraryId $libraryId, BookAmount $amount)
    {
        $this->objectManager->persist($amount);
        $this->objectManager->flush();
    }

    private function getOrCreateAmount(LibraryId $libraryId, $isbn)
    {
        $bookAmount = $this->bookAmountRepository->findOneBy([
            'libraryId' => $libraryId,
            'isbn'      => $isbn,
        ]);

        return $bookAmount instanceof BookAmount
            ? $bookAmount
            : new BookAmount($libraryId, $isbn, Amount::fromInteger(0));
    }
}
