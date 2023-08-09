<?php

namespace Core\Domain\Contract\Optionable;

use JsonSerializable;
use Stringable;

final class Option implements JsonSerializable, Stringable
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var int
     */
    private int $price;

    /**
     * @param string|null $name
     * @param int $price
     */
    public function __construct(?string $name = null, int $price = 0)
    {
        $this->setName($name);
        $this->setPrice($price);
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): Option
    {
        $this->name = $name ?? "";
        return $this;
    }

    /**
     * @param int $price
     * @return $this
     */
    public function setPrice(int $price): Option
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $json = json_encode($this);
        if (!$json) return '';
        return $json;
    }

    /**
     * @param mixed $json
     * @return self
     */
    public static function fromJson(mixed $json): self
    {
        return new self($json->name, $json->price);
    }
}