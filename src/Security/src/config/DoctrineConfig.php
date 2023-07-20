<?php declare(strict_types=1);

namespace Security\config;

use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

final class DoctrineConfig
{
    public static function configure(EntityManagerConfig $emDefault): void
    {
        $emDefault->mapping('Security')
        ->type('php')
        ->dir(dirname(__DIR__).'/Infrastructure/Entity')//self::getDirectoryPath())
        ->prefix('Security')
        ;
    }
}
