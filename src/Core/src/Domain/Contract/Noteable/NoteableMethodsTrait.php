<?php

namespace Core\Domain\Contract\Noteable;

trait NoteableMethodsTrait
{
    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * @param string $note
     * @return self
     */
    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
    }

}