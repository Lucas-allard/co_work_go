<?php

namespace Core\Domain\Provider;

use Symfony\Component\HttpFoundation\File\File;

interface ImageProviderInterface
{
    /**
     * @param File $file
     * @param string $name
     * @param string|null $path
     * @param bool $transform
     * @return string
     */
    public function save(File $file, string $name, ?string $path = null, bool $transform = true): string;

    /**
     * @param string $path
     * @return void
     */
    public function remove(string $path): void;

    /**
     * @param string $name
     * @return string
     */
    public static function getUrl(string $name): string;
}