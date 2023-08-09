<?php

namespace Core\Domain\Contract\Optionable;

interface OptionableInterface
{
    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @param array $options
     * @return static
     */
    public function setOptions(array $options): static;

    /**
     * @param Option $option
     * @return static
     */
    public function addOption(Option $option): static;

    /**
     * @param Option $option
     * @return static
     */
    public function removeOption(Option $option): static;
}