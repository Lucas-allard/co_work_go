<?php

namespace Core\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getProjectDir(): string
    {
        return dirname(__DIR__, 4);
    }

    public function getCacheDir(): string
    {
        return dirname(__DIR__, 4).'/var/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return dirname(__DIR__, 4).'/var/log';
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import($this->getProjectDir().'/config/{packages}/*.yaml');
        $container->import($this->getProjectDir().'/config/{packages}/*.php');
        $container->import($this->getProjectDir().'/config/{packages}/'.$this->environment.'/*.yaml');

        if (is_file($this->getProjectDir().'/config/services.yaml')) {
            $container->import($this->getProjectDir().'/config/services.yaml');
            $container->import($this->getProjectDir().'/config/{services}_'.$this->environment.'.yaml');
        } else {
            $container->import($this->getProjectDir().'/config/{services}.php');
            $container->import($this->getProjectDir().'/config/{services}_'.$this->environment.'.php');
        }
    }
}
