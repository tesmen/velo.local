<?php

namespace AppBundle\Model\Maintenance;

use AppBundle\C;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class MaintenanceModel
{
    private $em;

    public function  __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    function loadRoles()
    {
        $roles = [
            C::ROLE_USER      => 'ROLE_USER',
            C::ROLE_MODERATOR => 'ROLE_MODERATOR',
            C::ROLE_ADMIN     => 'ROLE_ADMIN',
        ];

        $repo = $this->em->getRepository(C::REPO_ROLE)->load($roles);
    }
}