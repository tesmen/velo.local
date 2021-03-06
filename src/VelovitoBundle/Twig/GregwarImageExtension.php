<?php

namespace VelovitoBundle\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;
use VelovitoBundle\Service\FileWorker;
use VelovitoBundle\Service\GregwarImageService;

class GregwarImageExtension extends \Twig_Extension
{
    private $imageService;
    private $fileWorker;
    private $router;

    public function __construct(GregwarImageService $gregwarImageService, FileWorker $fileWorker, Router $router)
    {
        $this->imageService = $gregwarImageService;
        $this->fileWorker = $fileWorker;
        $this->router = $router;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('resize', [$this, 'resize']),
            new \Twig_SimpleFilter('getUserPhoto', [$this, 'getUserPhoto']),
            new \Twig_SimpleFilter('getAssetImage', [$this, 'getAssetImage']),
            new \Twig_SimpleFilter('noPhoto', [$this, 'noPhoto']),
        ];
    }

    public function resize($imageName, $width, $heigth)
    {
        return $this->imageService->zoomCrop($imageName, $width, $heigth);
    }

    public function getUserPhoto($fileName, $width, $heigth)
    {
        if (empty($fileName)) {
            $filePath =  $this->getAssetImageFilePath('no_photo.png');
        } else {
            $filePath = $this->fileWorker->getUserPhotoDir() . DIRECTORY_SEPARATOR . $fileName;
        }

        return $this->getBasePath() . $this->imageService->zoomCrop($filePath, $width, $heigth);
    }

    public function getAssetImage($fileName, $width, $heigth)
    {
        if (empty($fileName)) {
            $filePath =  $this->getAssetImageFilePath('no_photo.png');
        } else {
            $filePath = $this->fileWorker->getAssetImgDir() . DIRECTORY_SEPARATOR . $fileName;
        }

        return $this->getBasePath() . $this->imageService->scaleResize($filePath, $width, $heigth);
    }

    public function getAssetImageFilePath($fileName)
    {
        return $this->fileWorker->getAssetImgDir() . DIRECTORY_SEPARATOR . $fileName;
    }

    public function getBasePath()
    {
        $base = $this->router->generate('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL);

        return str_replace('app_dev.php/', '', $base);
    }


    public function getName()
    {
        return 'image';
    }
}
