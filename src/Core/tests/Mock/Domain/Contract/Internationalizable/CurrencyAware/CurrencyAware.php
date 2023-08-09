<?php

namespace Core\Tests\Mock\Domain\Contract\Internationalizable\CurrencyAware;

use Core\Domain\Contract\Internationalizable\CurrencyAware\CurrencyAwareInterface;
use Core\Domain\Contract\Internationalizable\CurrencyAware\CurrencyAwareMethodsTrait;

final class CurrencyAware implements CurrencyAwareInterface
{
    use CurrencyAwareMethodsTrait;

    public function __construct(){}

    /**
     * @param string|null $currency
     * @return self
     */
    static function create(?string $currency): self
    {
        return (new self())
            ->setCurrency($currency);
    }
}