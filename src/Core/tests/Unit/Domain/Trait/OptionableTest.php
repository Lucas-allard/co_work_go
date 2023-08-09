<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Domain\Contract\Optionable\Option;
use Core\Tests\Mock\Domain\Contract\Optionable\Optionable;
use PHPUnit\Framework\TestCase;

final class OptionableTest extends TestCase
{
    /**
     * @group unit
     * @group optionable
     * @group optionable-create
     * @return void
     */
    public function testCreate(): void
    {
        $option = new Option('name', 100);
        $optionable = Optionable::create($option);
        $this->assertEquals($option, $optionable->getOptions()[0]);
    }

    /**
     * @group unit
     * @group optionable
     * @group optionable-add-option
     * @return void
     */
    public function testAddOption(): void
    {
        $option = new Option('name', 100);
        $option2 = new Option('name2', 200);
        $optionable = Optionable::create($option);
        $optionable->addOption($option2);
        $this->assertEquals($option, $optionable->getOptions()[0]);
        $this->assertEquals($option2, $optionable->getOptions()[1]);
    }

    /**
     * @group unit
     * @group optionable
     * @group optionable-remove-option
     * @return void
     */
    public function testRemoveOption(): void
    {
        $option = new Option('name', 100);
        $option2 = new Option('name2', 200);
        $optionable = Optionable::create($option);
        $optionable->addOption($option2);
        $optionable->removeOption($option);
        $this->assertNotContains($option, $optionable->getOptions());
    }

    /**
     * @group unit
     * @group optionable
     * @group optionable-set-options
     * @return void
     */
    public function testSetOptions(): void
    {
        $option = new Option('name', 100);
        $option2 = new Option('name2', 200);
        $option3 = new Option('name3', 300);
        $optionable = Optionable::create($option);
        $optionable->setOptions([$option2, $option3]);
        $this->assertCount(2, $optionable->getOptions());
    }
}