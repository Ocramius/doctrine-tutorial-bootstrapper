<?php

namespace LibraryTest;

use Library\LibraryId;

class LibraryIdTest extends \PHPUnit_Framework_TestCase
{
    public function testNewLibraryId()
    {
        $libraryId = LibraryId::newLibraryId();

        self::assertInstanceOf(LibraryId::class, $libraryId);
        self::assertNotEquals($libraryId, LibraryId::newLibraryId());
        self::assertEquals($libraryId, LibraryId::fromString((string) $libraryId));
    }

    public function testFromString()
    {
        $uuid = '98bc9e7e-6afc-43d2-b03e-49e775974156';

        $libraryId = LibraryId::fromString($uuid);

        self::assertInstanceOf(LibraryId::class, $libraryId);
        self::assertSame($uuid, (string) $libraryId);
    }
}
