<?php

namespace Core\Domain\Contract\Internationalizable\TimezoneAware;

interface TimezoneAwareInterface
{
    /**
     * @return string
     */
    public function getTimezone(): string;

    /**
     * @param string $timezone
     * @return $this
     */
    public function setTimezone(string $timezone): static;
}