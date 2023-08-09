<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Internationalizable\CurrencyAware\CurrencyAware;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CurrencyAwareTest extends TestCase
{
    /**
     * @group unit
     * @group currency-aware
     * @group currency-aware-create
     */
    public function testItCreatesCurrencyAware(): void
    {
        $currencyAware = CurrencyAware::create('EUR');

        $this->assertEquals('EUR', $currencyAware->getCurrency());
    }

    /**
     * @group unit
     * @group currency-aware
     * @group currency-aware-create-with-invalid-currency
     */
    public function testItCreatesCurrencyAwareWithInvalidCurrency(): void
    {
        $invalidCurrency = 'invalid-currency';
        $isThrownInvalidCurrencyException = false;
        try {
            CurrencyAware::create($invalidCurrency);
        } catch (InvalidArgumentException $e) {
            $isThrownInvalidCurrencyException = true;
            $this->assertEquals("Invalid Currency code : $invalidCurrency", $e->getMessage());
        } finally {
            $this->assertTrue($isThrownInvalidCurrencyException);
        }
    }

}