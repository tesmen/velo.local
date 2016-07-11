<?php
namespace VelovitoBundle\Service;

use VelovitoBundle\C;
use Gregwar\Image\Image;
use VelovitoBundle\Model\DefaultModel;

class GregwarImageService
{
    private $fileWorker;

    public function __construct(DefaultModel $defaultModel, FileWorker $fileWorker)
    {
        $this->defaultModel = $defaultModel;
        $this->fileWorker = $fileWorker;
    }

    public function getImage($filename)
    {
        $filePath = $this->fileWorker->getWebDir() . DIRECTORY_SEPARATOR . $filename;

        return new Image($filePath);
    }

    public function resize($fileName, $width, $height)
    {
        $image = $this->getImage($fileName);

        return $image
            ->scaleResize($width, $height);
    }
}
