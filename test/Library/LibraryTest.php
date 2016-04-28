<?php

namespace LibraryTest;

use Library\BookAmount;
use Library\Library;
use Library\LibraryRepository;
use Ramsey\Uuid\Uuid;

class LibraryTest extends \PHPUnit_Framework_TestCase
{
    public function testWillAddBooksToTheLibrary()
    {
        $libraryId         = (string) Uuid::uuid4();
        /* @var $libraryRepository LibraryRepository|\PHPUnit_Framework_MockObject_MockObject */
        $libraryRepository = $this->getMock(LibraryRepository::class);

        $library = new Library($libraryId, $libraryRepository);

        $isbn           = mt_rand(1234567890000, 1234567890123);
        $previousAmount = mt_rand(100, 200);
        $amount         = mt_rand(100, 200);

        $libraryRepository
            ->expects(self::any())
            ->method('getAmount')
            ->with($libraryId, $isbn)
            ->willReturn(new BookAmount($libraryId, $isbn, $previousAmount));
        $libraryRepository->expects(self::once())->method('setAmount')->with(
            $libraryId,
            self::callback(function (BookAmount $setAmount) use ($previousAmount, $amount, $isbn) {
                self::assertSame($previousAmount + $amount, $setAmount->toInt());
                self::assertSame($isbn, $setAmount->getIsbn());

                return true;
            })
        );

        $library->addBook($isbn, $amount);
    }

    public function testWillGetBooksFromTheLibrary()
    {
        $libraryId         = (string) Uuid::uuid4();
        /* @var $libraryRepository LibraryRepository|\PHPUnit_Framework_MockObject_MockObject */
        $libraryRepository = $this->getMock(LibraryRepository::class);

        $library = new Library($libraryId, $libraryRepository);

        $isbn   = mt_rand(1234567890000, 1234567890123);
        $amount = mt_rand(100, 200);
        
        $bookAmount = new BookAmount($libraryId, $isbn, $amount);

        $libraryRepository->expects(self::any())->method('getAmount')->with($libraryId, $isbn)->willReturn($bookAmount);

        self::assertSame($amount, $library->getBookAmount($isbn, $amount));
    }
}
