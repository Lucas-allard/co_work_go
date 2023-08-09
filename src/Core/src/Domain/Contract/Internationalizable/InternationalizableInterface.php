<?php

namespace Core\Domain\Contract\Internationalizable;

use Core\Domain\Contract\Internationalizable\CurrencyAware\CurrencyAwareInterface;
use Core\Domain\Contract\Internationalizable\LocalAware\LocaleAwareInterface;
use Core\Domain\Contract\Internationalizable\TimezoneAware\TimezoneAwareInterface;
interface InternationalizableInterface extends CurrencyAwareInterface, LocaleAwareInterface, TimezoneAwareInterface
{

}