<?php

namespace LibraryTest;

use Library\ISBN;

class ISBNTest extends \PHPUnit_Framework_TestCase
{
    public function testWithValidIsbn()
    {
        $intIsbn = mt_rand(1234567890000, 1234567890123);

        $isbn = ISBN::fromInt($intIsbn);

        self::assertInstanceOf(ISBN::class, $isbn);
        self::assertEquals($isbn, ISBN::fromString((string) $intIsbn));
        self::assertSame((string) $intIsbn, (string) $isbn);
    }

    /**
     * @dataProvider invalidIntIsbnProvider
     *
     * @param mixed $invalidIsbn
     */
    public function testWithInvalidIntISBN($invalidIsbn)
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        ISBN::fromInt($invalidIsbn);
    }

    /**
     * @dataProvider invalidIntIsbnProvider
     *
     * @param mixed $invalidIsbn
     */
    public function testWithInvalidString($invalidIsbn)
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        ISBN::fromString((string) $invalidIsbn);
    }

    public function invalidIntIsbnProvider()
    {
        return [
            [999999999999],
            [10000000000000],
            ['aaaaaaaaaaaaa'],
        ];
    }
}
