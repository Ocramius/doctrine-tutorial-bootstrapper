<?php

namespace LibraryTest;

use Library\Amount;
use Library\BookAmount;
use Library\Library;
use Library\LibraryId;
use Library\LibraryRepository;
use Ramsey\Uuid\Uuid;

class LibraryTest extends \PHPUnit_Framework_TestCase
{
    public function testWillAddBooksToTheLibrary()
    {
        $libraryId         = (string) Uuid::uuid4();
        /* @var $libraryRepository LibraryRepository|\PHPUnit_Framework_MockObject_MockObject */
        $libraryRepository = $this->getMock(LibraryRepository::class);

        $library = new Library(LibraryId::fromString($libraryId), $libraryRepository);

        $isbn           = mt_rand(1234567890000, 1234567890123);
        $previousAmount = mt_rand(100, 200);
        $amount         = mt_rand(100, 200);

        $libraryRepository
            ->expects(self::any())
            ->method('getAmount')
            ->with($libraryId, $isbn)
            ->willReturn(new BookAmount(LibraryId::fromString($libraryId), $isbn, Amount::fromInteger($previousAmount)));
        $libraryRepository->expects(self::once())->method('setAmount')->with(
            $libraryId,
            self::callback(function (BookAmount $setAmount) use ($previousAmount, $amount, $isbn) {
                self::assertSame($previousAmount + $amount, $setAmount->toInt());
                self::assertEquals($isbn, $setAmount->getIsbn());

                return true;
            })
        );

        $library->addBook($isbn, Amount::fromInteger($amount));
    }

    public function testWillGetBooksFromTheLibrary()
    {
        $libraryId         = (string) Uuid::uuid4();
        /* @var $libraryRepository LibraryRepository|\PHPUnit_Framework_MockObject_MockObject */
        $libraryRepository = $this->getMock(LibraryRepository::class);

        $library = new Library(LibraryId::fromString($libraryId), $libraryRepository);

        $isbn   = mt_rand(1234567890000, 1234567890123);
        $amount = mt_rand(100, 200);
        
        $bookAmount = new BookAmount(LibraryId::fromString($libraryId), $isbn, Amount::fromInteger($amount));

        $libraryRepository->expects(self::any())->method('getAmount')->with($libraryId, $isbn)->willReturn($bookAmount);

        self::assertSame($amount, $library->getBookAmount($isbn, $amount));
    }
}
