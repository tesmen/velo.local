<?php

namespace VelovitoBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class FileWorker
{
//    private $kernel;

    public function __construct(Container $container)
    {
        $this->kernel = $container->get('kernel');
    }

    public function getWebDir()
    {
        return $this->kernel->getRootDir() . DIRECTORY_SEPARATOR . 'web';
    }

    public function getRootDir()
    {
        return $this->kernel->getRootDir();
    }
}
