<?php

namespace Core\Tests\Mock\Domain\Contract\Imageable;

use Core\Domain\Contract\Imageable\ImageableInterface;
use Core\Domain\Contract\Imageable\ImageableMethodsTrait;

final class Imageable implements ImageableInterface
{
    use ImageableMethodsTrait;

    public function __construct(){}

    /**
     * @param string|null $imageUrl
     * @return self
     */
    static function create(?string $imageUrl): self
    {
        return (new self())
            ->setImageUrl($imageUrl);
    }
}