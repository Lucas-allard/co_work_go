<?php

namespace Core\Tests\Mock\Domain\Contract\Emailable;

use Core\Domain\Contract\Emailable\EmailableInterface;
use Core\Domain\Contract\Emailable\EmailableTrait;

final class Emailable implements EmailableInterface
{
    use EmailableTrait;
    public function __construct()
    {
    }

    /**
     * @param string $email
     * @return self
     */
    static function create(string $email): self
    {
        return (new self())
            ->setEmail($email);
    }
}