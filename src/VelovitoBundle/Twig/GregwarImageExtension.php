<?php

namespace VelovitoBundle\Twig;

use Symfony\Component\Routing\Router;
use VelovitoBundle\Service\GregwarImageService;

class GregwarImageExtension extends \Twig_Extension
{
    public function __construct(GregwarImageService $gregwarImageService, Router $router)
    {
        $this->imageService = $gregwarImageService;
        $this->router = $router;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('resize', [$this, 'resize']),
        ];
    }

    public function resize($imageName, $width, $heigth)
    {
        return 'http://'
            .$this->router->getContext()->getHost()
            .'/'
            .$this->imageService->resize($imageName, $width, $heigth);
    }

    public function getName()
    {
        return 'image';
    }
}
