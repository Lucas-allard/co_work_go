<?php

namespace Core\Tests\Mock\Domain\Contract\Sluggable;

use Core\Domain\Contract\Sluggable\SluggableInterface;
use Core\Domain\Contract\Sluggable\SluggableMethodsTrait;

final class Sluggable implements SluggableInterface
{
    use SluggableMethodsTrait;

    public function __construct(){}

    public function getSluggableFields(): array
    {
        return ['name'];
    }

    static function create(string $name): Sluggable
    {
        return (new self())
            ->setSlug($name);
    }
}