<?php

namespace VelovitoBundle\Model;

use Doctrine\ORM\EntityManager;
use Gregwar\Image\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use VelovitoBundle\C;
use VelovitoBundle\Service\CommonFunction;

class DocumentModel
{
    private $em;
    private $defaultModel;

    public function __construct(EntityManager $em, DefaultModel $defaultModel)
    {
        $this->em = $em;
        $this->defaultModel = $defaultModel;
    }

    public function saveUploadedFile(UploadedFile $file = null)
    {
        $fileName = $file->getClientOriginalName();
        $fileExtension = CommonFunction::getFileExtension($fileName);

        $tmpFileName = md5($fileName.microtime(true)).'.'.$fileExtension;
        $file->move($this->defaultModel->getUploadRootDir(), $tmpFileName);
        $this->createTemporaryUploadedImageThumb($tmpFileName);

        return $tmpFileName;
    }

    public function saveOriginalsForUploadedImages(array $fileNames)
    {
        $result = [];

        foreach ($fileNames as $name) {
            try{
                $this->moveUploadedFileTo($name, $this->defaultModel->getImageOriginalsDir($name));
                $result[] = $name;
            } catch (\Exception $e ){

            }
        }

        return $result;
    }

    public function moveUploadedFileTo($fileName, $destination)
    {
        $filePath = $this->defaultModel->getUploadRootDir($fileName);

        return rename($filePath, $destination);
    }

    public function deleteUploadedFile($tmpFileName)
    {
        return unlink($this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.$tmpFileName);
    }

    public function createCsvLogFile(Array $data, $filename)
    {
        $fp = fopen($this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.$filename, 'w');

        foreach ($data as $fields) {
            fputcsv($fp, $fields, ';');
        }

        fclose($fp);

        return $filename;
    }

    public function deleteCsvLogFile($fileName)
    {
        return unlink($this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.$fileName);
    }

    public function getCsvLogFile($fileName)
    {
        return file_get_contents($this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.$fileName);
    }

    public function createImageSizesFromUploaded($fileName)
    {
        $filePath = $this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.$fileName;

        $sizes = [
            800,
            512,
            200,
            150,
            100,
        ];

        foreach ($sizes as $size) {
            $output = $this->defaultModel->getImagesDir().DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$fileName;
            $this->createResizedImage($size, $size, $filePath, $output);
        }

        return true;
    }

    public function createTemporaryUploadedImageThumb($fileName)
    {
        $filePath = $this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.$fileName;
        $output = $this->defaultModel->getUploadedTemporaryImageThumbsDir().DIRECTORY_SEPARATOR.$fileName;
        $this->createResizedImage(150, 150, $filePath, $output);

        return true;
    }

    public function createResizedImage($height, $width, $inFileName, $outFileName)
    {
        $image = new Image($inFileName);

        $image
            ->scaleResize($height, $width)
            ->save($outFileName);

        return true;
    }


}