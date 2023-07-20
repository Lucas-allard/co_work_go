<?php

namespace Core\Domain\Contract\Dateable;

use DateTimeInterface;

trait DateablePropertiesTrait
{
    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $createdAt = null;
    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $updatedAt = null;
}