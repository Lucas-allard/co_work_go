<?php

namespace Core\config;

use Core\Domain\Provider\UrlShortenerInterface;
use Core\Infrastructure\Provider\FirebaseUrlShortener;
use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

final class ContainerConfig
{

    /**
     * @param DefaultsConfigurator $services
     * @return void
     */
    public static function configure(DefaultsConfigurator $services): void
    {
        $services->load(
            basename(dirname(__DIR__, 2)) . '\\Infrastructure\\Maker\\',
            dirname(__DIR__) . '/Infrastructure/Maker'
        );
        $services->load(
            basename(dirname(__DIR__, 2)) . '\\Infrastructure\\DataFixtures\\',
            dirname(__DIR__) . '/Infrastructure/DataFixtures'
        );

        // add Core\Presentation\Controller\TokenStorageInterface to the container for autowiring

//        $services->set(FirebaseUrlShortener::class)
//            ->args(['%env(FIREBASE_API_KEY)%', '%env(FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN)%'])
//            ->alias(UrlShortenerInterface::class, FirebaseUrlShortener::class);
    }
}