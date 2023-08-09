<?php

declare(strict_types=1);

namespace Security\Domain\ValueObject;

use RuntimeException;
use Stringable;

final class HashedPassword implements Stringable
{
    private function __construct(
        private string $hashedPassword
    ) {
    }

    public static function fromString(string $plainPassword): self
    {
        return new self(self::hash($plainPassword));
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    private static function hash(string $plainPassword): string
    {
        /** @var string|false $hashedPassword */
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
        if (is_bool($hashedPassword)) {
            throw new RuntimeException('Server error hashing password.');
        }

        return $hashedPassword;
    }

    public function match(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedPassword);
    }

    private static function checkRequirements(string $plainPassword): bool
    {
        $containsUppercaseChar = preg_match('@[A-Z]@', $plainPassword);
        $containsLowercaseChar = preg_match('@[a-z]@', $plainPassword);
        $containsNumber = preg_match('@[0-9]@', $plainPassword);
        $is8CharLongOrMore = strlen($plainPassword) >= 8;

        $requirements = [$containsUppercaseChar, $containsLowercaseChar, $containsNumber, $is8CharLongOrMore];

        return !in_array(false, $requirements);
    }

    public function __toString()
    {
        return $this->hashedPassword;
    }

    public function setPlainPassword(string $password): self
    {
        $this->hashedPassword = HashedPassword::hash($password);

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return null;
    }
}
