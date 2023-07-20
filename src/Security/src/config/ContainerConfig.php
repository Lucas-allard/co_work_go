<?php declare(strict_types=1);

namespace Security\config;

use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

final class ContainerConfig
{
    public static function configure(DefaultsConfigurator $services): void
    {
        //Application
        $services->load('Security\\Application\\', dirname(__DIR__).'/Application');
        //Domain
        //Infrastructure
        $services->load('Security\\Infrastructure\\', dirname(__DIR__).'/Infrastructure')
            ->exclude(dirname(__DIR__).'/Infrastructure/{Entity}');
        //Presentation

        //Application
        $services->load('Company\\Application\\', dirname(__DIR__).'/Application')
            ->exclude(dirname(__DIR__).'/Application/*/*/*{Command.php, Query.php}');
        //Domain
        $services->load('Company\\Domain\\', dirname(__DIR__).'/Domain')
            ->exclude(dirname(__DIR__).'/Domain/{Entity, ValueObject}');
        //Infrastructure
        $services->load('Company\\Infrastructure\\', dirname(__DIR__).'/Infrastructure')
            ->exclude(dirname(__DIR__).'/Infrastructure/{Entity}');
        //Presentation
    }
}
