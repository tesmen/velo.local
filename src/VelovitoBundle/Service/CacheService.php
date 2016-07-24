<?php

namespace VelovitoBundle\Service;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;

class CacheService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->cacheRepo = $em->getRepository(C::REPO_CACHE);
    }

    public static function getProductCategories()
    {
        $this->em->getRepository(C::REPO_PRODUCT_CATEGORY)->
    }
}
