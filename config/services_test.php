<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Console\Command\Command;
use Translation\Domain\Provider\ApiTranslationProviderInterface;
use Translation\Tests\Mock\InMemoryTranslationProvider;

return function (ContainerConfigurator $configurator) {

    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();
//    $services->set(InMemoryTranslationProvider::class)
//        ->alias(ApiTranslationProviderInterface::class, InMemoryTranslationProvider::class);
};
