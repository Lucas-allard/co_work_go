<?php

namespace Core\Domain\Contract\Ulidable;

use Core\Domain\Provider\UlidProvider;

trait UlidableMethodsTrait
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return static
     */
    private function setId(string $id): static
    {
        UlidProvider::assertValidId($id);
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getId();
    }
}