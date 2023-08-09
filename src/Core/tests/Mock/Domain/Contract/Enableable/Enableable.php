<?php

namespace Core\Tests\Mock\Domain\Contract\Enableable;

use Core\Domain\Contract\Enableable\EnableableInterface;
use Core\Domain\Contract\Enableable\EnableableMethodsTrait;

final class Enableable implements EnableableInterface
{
    use enableableMethodsTrait;

    public function __construct(){}

    /**
     * @return self
     */
    static function create(): self
    {
        return (new self())
            ->enable();
    }
}