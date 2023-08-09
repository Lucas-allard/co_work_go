<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Dateable\Dateable;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class DateableTest extends TestCase
{
    /**
     * @group unit
     * @group dateable
     * @group dateable-create
     * @group dateable-create-success
     * @return void
     */
    public function testItCreatesADate(): void
    {
        $dateable = Dateable::create();

        $this->assertNotNull($dateable->getCreatedAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $dateable->getCreatedAt());
    }

    /**
     * @group unit
     * @group dateable
     * @group dateable-update
     * @group dateable-update-success
     * @return void
     */
    public function testItUpdatesADate(): void
    {
        $dateable = Dateable::create();

        $dateable->setUpdatedAt();

        $this->assertNotNull($dateable->getUpdatedAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $dateable->getUpdatedAt());
    }
}