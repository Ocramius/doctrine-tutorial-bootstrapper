<?php

namespace DoctrineIntegration\Library;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use Library\ISBN;

final class ISBNType extends IntegerType
{
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return ISBN::fromInt(parent::convertToPHPValue($value, $platform));
    }

    /**
     * {@inheritDoc}
     *
     * @param $value ISBN
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValueSQL((string) $value, $platform);
    }
}
