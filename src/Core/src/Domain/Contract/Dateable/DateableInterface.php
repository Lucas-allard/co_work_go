<?php

namespace Core\Domain\Contract\Dateable;

use DateTimeInterface;

interface DateableInterface
{
    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface;

    /**
     * @return $this
     */
    public function setCreatedAt(): static;

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface;

    /**
     * @return $this
     */
    public function setUpdatedAt(): static;
}