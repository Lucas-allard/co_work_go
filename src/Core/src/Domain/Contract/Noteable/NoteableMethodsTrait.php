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
     * @return $this
     */
    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

}