<?php
declare(strict_types=1);

namespace Core\Infrastructure\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EnumType extends Type
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        return sprintf("%s@%s",
            $value::class,
            $value->getValue()
        );
    }


    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }
        [$class,$value] = explode('@',$value);

        return $class::from($value);
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function getName()
    {
        return 'enum';
    }
}