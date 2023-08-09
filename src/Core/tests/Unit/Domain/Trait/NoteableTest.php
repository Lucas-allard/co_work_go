<?php

namespace Core\Tests\Unit\Domain\Trait;

use Core\Tests\Mock\Domain\Contract\Noteable\Noteable;
use PHPUnit\Framework\TestCase;

final class NoteableTest extends TestCase
{
    /**
     * @group unit
     * @group noteable
     * @group noteable-create
     * @return void
     */
    public function testCreate(): void
    {
        $note = 'This is a note';
        $noteable = Noteable::create($note);
        $this->assertEquals($note, $noteable->getNote());
    }

    /**
     * @group unit
     * @group noteable
     * @group noteable-set-note
     * @return void
     */
    public function testSetNote(): void
    {
        $note = 'This is a note';
        $noteable = Noteable::create('');
        $noteable->setNote($note);
        $this->assertEquals($note, $noteable->getNote());
    }
}