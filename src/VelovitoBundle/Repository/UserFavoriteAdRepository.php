<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Advertisement;
use VelovitoBundle\Entity\UserFavoriteAd;
use VelovitoBundle\Entity\User;

class UserFavoriteAdRepository extends GeneralRepository
{
    public function load(array $data)
    {
        $this->_em->beginTransaction();

        try {
            foreach ($data as $id => $roleName) {
                $ent = new UserFavoriteAd();
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

    public function create(Advertisement $ad, User $user)
    {
        $this->_em->beginTransaction();
        try {
            $ent = new UserFavoriteAd();
            $ent->setAd($ad);
            $ent->setUser($user);

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