<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Catalog;

class CatalogRepository extends GeneralRepository
{
    public function load(array $data)
    {
        foreach ($data as $catalogItemData) {
            $this->create($catalogItemData);
        }

        foreach ($data as $catalogItemData) {
            if (empty($catalogItemData['parent'])) {
                continue;
            }

            $ent = $this->findOneOrFail(
                ['alias' => $catalogItemData['alias']]
            );

            $parentEnt = $this->findOneOrFail(
                [
                    'alias' => $catalogItemData['parent'],
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

    public function update1($id, $catalogItemData)
    {
        if (!$ent = $this->find($id)) {
            return $this->create($catalogItemData);
        }

        $this->_em->beginTransaction();

        try {
            $ent->setName($catalogItemData);

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
            $ent = new Catalog();
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
