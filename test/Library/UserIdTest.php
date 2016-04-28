<?php

namespace LibraryTest;

use Library\UserId;

class UserIdTest extends \PHPUnit_Framework_TestCase
{
    public function testFromString()
    {
        $uuid = '98bc9e7e-6afc-43d2-b03e-49e775974156';

        $userId = UserId::fromString($uuid);

        self::assertEquals($userId, UserId::fromString($uuid));
        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame($uuid, (string) $userId);
    }
}
