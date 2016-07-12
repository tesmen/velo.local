<?php

namespace VelovitoBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use VelovitoBundle\C;

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

    public function getUserPhotoDir()
    {
        return $this->getWebDir() . DIRECTORY_SEPARATOR . C::UPLOAD_PATH;
    }

    public function getAppDir()
    {
        return $this->kernel->getRootDir();
    }

    public function saveUserUploadedPhoto(UploadedFile $file)
    {
        $file->move($this->getUserPhotoDir(), $file->getClientOriginalName());

        return $file->getFilename();
    }
}
