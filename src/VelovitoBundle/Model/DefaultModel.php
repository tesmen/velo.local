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

    public function getUploadRootDir()
    {
        return $this->kernel->getRootDir().'/../../'.C::UPLOAD_PATH;
    }

    public function getUploadedTemporaryImageThumbsDir()
    {
        return $this->getImagesDir().DIRECTORY_SEPARATOR.C::TEMPORARY_UPLOAD_IMAGE_THUMB_PATH;
    }

    public function getImagesDir()
    {
        return $this->kernel->getRootDir().'/../web/img';
    }

    public function getMenu($parentId = null)
    {
        $topEnts = $this->em->getRepository(C::REPO_CATALOG_ITEM)->findByOrFail(
            ['parent' => null]
        );

        foreach ($topEnts as $ent) {
            $result[$ent->getItem()->getId()] = [
                'name'    => $ent->getItem()->getName(),
                'catId'   => $ent->getItem()->getId(),
                'subCats' => null,
            ];
        }

        $childEnts = $this->em->getRepository(C::REPO_CATALOG_ITEM)->findAll();

        foreach ($childEnts as $ent) {
            if (empty($ent->getParent())) {
                continue;
            }

            $result[$ent->getParent()->getId()]['subCats'][$ent->getItem()->getId()] = [
                'name'  => $ent->getItem()->getName(),
                'catId' => $ent->getItem()->getId(),
            ];
        }

        return $result;
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
