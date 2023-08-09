<?php

namespace Core\Infrastructure\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use SplObjectStorage;

class StorageType extends Type
{
    /**
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ?string
    {
        if ($value === null) {
            return null;
        }

        /** @var SplObjectStorage $value */
        $encoded = $value->serialize();

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw ConversionException::conversionFailedSerialization($value, 'json', json_last_error_msg());
        }

        return json_encode($encoded);
    }

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : ?SplObjectStorage
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_resource($value)) {
            $value = stream_get_contents($value);
        }

        $val = new SplObjectStorage;
        $val->unserialize(json_decode($value));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return $val;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform) : string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    public function getName() : string
    {
        return 'storage';
    }
}