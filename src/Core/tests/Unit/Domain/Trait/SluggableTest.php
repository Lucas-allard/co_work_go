<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Sluggable\Sluggable;
use PHPUnit\Framework\TestCase;

final class SluggableTest extends TestCase
{
    /**
     * @group unit
     * @group sluggable
     * @group sluggable-set-slug
     * @return void
     */
    public function testSetSlug(): void
    {
        $sluggable = Sluggable::create('name');
        $this->assertEquals('name', $sluggable->getSlug());
    }
}