<?php

namespace Core\Domain\Exception;

class InvalidEmailException extends ValidationException
{
    public function __construct(string $email)
    {
        parent::__construct("Invalid email format: {$email}");
    }
}