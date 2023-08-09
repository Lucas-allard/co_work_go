<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Enableable\Enableable;
use PHPUnit\Framework\TestCase;

final class EnableableTest extends TestCase
{
    /**
     * @group unit
     * @group enableable
     * @group enableable-creation
     * @return void
     */
    public function testItCreatesAnEnableable(): void
    {
        $enableable = Enableable::create();
        $this->assertTrue($enableable->isEnabled());
    }

    /**
     * @group unit
     * @group enableable
     * @group enableable-disable
     * @return void
     */
    public function testItDisablesAnEnableable(): void
    {
        $enableable = Enableable::create();
        $enableable->disable();
        $this->assertFalse($enableable->isEnabled());
    }

    /**
     * @group unit
     * @group enableable
     * @group enableable-setter
     * @return void
     */
    public function testItSetsAnEnableable(): void
    {
        $enableable = Enableable::create();
        $enableable->setEnabled(false);
        $this->assertFalse($enableable->isEnabled());
    }

    /**
     * @group unit
     * @group enableable
     * @group enableable-toggle
     * @return void
     */
    public function testItTogglesAnEnableable(): void
    {
        $enableable = Enableable::create();
        $enableable->toggleEnabled();
        $this->assertFalse($enableable->isEnabled());

        $enableable->toggleEnabled();
        $this->assertTrue($enableable->isEnabled());
    }
}