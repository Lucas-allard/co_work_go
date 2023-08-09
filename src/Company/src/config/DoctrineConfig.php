<?php declare(strict_types=1);

namespace Company\config;

use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

final class DoctrineConfig
{
    public static function configure(EntityManagerConfig $emDefault): void
    {
        $emDefault->mapping('Company')
        ->type('xml')
        ->dir(dirname(__DIR__).'/Infrastructure/Entity')//self::getDirectoryPath())
        ->prefix('Company')
        ;
    }
}
