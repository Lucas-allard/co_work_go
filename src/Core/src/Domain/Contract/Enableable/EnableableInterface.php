<?php

namespace Core\Domain\Contract\Enableable;

interface EnableableInterface
{
    /**
     * @return bool
     */
    public function disable(): bool;

    /**
     * @return $this
     */
    public function enable(): static;

    /**
     * @return $this
     */
    public function toggleEnabled(): static;
}