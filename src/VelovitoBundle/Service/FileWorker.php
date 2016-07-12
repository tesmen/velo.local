<?php

namespace VelovitoBundle\Service;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Kernel;
use VelovitoBundle\C;

class FileWorker
{
    private $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getWebDir()
    {
        return $this->kernel->getRootDir() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web';
    }

    public function getUserPhotoDir()
    {
        return $this->getWebDir() . DIRECTORY_SEPARATOR . C::UPLOAD_PATH;
    }

    public function getAssetImgDir()
    {
        return $this->getWebDir() . DIRECTORY_SEPARATOR . 'bundles' . DIRECTORY_SEPARATOR . 'velovito' . DIRECTORY_SEPARATOR . 'img';
    }

    public function getAppDir()
    {
        return $this->kernel->getRootDir();
    }

    public function saveUserUploadedPhoto(UploadedFile $file)
    {
        $extension = CommonFunction::getFileExtension($file->getClientOriginalName());

        $fileName = md5(microtime(true)) . '.' . $extension;
        $file->move($this->getUserPhotoDir(), $fileName);

        return $fileName;
    }
}
