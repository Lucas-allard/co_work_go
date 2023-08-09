<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Internationalizable\TimezoneAware\TimezoneAware;
use PHPUnit\Framework\TestCase;

final class TimezoneAwareTest extends TestCase
{

    /**
     * @group unit
     * @group timezone-aware
     * @group timezone-aware-create
     * @return void
     */
    public function testItCreatesTimezoneAware(): void
    {
        $timezoneAware = TimezoneAware::create('Europe/Madrid');
        $this->assertEquals('Europe/Madrid', $timezoneAware->getTimezone());
    }

    /**
     * @group unit
     * @group timezone-aware
     * @group timezone-aware-set-timezone
     * @return void
     */
    public function testItSetsTimezone(): void
    {
        $timezoneAware = TimezoneAware::create('Europe/Madrid');
        $timezoneAware->setTimezone('Europe/Paris');
        $this->assertEquals('Europe/Paris', $timezoneAware->getTimezone());
    }

    /**
     * @group unit
     * @group timezone-aware
     * @group timezone-aware-set-timezone-invalid
     * @return void
     */
    public function testItThrowsExceptionWhenSettingInvalidTimezone(): void
    {
        $invalidTimezone = 'invalid';
        $isThrownInvalidTimezoneException = false;
        try {
            TimezoneAware::create('Europe/Madrid')->setTimezone($invalidTimezone);
        } catch (\InvalidArgumentException) {
            $isThrownInvalidTimezoneException = true;
        }

        $this->assertTrue($isThrownInvalidTimezoneException);
    }
}