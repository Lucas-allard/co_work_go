<?php

namespace Core\Infrastructure\Provider;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Core\Domain\Provider\IdProviderInterface;
use InvalidArgumentException;
use Symfony\Component\Uid\Ulid;

final class UlidProvider implements IdProviderInterface
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