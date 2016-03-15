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

        return $tmpFileName;
    }

    public function removeSupportAttach($tmpFileName)
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

    public function resizeImage($fileName)
    {
        $inFile = $this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.$fileName;

//        Image::open($inFile)

        $image = new Image($inFile);
        $image
            ->resize(100, 100)
            ->negate()
            ->save($this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.'out.jpg');


        return file_get_contents($this->defaultModel->getUploadRootDir().DIRECTORY_SEPARATOR.$fileName);
    }


}