<?php

namespace Library;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class LibraryId
{
    /**
     * @var UuidInterface
     */
    private $id;

    private function __construct()
    {
    }

    public static function newLibraryId()
    {
        $instance = new self();

        $instance->id = Uuid::uuid4();

        return $instance;
    }

    public static function fromString($stringId)
    {
        $instance = new self();

        $instance->id = Uuid::fromString($stringId);

        return $instance;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}