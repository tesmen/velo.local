<?php

namespace VelovitoBundle\Model\Maintenance;

use VelovitoBundle\C;
use Doctrine\ORM\EntityManager;
use VelovitoBundle\Model\DefaultModel;

class MaintenanceModel
{
    private $em;
    private $defaultModel;

    public function  __construct(EntityManager $em, DefaultModel $defaultModel)
    {
        $this->em = $em;
        $this->defaultModel = $defaultModel;
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

    function loadCategories()
    {
        $list = $this->defaultModel->loadConfigFromYaml('categories');
        $this->em->getRepository(C::REPO_CATEGORIES)->load($list);
    }

    function loadCatalog()
    {
        $list = $this->defaultModel->loadConfigFromYaml('catalog');
        $this->em->getRepository(C::REPO_CATALOG)->load($list);
    }
}