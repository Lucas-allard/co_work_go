<?php

namespace Core\Domain\Contract\Internationalizable;

use Core\Domain\Contract\Internationalizable\CurrencyAware\CurrencyAwareTrait;
use Core\Domain\Contract\Internationalizable\LocalAware\LocaleAwareTrait;
use Core\Domain\Contract\Internationalizable\TimezoneAware\TimezoneAwareTrait;

trait InternationalizableTrait
{
    use CurrencyAwareTrait;
    use LocaleAwareTrait;
    use TimezoneAwareTrait;
}