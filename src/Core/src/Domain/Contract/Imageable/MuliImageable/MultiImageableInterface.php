<?php

namespace Core\Domain\Contract\Imageable\MuliImageable;

interface MultiImageableInterface
{
    /**
     * @return string[]|null
     */
    function getImageUrls(): ?array;

    /**
     * @param string[]|null $urls
     * @return static
     */
    function setImageUrls(?array $urls): static;
}