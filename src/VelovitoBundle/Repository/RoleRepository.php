<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Role;

class RoleRepository extends GeneralRepository
{
    public function load(array $data)
    {
        foreach ($data as $id => $name) {
            $this->update($id, $name);
        }
    }

    public function create($id, $name)
    {
        $this->_em->beginTransaction();
        try {
            $role = new Role();
            $role->setName($name);
            $role->setId($id);

            $this->_em->persist($role);

            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $role;
    }

    public function update($id, $name)
    {
        if(!$ent = $this->find($id)){
            return $this->create($id, $name);
        }

        $this->_em->beginTransaction();

        try {
            $ent->setName($name);

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
