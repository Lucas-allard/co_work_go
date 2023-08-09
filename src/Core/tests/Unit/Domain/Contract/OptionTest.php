<?php

namespace Core\Tests\Unit\Domain\Contract;

use Core\Domain\Contract\Optionable\Option;
use PHPUnit\Framework\TestCase;

final class OptionTest extends TestCase
{
    /**
     * @group unit
     * @group option
     * @group option-json-serialize
     * @return void
     */
    public function testJsonSerialize(): void
    {
        $option = new Option('name', 100);
        $this->assertEquals('{"name":"name","price":100}', json_encode($option));
    }

    /**
     * @group unit
     * @group option
     * @group option-to-string
     * @return void
     */
    public function testToString(): void
    {
        $option = new Option('name', 100);
        $this->assertEquals('{"name":"name","price":100}', (string)$option);
    }

    /**
     * @group unit
     * @group option
     * @group option-from-json
     * @return void
     */
    public function testFromJson(): void
    {
        $option = new Option('name', 100);
        $json = '{"name":"name","price":100}';
        $this->assertEquals($option, Option::fromJson(json_decode($json)));
    }
}