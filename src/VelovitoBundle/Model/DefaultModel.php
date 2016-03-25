<?php

namespace VelovitoBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\KernelInterface;
use VelovitoBundle\C;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class DefaultModel
{
    private $em;

    public function __construct(EntityManager $em, KernelInterface $kernel)
    {
        $this->em = $em;
        $this->kernel = $kernel;
    }

    public function getUploadRootDir($fileName = null)
    {
        $tail = is_null($fileName)
            ? ''
            : DIRECTORY_SEPARATOR.$fileName;

        return $this->kernel->getRootDir().'/../../'.C::UPLOAD_PATH.$tail;
    }

    public function getUploadedTemporaryImageThumbsDir($fileName = null)
    {
        $dir = $this->getImagesDir().DIRECTORY_SEPARATOR.C::TEMPORARY_UPLOAD_IMAGE_THUMB_PATH;

        return $this->returnFilePath($dir, $fileName);
    }

    public function getWebDir($fileName = null)
    {
        $dir = $this->kernel->getRootDir().'/../web';

        return $this->returnFilePath($dir, $fileName);
    }

    public function getImagesDir($fileName = null)
    {
        $dir = $this->getWebDir().DIRECTORY_SEPARATOR.'img';

        return $this->returnFilePath($dir, $fileName);
    }

    public function getImageOriginalsDir($fileName = null)
    {
        $dir = $this->getImagesDir().DIRECTORY_SEPARATOR.'originals';

        return $this->returnFilePath($dir, $fileName);
    }

    public function returnFilePath($dir, $fileName)
    {
        $tail = is_null($fileName)
            ? ''
            : DIRECTORY_SEPARATOR.$fileName;

        return $dir.$tail;
    }

    public function getMenu($parentId = null)
    {
        return $this->em->getRepository(C::REPO_CATALOG_CATEGORY)->findAll();
    }

    public function loadConfigFromYaml($config)
    {
        $yaml = new Parser();

        try {
            $path = $this->kernel->locateResource('@VelovitoBundle/Resources/config/'.$config.'.yml');

        } catch (ParseException $e) {
            throw new \Exception($config.'.yml not found');
        }

        try {
            $value = $yaml->parse(file_get_contents($path));
        } catch (ParseException $e) {
            throw new \Exception(sprintf('Unable to parse the YAML string: %s', $e->getMessage()));
        }

        return $value;
    }
}
