<?php

namespace Core\Tests\Unit\Domain\Provider;

use Core\Infrastructure\Provider\UlidProvider;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UlidProviderTest extends TestCase
{
    /**
     * @group unit
     * @group ulid
     * @group ulid-generate
     * @return void
     */
    public function testGenerate(): void
    {
        $ulidProvider = new UlidProvider();
        $ulid = $ulidProvider->generate();

        $this->assertNotNull($ulid);
        $this->assertIsString($ulid);
    }

    /**
     * @group unit
     * @group ulid
     * @group ulid-generate-static
     * @return void
     */
    public function testGenerateStatic(): void
    {
        $ulid = UlidProvider::staticGenerate();

        $this->assertNotNull($ulid);
        $this->assertIsString($ulid);
    }

    /**
     * @group unit
     * @group ulid
     * @group ulid-assert-not-valid-id
     * @return void
     */
    public function testAssertNotValidId(): void
    {
        $ulidProvider = new UlidProvider();
        $ulid = 'invalid-ulid';
        $isThrownInvalidArgumentException = false;

        try {
            $ulidProvider->assertValidId($ulid);
        } catch (InvalidArgumentException) {
            $isThrownInvalidArgumentException = true;
        }

        $this->assertTrue($isThrownInvalidArgumentException);
    }
}