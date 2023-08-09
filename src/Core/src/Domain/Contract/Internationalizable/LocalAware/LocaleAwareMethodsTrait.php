<?php

namespace Core\Domain\Contract\Internationalizable\LocalAware;

use Assert\Assertion;
use Assert\AssertionFailedException;
use InvalidArgumentException;
use Symfony\Component\Intl\Locales;
trait LocaleAwareMethodsTrait
{
    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return static
     */
    public function setLocale(string $locale): static
    {
       try {
            Assertion::true(Locales::exists($locale));
        } catch (AssertionFailedException) {
            throw new InvalidArgumentException("Invalid Locale code : $locale");
        }
        $this->locale = $locale;

        return $this;
    }
}