<?php
namespace VelovitoBundle\Service;

use VelovitoBundle\C;
use Gregwar\Image\Image;
use VelovitoBundle\Model\DefaultModel;

class GregwarImageService
{
    public function __construct(DefaultModel $defaultModel)
    {
        $this->defaultModel = $defaultModel;
    }

    public function getImage($filename)
    {
        $filePath = $this->defaultModel->getImageOriginalsDir($filename);

        return new Image($filePath);
    }

    public function resize($fileName, $witdh, $height)
    {
        $image = $this->getImage($fileName);

        return $image
            ->scaleResize($witdh, $height);
    }
}
