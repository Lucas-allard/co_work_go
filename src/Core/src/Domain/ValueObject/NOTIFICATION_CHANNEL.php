<?php

namespace Core\Domain\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * Action enum
 *
 * @extends Enum<Action::*>
 */
final class NOTIFICATION_CHANNEL extends Enum
{
    private const Null = 'NULL';
    private const Sms = 'SMS';
    private const Email = 'EMAIL';
    private const SmsAndEmail = 'SMS&EMAIL';
}