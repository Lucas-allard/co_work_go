<?php

namespace Core\Tests\Unit\Domain\Trait;


use Core\Tests\Mock\Domain\Contract\Phoneable\Phoneable;
use DomainException;
use PHPUnit\Framework\TestCase;

final class PhoneableTest extends TestCase
{
    /**
     * @group unit
     * @group phoneable
     * @group phoneable-create
     * @group phoneable-create-success
     * @return void
     */
    public function testItCreatesAnPhoneNumber(): void
    {
        $phoneNumber = '+33612345678';
        $phoneable = Phoneable::create($phoneNumber);

        $this->assertEquals($phoneNumber, $phoneable->getPhoneNumber());
    }

    /**
     * @group unit
     * @group phoneable
     * @group phoneable-create
     * @group phoneable-create-fail
     * @return void
     */
    public function testItFailsToCreateAnPhoneNumberWithInvalidPhoneNumber(): void
    {
        $phoneNumber = '0612345678';
        $invalidPhoneNumberExceptionWasThrown = false;
        try {
            $phoneable = Phoneable::create($phoneNumber);
        } catch(DomainException) {
            $invalidPhoneNumberExceptionWasThrown = true;
        }

        $this->assertTrue($invalidPhoneNumberExceptionWasThrown);
    }

    /**
     * @group unit
     * @group phoneable
     * @group phoneable-create
     * @group phoneable-create-fail
     * @return void
     */
    public function testItFailsToCreateAnPhoneNumberWithInvalidPhoneNumber2(): void
    {
        $phoneNumber = '3311261234567280';
        $invalidPhoneNumberExceptionWasThrown = false;
        try {
            $phoneable = Phoneable::create($phoneNumber);
        } catch(DomainException) {
            $invalidPhoneNumberExceptionWasThrown = true;
        }

        $this->assertTrue($invalidPhoneNumberExceptionWasThrown);
    }
}