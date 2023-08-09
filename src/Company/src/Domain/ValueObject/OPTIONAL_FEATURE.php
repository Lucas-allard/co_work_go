<?php

namespace Company\Domain\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * Action enum
 *
 * @extends Enum<Action::*>
 */
final class OPTIONAL_FEATURE extends Enum
{
    const BILLING = 'billing';
    const MEETING_ROOMS = 'meeting_rooms';
    const HIGH_SPEED_INTERNET = 'high_speed_internet';
    const COWORKING_SPACE = 'coworking_space';
    const PRIVATE_OFFICES = 'private_offices';
    const EVENT_SPACE = 'event_space';
    const VIRTUAL_OFFICE = 'virtual_office';

    public static function Billing(): OPTIONAL_FEATURE
    {
        return new self(self::BILLING);
    }

    public static function MeetingRooms(): OPTIONAL_FEATURE
    {
        return new self(self::MEETING_ROOMS);
    }

    public static function HighSpeedInternet(): OPTIONAL_FEATURE
    {
        return new self(self::HIGH_SPEED_INTERNET);
    }

    public static function CoworkingSpace(): OPTIONAL_FEATURE
    {
        return new self(self::COWORKING_SPACE);
    }

    public static function PrivateOffices(): OPTIONAL_FEATURE
    {
        return new self(self::PRIVATE_OFFICES);
    }

    public static function EventSpace(): OPTIONAL_FEATURE
    {
        return new self(self::EVENT_SPACE);
    }

    public static function VirtualOffice(): OPTIONAL_FEATURE
    {
        return new self(self::VIRTUAL_OFFICE);
    }
}