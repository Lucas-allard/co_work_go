<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Translation\Domain\Provider\ApiTranslationProviderInterface;
use Translation\Infrastructure\Provider\GoogleCloudApiTranslationProvider;

return function (ContainerConfigurator $configurator) {

    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();
//    $services->set(GoogleCloudApiTranslationProvider::class)
//        ->args([
//            '%env(resolve:GCP_SERVICE_ACCOUNT_KEY)%',
//            '%env(default::resolve:GCP_GLOSSARY_NAME)%'
//            ])
//        ->alias(ApiTranslationProviderInterface::class, GoogleCloudApiTranslationProvider::class);
};
