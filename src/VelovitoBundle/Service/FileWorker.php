<?php

namespace VelovitoBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\File\File;

class FileWorker
{
//    private $kernel;

    public function __construct(Container $container)
    {
        $this->kernel = $container->get('kernel');
    }

    public function getWebDir()
    {
        return $this->kernel->getRootDir() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web';
    }

    public function getAppDir()
    {
        return $this->kernel->getRootDir();
    }

    public function saveUserUploadedFile(File $file )
    {
        return $file->move('/home/tesmen');
    }
}
