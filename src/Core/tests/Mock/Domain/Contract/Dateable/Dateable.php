<?php

namespace Core\Tests\Mock\Domain\Contract\Dateable;

use Core\Domain\Contract\Dateable\DateableInterface;
use Core\Domain\Contract\Dateable\DateableMethodsTrait;

final class Dateable implements DateableInterface
{
    use DateableMethodsTrait;

    public function __construct(){}

    /**
     * @return self
     */
    static function create(): self
    {
        return (new self())
            ->setCreatedAt();
    }
}