<?php

namespace VelovitoBundle\Twig;

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
        ];
    }

    public function resize($imageName, $width, $heigth)
    {
        return $this->imageService->scaleResize($imageName, $width, $heigth);
    }

    public function getUserPhoto($fileName, $width, $heigth)
    {
        $filePath = $this->fileWorker->getUserPhotoDir() . DIRECTORY_SEPARATOR . $fileName;

        return $this->imageService->scaleResize($filePath, $width, $heigth);
    }

    public function getName()
    {
        return 'image';
    }
}
