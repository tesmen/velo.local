<?php

namespace AppBundle\Model\Maintenance;

use AppBundle\C;
use Doctrine\ORM\EntityManager;

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

        $this->em->getRepository(C::REPO_ROLE)->load($roles);
    }
}