<?php

namespace Core\Domain\Contract\Optionable;


trait OptionableMethodsTrait
{
    /**
     * @return array
     */
    public function getOptions(): array
    {
        return array_map(
            fn (string $option) => Option::fromJson(json_decode($option)), $this->options);
    }

    /**
     * @param array $options
     * @return static
     */
    public function setOptions(array $options): static
    {
        $this->options = [];
        foreach ($options as $option) {
            $this->addOption($option);
        }

        return $this;
    }

    /**
     * @param Option $option
     * @return static
     */
    public function addOption(Option $option): static
    {
        $this->options[] = (string)$option;
        return $this;
    }

    /**
     * @param Option $option
     * @return static
     */
    public function removeOption(Option $option): static
    {
        $this->options = array_diff($this->options, [json_encode($option)]);
        return $this;
    }
}