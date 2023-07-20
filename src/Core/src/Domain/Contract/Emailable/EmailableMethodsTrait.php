<?php

namespace Core\Domain\Contract\Emailable;

use Core\Domain\Exception\InvalidEmailException;

trait EmailableMethodsTrait
{
    /**
     * @param string $email
     * @return mixed
     */
    private static function validateEmail(string $email)
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
     * @return void
     */
    public function setEmail(?string $email): void
    {
        if ($email !== null && !self::validateEmail($email)) {
            throw new InvalidEmailException($email);
        }

        $this->email = $email;
    }

}