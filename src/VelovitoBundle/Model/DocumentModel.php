<?php

namespace VelovitoBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use VelovitoBundle\C;

class DocumentModel
{
    private $em;
    private $defaultModel;

    public function __construct(EntityManager $em, DefaultModel $defaultModel)
    {
        $this->em = $em;
        $this->defaultModel = $defaultModel;
    }

    public function createSupportAttach(UploadedFile $file = null)
    {
        if (is_null($file)) {
            throw new \Exception('no file is present');
        }

        $tmpFileName = md5($file->getClientOriginalName().microtime(true));
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
}