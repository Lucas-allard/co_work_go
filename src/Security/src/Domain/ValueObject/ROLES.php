<?php

namespace Security\Domain\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * Action enum
 *
 * @extends Enum<Action::*>
 */
final class ROLES extends Enum
{
    private const Administrator = 'ROLE_ADMINISTRATOR';
    private const Merchant = 'ROLE_MERCHANT';
    public static function Administrator(): ROLES
    {
        return new ROLES(self::Administrator);
    }

    public static function Merchant(): ROLES
    {
        return new self(self::Merchant);
    }
}