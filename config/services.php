<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

//use ApiPlatform\Core\Bridge\Symfony\Messenger\DataTransformer;
//use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Core\Infrastructure\Maker\MakeDomain;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface as DoctrineEventSubscriberInterface;
//use Menu\Infrastructure\Service\MenuLinkProvider;
//use Order\Domain\ValueObject\STATUS;
//use Shared\Application\Action\ActionInterface;
//use Shared\Presentation\Controller\ControllerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\EventDispatcher\EventSubscriberInterface as SymfonyEventSubscriberInterface;

return function (ContainerConfigurator $configurator) {
    $configurator->parameters()
        ->set('app.ulid', '[A-Z0-9]{26}')
        ->set('app.locale_code', '[a-z]{2}');
//        ->set('app.order.status', implode('|', STATUS::toArray()));
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->bind('$projectDir', '%kernel.project_dir%')
        //->bind('$imageUploadDir', '%env(resolve:IMAGE_UPLOAD_DIR)%')
    ;

    //$services->load('App\\', '../src/*')->exclude('../src/{DependencyInjection,Entity,Tests,Kernel.php}');
//    $services->instanceof(ActionInterface::class)->tag('controller.service_arguments');
//    $services->instanceof(ControllerInterface::class)->tag('controller.service_arguments');
    //$services->instanceof(Fixture::class)->tag('doctrine.fixture.orm');
    $services->instanceof(Command::class)->tag('console.command');
    $services->instanceof(DoctrineEventSubscriberInterface::class)->tag('doctrine.event_subscriber');
    $services->instanceof(SymfonyEventSubscriberInterface::class)->tag('kernel.event_subscriber');
    $services->set(MakeDomain::class)->tag('maker.command');

//    $services->set(DataTransformer::class);
//    $services->instanceof(DataTransformerInterface::class)->tag('api_platform.data_transformer');

    foreach (glob(dirname(__DIR__).'/src/*', GLOB_ONLYDIR) as $domainPath) {
        $domainName = basename($domainPath);
        $domainPath .= '/src';
        //Application
        $services->load("$domainName\\Application\\", "$domainPath/Application")
            ->exclude("$domainPath/Application/*/*/*{Command.php, Query.php}");

        call_user_func(
            ["$domainName\config\ContainerConfig", 'configure'],
            $services
        );

//        $services->set(MenuLinkProvider::class)
//            ->args(['%env(default::resolve:WEBAPP_URL_PATTERN)%']);
        //("$domainName\config\ContainerConfig")::configure($services);
    }
};
