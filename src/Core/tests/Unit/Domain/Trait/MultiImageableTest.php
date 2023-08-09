<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Imageable\MultiImageable\MultiImageable;
use PHPUnit\Framework\TestCase;

final class MultiImageableTest extends TestCase
{
    /**
     * @group unit
     * @group unit
     * @group multi-imageable
     * @group multi-imageable-create
     * @return void
     */
    public function testItCreatesAMultiImageable(): void
    {
        $multiImageable = MultiImageable::create(
            [
                'https://www.google.com',
                'https://www.google.com',
                'https://www.google.com'
            ]
        );

        $this->assertEquals(
            [
                'https://www.google.com',
                'https://www.google.com',
                'https://www.google.com'
            ],
            $multiImageable->getImageUrls()
        );
    }

    /**
     * @group unit
     * @group unit
     * @group multi-imageable
     * @group multi-imageable-set-with-null
     * @return void
     */
    public function testItSetsImageUrls(): void
    {
        $multiImageable = MultiImageable::create(
            [
                'https://www.google.com',
                'https://www.google.com',
                'https://www.google.com'
            ]
        );

        $multiImageable->setImageUrls(null);

        $this->assertNull($multiImageable->getImageUrls());
    }
}