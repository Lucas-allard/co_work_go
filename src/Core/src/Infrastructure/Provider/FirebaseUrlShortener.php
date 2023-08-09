<?php
declare(strict_types=1);

namespace Core\Infrastructure\Provider;

use Core\Domain\Provider\UrlShortenerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;


class FirebaseUrlShortener implements UrlShortenerInterface
{
    function __construct(
        private string $firebaseApiKey,
        private string $firebaseDynamicLinksDefaultDomain
    )
    {
    }

    function generateFromUrl(string $url): string
    {
        $body = ["dynamicLinkInfo" => [
            "domainUriPrefix" => $this->firebaseDynamicLinksDefaultDomain,
            "link" => $url
        ]];
        $headers = ['Content-Type' => 'application/json; charset=UTF-8'];
        $response = (new Client)->post(
            Uri::fromParts([
                "scheme" => "https",
                "host" => "firebasedynamiclinks.googleapis.com",
                "path" => "/v1/shortLinks",
                "query" => "key=" . $this->firebaseApiKey
            ]),
            [
                "body" => json_encode($body),
                "headers" => $headers
            ]
        );
        if ($response->getStatusCode() === 200) {
            return json_decode((string)$response->getBody(), true)["shortLink"];
        }
        throw new \RuntimeException("An error occured while asking for a shortened url");
    }
}