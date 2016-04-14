<?php

namespace VelovitoBundle\Model\Maintenance;

use VelovitoBundle\C;
use Doctrine\ORM\EntityManager;
use VelovitoBundle\Entity\CatalogCategory;
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

    function loadCatalogCategories()
    {
        $data = $this->defaultModel->loadConfigFromYaml('catalog_categories');

        foreach ($data as $parentCat) {
            $parentEnt = new CatalogCategory();
            $parentEnt
                ->setAlias($parentCat['alias'])
                ->setName($parentCat['name'])
                ->setParent(null);

            $this->em->persist($parentEnt);
            foreach ($parentCat['children'] as $catalogItem) {
                $ent = new CatalogCategory();
                $ent
                    ->setAlias($catalogItem['alias'])
                    ->setName($catalogItem['name'])
                    ->setParent($parentEnt);

                $this->em->persist($ent);
            }
        }

        $this->em->flush();

//        $this->em->getRepository(C::REPO_CATALOG_CATEGORY)->load($data);
    }

    function loadCurrencies()
    {
        $arr = [
            [
                'name'      => 'Рубль',
                'shortName' => 'руб.',
                'htmlSign'  => '&#8381;',
            ],
        ];

        foreach ($arr as $item) {
            $this->em->getRepository(C::REPO_CURRENCY)->create($item);
        }
    }
}
