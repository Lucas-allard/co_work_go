<?php

namespace Core\Domain\Contract\Sluggable;

interface SluggableInterface
{
    /**
     * @return string
     */
    public function getSlug(): string;

    public function getSluggableFields(): array;
}