<?php
declare(strict_types=1);

namespace Core\Domain\Provider;

interface UrlShortenerInterface
{
    /**
     * @param string $url
     * @return string
     */
    function generateFromUrl(string $url): string;
}