<?php

namespace Core\Domain\Contract\Emailable;

trait EmailablePropertiesTrait
{
    /**
     * @var string|null
     */
    private ?string $email = null;
}