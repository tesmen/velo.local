<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Role;

class RoleRepository extends GeneralRepository
{
    public function load(array $data)
    {
        $this->_em->beginTransaction();

        try {
            foreach ($data as $id => $roleName) {
                $ent = new Role();
                $ent->setId($id);
                $ent->setName($roleName);

                $this->_em->persist($ent);
            }

            $this->truncateTable();
            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }
    }

//    public function create($id, $name)
//    {
//        $this->_em->beginTransaction();
//        try {
//            $role = new Role();
//            $role->setName($name);
//            $role->setId($id);
//
//            $this->_em->persist($role);
//
//            $this->_em->flush();
//            $this->_em->commit();
//        } catch (\Exception $e) {
//            $this->_em->rollback();
//            throw $e;
//        }
//
//        return $role;
//    }
}
