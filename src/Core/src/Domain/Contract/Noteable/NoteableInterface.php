<?php

namespace Core\Domain\Contract\Noteable;

interface NoteableInterface
{
    /**
     * @return string|null
     */
    public function getNote(): ?string;

    /**
     * @param string|null $note
     * @return $this
     */
    public function setNote(?string $note): static;
}