<?php

namespace Core\Tests\Mock\Domain\Contract\Phoneable;

use Core\Domain\Contract\Phoneable\PhoneableInterface;
use Core\Domain\Contract\Phoneable\PhoneableTrait;

final class Phoneable implements PhoneableInterface
{
    use PhoneableTrait;

    public function __construct(){}

    /**
     * @param string|null $phoneNumber
     * @return self
     */
    static function create(?string $phoneNumber = null): static
    {
       return (new self())
           ->setPhoneNumber($phoneNumber);
    }
}