<?php

namespace Core\Tests\Mock\Domain\Contract\Ulidable;

use Core\Domain\Contract\Ulidable\UlidableInterface;
use Core\Domain\Contract\Ulidable\UlidableMethodsTrait;

final class Ulidable implements UlidableInterface
{
    use UlidableMethodsTrait;

    public function __construct()
    {
    }

    static function create(string $id): Ulidable
    {
        return (new self())
            ->setId($id);
    }
}