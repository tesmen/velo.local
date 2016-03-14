<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Advertisement;
use VelovitoBundle\Entity\User;
use VelovitoBundle\C;

class AdvertisementRepository extends GeneralRepository
{
    public function load(array $data)
    {
        $this->_em->beginTransaction();

        try {
            foreach ($data as $id => $roleName) {
                $ent = new Advertisement();
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

    public function create($data, User $user)
    {
        $this->_em->beginTransaction();
        try {
            $currency = $this->_em->getRepository(C::REPO_CURRENCY)->find(1);

            $ent = new Advertisement();
            $ent
                ->setTitle($data[C::FORM_TITLE])
                ->setPrice($data[C::FORM_PRICE])
                ->setStatus($data[C::FORM_STATUS])
                ->setCurrency($currency)
                ->setUser($user);

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
