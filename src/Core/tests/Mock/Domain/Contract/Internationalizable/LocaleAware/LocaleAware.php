<?php

namespace Core\Tests\Mock\Domain\Contract\Internationalizable\LocaleAware;

use Core\Domain\Contract\Internationalizable\LocalAware\LocaleAwareInterface;
use Core\Domain\Contract\Internationalizable\LocalAware\LocaleAwareMethodsTrait;

final class LocaleAware implements LocaleAwareInterface
{
    use LocaleAwareMethodsTrait;

    public function __construct(){}

    /**
     * @param string|null $locale
     * @return self
     */
    static function create(?string $locale): self
    {
        return (new self())
            ->setLocale($locale);
    }


}