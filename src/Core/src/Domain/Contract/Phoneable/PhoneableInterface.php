<?php

namespace Core\Domain\Contract\Phoneable;

interface PhoneableInterface
{
    /**
     * @return string
     */
    public function getPhoneNumber(): string;
}