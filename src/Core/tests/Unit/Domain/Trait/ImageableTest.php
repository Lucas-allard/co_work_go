<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Imageable\Imageable;
use PHPUnit\Framework\TestCase;

final class ImageableTest extends TestCase
{
    /**
     * @group unit
     * @group imageable
     * @group imageable-create
     * @group imageable-create-success
     * @return void
     */
    public function testItCreatesAnImageable(): void
    {
        $imageable = Imageable::create('https://www.google.com');

        $this->assertEquals('https://www.google.com', $imageable->getImageUrl());
    }

    /**
     * @group unit
     * @group imageable
     * @group imageable-setter
     * @group imageable-set-with-null
     * @return void
     */
    public function testItSetsAnImageUrl(): void
    {
        $imageable = Imageable::create('https://www.google.com');

        $imageable->setImageUrl(null);

        $this->assertNull($imageable->getImageUrl());
    }
}