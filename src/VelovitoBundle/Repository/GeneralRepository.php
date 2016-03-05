<?php

namespace VelovitoBundle\Repository;

use Doctrine\ORM\EntityRepository;


class GeneralRepository extends EntityRepository
{
    protected function truncateTable($tableName, $cascade = false)
    {
        $connection = $this->_em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $connection->executeUpdate($platform->getTruncateTableSQL($tableName, $cascade));
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
    }

    public function resetIncrement($tableName)
    {
        $this->_em->getConnection()->exec("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
    }

    public function findOneOrFail($fields, $order = null)
    {
        $ent = $this->findOneBy($fields, $order);
        if (!$ent) {
            throw new NotFoundException($this->_entityName.' not found');
        }

        return $ent;
    }

    public function findByOrFail($fields, $order = null)
    {
        $ents = $this->findBy($fields, $order);
        if (!$ents) {
            throw new NotFoundException($this->_entityName.' not found');
        }

        return $ents;
    }

    public function addParam($id, $array)
    {
        if (!is_array($array)) {
            return false;
        }

        $orderItemEnt = $this->findOneById($id);

        $initialArray = is_array($orderItemEnt->getSerializedParams())
            ? $orderItemEnt->getSerializedParams()
            : [];

        $orderItemEnt->setSerializedParams(array_merge($initialArray, $array));
        $this->_em->flush();
    }
}
