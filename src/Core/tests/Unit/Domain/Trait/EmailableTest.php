<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Emailable\Emailable;
use DomainException;
use PHPUnit\Framework\TestCase;

final class EmailableTest extends TestCase
{
    /**
     * @group unit
     * @group emailable
     * @group emailable-create
     * @group emailable-create-success
     * @return void
     */
    public function testItCreatesAnEmail(): void
    {
        $email = 'test@gmail.com';
        $emailable = Emailable::create($email);
        $this->assertEquals($email, $emailable->getEmail());
    }

    /**
     * @group unit
     * @group emailable
     * @group emailable-create
     * @group emailable-create-fail
     * @return void
     */
    public function testItFailsToCreateAnEmailWithoutAt(): void
    {
        $email = 'testgmail.com';
        $domainExceptionWasThrown = false;
        try {
            $emailable = Emailable::create($email);
        } catch(DomainException) {
            $domainExceptionWasThrown = true;
        }
        $this->assertTrue($domainExceptionWasThrown);
    }

    /**
     * @group unit
     * @group emailable
     * @group emailable-create
     * @group emailable-create-fail
     * @return void
     */
    public function testItFailsToCreateAnEmailWithoutDot(): void
    {
        $email = 'test@gmailcom';
        $domainExceptionWasThrown = false;
        try {
            $emailable = Emailable::create($email);
        } catch(DomainException) {
            $domainExceptionWasThrown = true;
        }
        $this->assertTrue($domainExceptionWasThrown);
    }

    /**
     * @group unit
     * @group emailable
     * @group emailable-create
     * @group emailable-create-fail
     * @return void
     */
    public function testItFailsToCreateAnEmailWithoutExtension(): void
    {
        $email = 'test@gmail.';
        $domainExceptionWasThrown = false;
        try {
            $emailable = Emailable::create($email);
        } catch(DomainException) {
            $domainExceptionWasThrown = true;
        }
        $this->assertTrue($domainExceptionWasThrown);
    }

    /**
     * @group unit
     * @group emailable
     * @group emailable-create
     * @group emailable-create-fail
     * @return void
     */
    public function testItFailsToCreateAnEmailWithoutDomain(): void
    {
        $email = 'test@.com';
        $domainExceptionWasThrown = false;
        try {
            $emailable = Emailable::create($email);
        } catch(DomainException) {
            $domainExceptionWasThrown = true;
        }
        $this->assertTrue($domainExceptionWasThrown);
    }

    /**
     * @group unit
     * @group emailable
     * @group emailable-create
     * @group emailable-create-fail
     * @return void
     */
    public function testItFailsToCreateAnEmailWithoutName(): void
    {
        $email = '@gmail.com';
        $domainExceptionWasThrown = false;
        try {
            $emailable = Emailable::create($email);
        } catch(DomainException) {
            $domainExceptionWasThrown = true;
        }
        $this->assertTrue($domainExceptionWasThrown);
    }
}