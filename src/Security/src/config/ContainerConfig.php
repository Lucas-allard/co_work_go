<?php declare(strict_types=1);

namespace Security\config;

use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

final class ContainerConfig
{
    public static function configure(DefaultsConfigurator $services): void
    {
//        $services->load(
//            basename(dirname(__DIR__, 2)) . '\\Infrastructure\\Voter\\',
//            dirname(__DIR__) . '/Infrastructure/Voter'
//        );
        $services->alias(LoginLinkHandlerInterface::class, 'security.authenticator.login_link_handler.main');
    }
}
