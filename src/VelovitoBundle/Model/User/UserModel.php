<?php

namespace VelovitoBundle\Model\User;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;

class UserModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
