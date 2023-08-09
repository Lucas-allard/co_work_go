<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Infrastructure\Provider\UlidProvider;
use Core\Tests\Mock\Domain\Contract\Ulidable\Ulidable;
use PHPUnit\Framework\TestCase;

final class UlidableTest extends TestCase
{
    /**
     * @group unit
     * @group ulidable
     * @group ulidable-create
     * @return void
     */
    public function testCreate(): void
    {
        $ulid = UlidProvider::staticGenerate();
        $ulidable = Ulidable::create($ulid);
        $this->assertEquals($ulid, $ulidable->getId());
    }

    /**
     * @group unit
     * @group ulidable
     * @group ulidable-to-string
     * @return void
     */
    public function testToString(): void
    {
        $ulid = UlidProvider::staticGenerate();
        $ulidable = Ulidable::create($ulid);
        $this->assertEquals($ulid, $ulidable->__toString());
    }
}