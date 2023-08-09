<?php

namespace Core\Domain\Exception;

class InvalidPhoneNumberException extends ValidationException
{
    /**
     * @param string $phoneNumber
     */
    public  function __construct(string $phoneNumber)
    {
        parent::__construct("Invalid phone number format: {$phoneNumber}");
    }
}