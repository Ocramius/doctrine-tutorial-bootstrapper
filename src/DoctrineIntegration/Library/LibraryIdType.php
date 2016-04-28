<?php

namespace DoctrineIntegration\Library;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Library\LibraryId;

final class LibraryIdType extends GuidType
{
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return LibraryId::fromString(parent::convertToPHPValue($value, $platform));
    }

    /**
     * {@inheritDoc}
     *
     * @param $value LibraryId
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValueSQL((string) $value, $platform);
    }
}
