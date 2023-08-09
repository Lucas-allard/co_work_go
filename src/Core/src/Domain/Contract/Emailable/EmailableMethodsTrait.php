<?php

namespace Core\Domain\Contract\Emailable;

use Core\Domain\Exception\InvalidEmailException;
use Core\Tests\Mock\Emailable;

trait EmailableMethodsTrait
{
    /**
     * @param string $email
     * @return bool
     */
    private static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return self
     */
    public function setEmail(?string $email): static
    {
        if ($email !== null && !self::validateEmail($email)) {
            throw new InvalidEmailException($email);
        }

        $this->email = $email;

        return $this;
    }

}