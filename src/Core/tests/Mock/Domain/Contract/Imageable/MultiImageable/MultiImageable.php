<?php

namespace Core\Tests\Mock\Domain\Contract\Imageable\MultiImageable;

use Core\Domain\Contract\Imageable\MuliImageable\MultiImageableInterface;
use Core\Domain\Contract\Imageable\MuliImageable\MultiImageableMethodsTrait;

final class MultiImageable implements MultiImageableInterface
{
    use MultiImageableMethodsTrait;

    public function __construct(){}

    /**
     * @param string|null ...$imageUrl
     * @return self
     */
    static function create(?array $imageUrl): self
    {
        return (new self())
            ->setImageUrls($imageUrl);
    }
}