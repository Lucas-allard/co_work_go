<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use ApiPlatform\Core\Bridge\Symfony\Messenger\DataTransformer;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Core\Application\Action\ActionInterface;
use Core\Infrastructure\Maker\MakeDomain;
use Core\Presentation\Controller\ControllerInterface;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface as DoctrineEventSubscriberInterface;
//use Order\Domain\ValueObject\STATUS;
use Security\Infrastructure\Provider\SymfonySecurityUserProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\EventSubscriberInterface as SymfonyEventSubscriberInterface;

return function (ContainerConfigurator $configurator) {
    $dirs = [
        'Domain' => ['Repository', 'Provider', 'Service'],
        'Infrastructure' => ['Repository', 'Provider', 'Service', 'Event', 'EventSubscriber', 'DataFixtures'],
        'Presentation' => ['Controller', 'Command', 'Form', 'DataTransformer', 'Normalizer'],
    ];
    $configurator->parameters()
        ->set('app.ulid', '[A-Z0-9]{26}')
        ->set('app.locale_code', '[a-z]{2}');
//        ->set('app.order.status', implode('|', STATUS::toArray()));
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->bind('$projectDir', '%kernel.project_dir%')
//        ->bind('$imageUploadDir', '%env(resolve:IMAGE_UPLOAD_DIR)%')
    ;

    //$services->load('App\\', '../src/*')->exclude('../src/{DependencyInjection,Entity,Tests,Kernel.php}');
    $services->instanceof(ActionInterface::class)->tag('controller.service_arguments');
    $services->instanceof(ControllerInterface::class)->tag('controller.service_arguments');
    //$services->instanceof(Fixture::class)->tag('doctrine.fixture.orm');
    $services->instanceof(Command::class)->tag('console.command');
    $services->instanceof(DoctrineEventSubscriberInterface::class)->tag('doctrine.event_subscriber');
    $services->instanceof(SymfonyEventSubscriberInterface::class)->tag('kernel.event_subscriber');
    $services->set(MakeDomain::class)->tag('maker.command');
    $services->set(SymfonySecurityUserProvider::class)
        ->args([
            /* Injectez ici les dépendances nécessaires au fournisseur */
        ]);


//    $services->set(DataTransformer::class);
    $services->instanceof(DataTransformerInterface::class)->tag('api_platform.data_transformer');

    foreach (glob(dirname(__DIR__).'/src/*', GLOB_ONLYDIR) as $domainPath) {
        $domainName = basename($domainPath);
        $domainPath .= '/src';
        //Application
        $services->load("$domainName\\Application\\", "$domainPath/Application")
            ->exclude("$domainPath/Application/*/*/*{Command.php, Query.php}");

        foreach ($dirs as $dir => $subdirs) {
            foreach ($subdirs as $subdir) {
                $path = "$domainPath/$dir/$subdir";
                $namespace = "$domainName\\$dir\\$subdir\\";
                if (file_exists($path)
                    && 'Translation\\Infrastructure\\Provider\\' !== $namespace
                    && 'Translation\\Domain\\Service\\' !== $namespace) {
                    $services->load($namespace, $path);
                }
            }
        }
        call_user_func(
            ["$domainName\config\ContainerConfig", 'configure'],
            $services
        );

    }
};
