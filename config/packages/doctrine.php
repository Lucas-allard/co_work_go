<?php

use Core\Infrastructure\Doctrine\EnumType;
use Core\Infrastructure\Doctrine\StorageType;
use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine) {
    $dbal = $doctrine->dbal();
    $dbal->connection('default', ['url' => '%env(resolve:DATABASE_URL)%']);
    $dbal->type('storage')->class(StorageType::class);
    $dbal->type('enum')->class(EnumType::class);
    $orm = $doctrine->orm();
    $orm->autoGenerateProxyClasses(true);
    $emDefault = $orm->entityManager('default');
    $emDefault->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware');
    $emDefault->autoMapping(true);

    \Core\config\DoctrineConfig::configure($emDefault);
    \Security\config\DoctrineConfig::configure($emDefault);
    \Company\config\DoctrineConfig::configure($emDefault);
};
