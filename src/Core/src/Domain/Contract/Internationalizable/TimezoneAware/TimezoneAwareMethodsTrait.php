<?php

namespace Core\Domain\Contract\Internationalizable\TimezoneAware;

use Assert\Assertion;
use Assert\AssertionFailedException;
use InvalidArgumentException;
use Symfony\Component\Intl\Timezones;

trait TimezoneAwareMethodsTrait
{
    public function setTimezone(string $timezone): static
    {
        try {
            Assertion::true(Timezones::exists($timezone));
        } catch (AssertionFailedException) {
            throw new InvalidArgumentException("Invalid Timezone code : $timezone");
        }
        $this->timezone = $timezone;

        return $this;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }
}