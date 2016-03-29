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

    function loadCatalogCategories()
    {
        $data = $this->defaultModel->loadConfigFromYaml('catalog_categories');
        $this->em->getRepository(C::REPO_CATALOG_CATEGORY)->load($data);
    }

    function loadCurrencys()
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

    function loadAdvertStatuses()
    {
        $records = [
            [
                'id'    => C::ADVERT_STATUS_PUBLISHED,
                'name'  => 'Опубликовано',
                'alias' => 'published',
            ],
            [
                'id'    => C::ADVERT_STATUS_UNPUBLISHED,
                'name'  => 'Снято с публикации',
                'alias' => 'unpublished',
            ],
            [
                'id'    => C::ADVERT_STATUS_DELETED,
                'name'  => 'Удалено',
                'alias' => 'deleted',
            ],
        ];

        $this->em->getRepository(C::REPO_ADVERT_STATUS)->load($records);
    }
}