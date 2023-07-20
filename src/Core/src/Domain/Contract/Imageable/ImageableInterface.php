<?php

namespace Core\Domain\Contract\Imageable;

interface ImageableInterface
{
    /**
     * @return string|null
     */
    public function getImageUrl(): ?string;

    /**
     * @param string|null $url
     * @return $this
     */
    public function setImageUrl(?string $url): static;

}