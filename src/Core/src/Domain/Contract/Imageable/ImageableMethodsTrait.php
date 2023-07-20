<?php

namespace Core\Domain\Contract\Imageable;

trait ImageableMethodsTrait
{
    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $url
     * @return static
     */
    public function setImageUrl(?string $url): static
    {
        $this->imageUrl = $url;
        return $this;
    }
}