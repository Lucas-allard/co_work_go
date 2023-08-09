<?php

namespace Core\Tests\Mock\Domain\Contract\Internationalizable\TimezoneAware;

use Core\Domain\Contract\Internationalizable\TimezoneAware\TimezoneAwareInterface;
use Core\Domain\Contract\Internationalizable\TimezoneAware\TimezoneAwareMethodsTrait;

final class TimezoneAware implements TimezoneAwareInterface
{
    use TimezoneAwareMethodsTrait;

    public function __construct(){}

    /**
     * @param string|null $timezone
     * @return self
     */
    static function create(?string $timezone): self
    {
        return (new self())
            ->setTimezone($timezone);
    }
}