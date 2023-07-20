<?php

namespace Core\Domain\Contract\Enableable;

trait EnableableMethodsTrait
{

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function disable(): bool
    {
        $this->enabled = false;
        return $this->enabled;
    }

    /**
     * @return $this
     */
    public function enable(): static
    {
        $this->enabled = true;
        return $this;
    }

    /**
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return $this
     */
    public function toggleEnabled(): static
    {
        $this->enabled = !$this->enabled;
        return $this;
    }
}