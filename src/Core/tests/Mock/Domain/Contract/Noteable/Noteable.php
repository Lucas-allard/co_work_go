<?php

namespace Core\Tests\Mock\Domain\Contract\Noteable;

use Core\Domain\Contract\Noteable\NoteableInterface;
use Core\Domain\Contract\Noteable\NoteableMethodsTrait;

final class Noteable implements NoteableInterface
{
    use NoteableMethodsTrait;

    public function __construct(){}

    static public function create(string $note): self
    {
        return (new self())
            ->setNote($note);
    }
}