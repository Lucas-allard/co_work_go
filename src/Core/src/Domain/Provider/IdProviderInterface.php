<?php

namespace Core\Domain\Provider;

interface IdProviderInterface
{
    /**
     * @return string
     */
    public function generate(): string;

    /**
     * @return string
     */
    static function staticGenerate(): string;

    /**
     * @param string $id
     * @return void
     */
    static function assertValidId(string $id): void;
}