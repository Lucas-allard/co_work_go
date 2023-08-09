<?php

namespace Core\Domain\Contract\Noteable;

interface NoteableInterface
{
    /**
     * @return string
     */
    public function getNote(): string;

    /**
     * @param string $note
     * @return $this
     */
    public function setNote(string $note): static;
}