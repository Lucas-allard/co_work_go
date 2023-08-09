<?php

namespace Core\Tests\Mock\Domain\Contract\Optionable;

use Core\Domain\Contract\Optionable\Option;
use Core\Domain\Contract\Optionable\OptionableInterface;
use Core\Domain\Contract\Optionable\OptionableTrait;

final class Optionable implements OptionableInterface
{
    use OptionableTrait;

    public function __construct(){}

    /**
     * @param Option|null $option
     * @return self
     */
    static function create(Option $option = null): self
    {
       return (new self())
           ->addOption($option);
    }
}