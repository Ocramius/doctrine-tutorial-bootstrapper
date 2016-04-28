<?php

namespace LibraryTest;

use Library\Amount;

class AmountTest extends \PHPUnit_Framework_TestCase
{
    public function testAmount()
    {
        $intAmount = mt_rand(100, 200);

        $amount = Amount::fromInteger($intAmount);

        self::assertInstanceOf(Amount::class, $amount);
        self::assertEquals($amount, Amount::fromInteger($intAmount));
        self::assertSame($intAmount, $amount->toInt());
    }

    public function testRejectsNonIntAmounts()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        Amount::fromInteger('foo');
    }

    public function testRejectsZeroAmount()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        Amount::fromInteger(0);
    }

    public function testRejectsNegativeAmount()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        Amount::fromInteger(-1);
    }
}
