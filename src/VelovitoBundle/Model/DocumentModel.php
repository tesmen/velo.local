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
        $this->createUploadedImageSizes($tmpFileName);

        return $tmpFileName;
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

    public function createUploadedImageSizes($fileName)
    {
        $filePath = $this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.$fileName;
        $image = new Image($filePath);

        $sizes = [
            800,
            512,
            200,
            150,
            100,
        ];

        foreach ($sizes as $size) {
            $image
                ->scaleResize($size, $size)
                ->save($this->defaultModel->getImagesDir().DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$fileName);
        }

        return true;
    }


}