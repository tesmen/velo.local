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


    /**
     * @param $filePath /home/user/var/www/site/upload/img.png
     * @param $width
     * @param $height
     * @return mixed
     */
    public function scaleResize($filePath, $width, $height)
    {
        $image = new Image($filePath);

        return $image->scaleResize($width, $height,0xffffff);
    }
}
