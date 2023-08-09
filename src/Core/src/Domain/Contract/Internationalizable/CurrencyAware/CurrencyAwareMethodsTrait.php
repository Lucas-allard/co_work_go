<?php

namespace Core\Domain\Contract\Internationalizable\CurrencyAware;

use Assert\Assertion;
use Assert\AssertionFailedException;
use InvalidArgumentException;
use Symfony\Component\Intl\Currencies;

trait CurrencyAwareMethodsTrait
{

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency(string $currency): static
    {
        try {
            Assertion::true(Currencies::exists($currency));
        } catch (AssertionFailedException) {
            throw new InvalidArgumentException("Invalid Currency code : $currency");
        }
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}