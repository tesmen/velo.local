<?php

namespace VelovitoBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Kernel;
use VelovitoBundle\C;

class CacheService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->cacheRepo = $em->getRepository()
    }


}
