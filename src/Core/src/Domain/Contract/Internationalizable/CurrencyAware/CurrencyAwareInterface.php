<?php

namespace Core\Domain\Contract\Internationalizable\CurrencyAware;
interface CurrencyAwareInterface
{
    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @param string $currency
     * @return static
     */
    public function setCurrency(string $currency): static;
}