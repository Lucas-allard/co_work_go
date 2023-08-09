<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Internationalizable\LocaleAware\LocaleAware;
use PHPUnit\Framework\TestCase;

final class LocaleAwareTest extends TestCase
{
    /**
     * @group unit
     * @group locale-aware
     * @group locale-aware-create
     * @return void
     */
    public function testItCreatesLocaleAware(): void
    {
        $localeAware = LocaleAware::create('en');
        $this->assertEquals('en', $localeAware->getLocale());
    }

    /**
     * @group unit
     * @group locale-aware
     * @group locale-aware-set-locale
     * @return void
     */

    public function testItSetsLocale(): void
    {
        $localeAware = LocaleAware::create('en');
        $localeAware->setLocale('es');
        $this->assertEquals('es', $localeAware->getLocale());
    }

    /**
     * @group unit
     * @group locale-aware
     * @group locale-aware-set-locale-invalid
     * @return void
     */
    public function testItThrowsExceptionWhenSettingInvalidLocale(): void
    {
        $invalidLocale = 'invalid';
        $isThrownInvalidLocaleException = false;
        try {
            LocaleAware::create('en')->setLocale($invalidLocale);
        } catch (\InvalidArgumentException) {
            $isThrownInvalidLocaleException = true;
        }

        $this->assertTrue($isThrownInvalidLocaleException);
    }
}