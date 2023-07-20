<?php

namespace Core\Domain\Provider;

use Assert\AssertionFailedException;
use InvalidArgumentException;
use Symfony\Component\Uid\Ulid;
use Assert\Assertion;

final class UlidProvider
{
    public function generate(): string
    {
        return (string) new Ulid();
    }

    static function staticGenerate(): string
    {
        return (string) new Ulid();
    }

    static function assertValidId(string $id): void
    {
        try {
            Assertion::true(Ulid::isValid($id));
        } catch (AssertionFailedException) {
            throw new InvalidArgumentException("Invalid Ulid.");
        }
    }
}