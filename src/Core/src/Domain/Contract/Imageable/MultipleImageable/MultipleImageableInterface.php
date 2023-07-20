<?php

namespace Core\Domain\Contract\Imageable\MultipleImageable;

interface MultipleImageableInterface
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