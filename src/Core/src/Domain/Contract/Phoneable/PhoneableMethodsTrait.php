<?php

namespace Core\Domain\Contract\Phoneable;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Core\Domain\Exception\InvalidPhoneNumberException;

trait PhoneableMethodsTrait
{
    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phoneNumber
     * @return bool
     */
    public function validePhoneNumber(string $phoneNumber): bool
    {
        try {
            Assertion::e164($phoneNumber);
            return true;
        } catch (AssertionFailedException) {
            return false;
        }
    }

    /**
     * @throws InvalidPhoneNumberException
     */
    public function setPhoneNumber(?string $phoneNumber): static
    {
        if (is_string($phoneNumber)) {
            if (!$this->validePhoneNumber($phoneNumber)) {
                throw new InvalidPhoneNumberException;
            }
        }
        $this->phone = $phoneNumber;

        return $this;
    }

}