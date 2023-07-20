<?php

namespace Core\Domain\Contract\Emailable;

interface EmailableInterface
{
    /**
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * @return $this
     */
    public function setEmail(string $email): static;
}