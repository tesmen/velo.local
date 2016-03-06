<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\CatalogItem;

class CatalogItemRepository extends GeneralRepository
{
    public function load(array $data)
    {
        foreach ($data as $CatalogItemItemData) {
            $this->create($CatalogItemItemData);
        }

        foreach ($data as $CatalogItemItemData) {
            if (empty($CatalogItemItemData['parent'])) {
                continue;
            }

            $ent = $this->findOneOrFail(
                ['alias' => $CatalogItemItemData['alias']]
            );

            $parentEnt = $this->findOneOrFail(
                [
                    'alias' => $CatalogItemItemData['parent'],
                ]
            );

            $this->updateEntity(
                $ent,
                [
                    'parent' => $parentEnt->getId(),
                ]
            );
        }
    }

    public function update1($id, $CatalogItemItemData)
    {
        if (!$ent = $this->find($id)) {
            return $this->create($CatalogItemItemData);
        }

        $this->_em->beginTransaction();

        try {
            $ent->setName($CatalogItemItemData);

            $this->_em->persist($ent);

            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $ent;
    }

    public function create($data)
    {
        $this->_em->beginTransaction();

        try {
            $ent = new CatalogItem();
            $ent->setName($data['name']);
            $ent->setAlias($data['alias']);

            $this->_em->persist($ent);

            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $ent;
    }
}
