<?php

namespace Library;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

// @TODO implement ISBN-C
final class ISBN
{
    /**
     * @var int
     */
    private $isbn;

    private function __construct()
    {
    }

    public static function fromInt($intIsbn)
    {
        $instance = new self();

        if (! is_int($intIsbn)) {
            throw new \InvalidArgumentException(sprintf(
                'Provided ISBN expected to be int, %s given',
                gettype($intIsbn)
            ));
        }

        if (13 !== strlen((string) $intIsbn)) {
            throw new \InvalidArgumentException(sprintf(
                'Provided ISBN is supposed to be composed of 13 integers, %s provided instead',
                $intIsbn
            ));
        }

        $instance->isbn = $intIsbn;

        return $instance;
    }

    public static function fromString($stringIsbn)
    {
        return self::fromInt((int) $stringIsbn);
    }

    public function __toString()
    {
        return (string) $this->isbn;
    }
}