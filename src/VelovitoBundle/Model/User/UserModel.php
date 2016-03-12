<?php

namespace VelovitoBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\KernelInterface;
use VelovitoBundle\C;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class UserModel
{
    private $em;

    public function __construct(EntityManager $em, KernelInterface $kernel)
    {
        $this->em = $em;
        $this->kernel = $kernel;
    }

    public function getFavoriteAds()
    {
        return $this->em->getRepository(C::REPO_USER_FAVORITES)->findBy();
    }

}
