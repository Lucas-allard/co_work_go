<?php

namespace Core\Domain\Contract\Dateable;

use DateTimeImmutable;
use DateTimeInterface;

trait DateableMethodsTrait
{
    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return $this
     */
    public function setCreatedAt(): static
    {
        $this->createdAt = new DateTimeImmutable;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return $this
     */
    public function setUpdatedAt(): static
    {
        $this->updatedAt = new DateTimeImmutable;
        return $this;
    }
}