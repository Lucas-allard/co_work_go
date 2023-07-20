<?php

namespace Core\Domain\Contract\Imageable\MultipleImageable;

trait MultipleImageableMethodsTrait
{
    /**
     * @return array|null
     */
    public function getImageUrls(): ?array
    {
        return $this->imageUrls;
    }

    /**
     * @param array|null $imageUrls
     * @return static
     */
    public function setImageUrls(?array $imageUrls): static
    {
        $this->imageUrls = $imageUrls;
        return $this;
    }
}