<?php

namespace Core\config;

use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

class DoctrineConfig
{
    /**
     * @param EntityManagerConfig $emDefault
     * @return void
     */
    public static function configure(EntityManagerConfig $emDefault): void
    {
        $emDefault->mapping('Core')
            ->type('xml')
            ->dir(dirname(__DIR__) . '/Infrastructure/Entity')//self::getDirectoryPath())
            ->prefix('Core')
        ;
    }
}