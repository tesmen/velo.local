<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Advertisement;
use VelovitoBundle\Entity\PhotoFile;
use VelovitoBundle\Entity\User;
use VelovitoBundle\C;
use VelovitoBundle\Exception\NotFoundException;

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
            $currency = $this->_em->getRepository(C::REPO_CURRENCY)->find(1); // todo CURENCY
            $status = $this->_em->getRepository(C::REPO_ADVERT_STATUS)->find(
                C::ADVERT_STATUS_PUBLISHED
            ); // todo CURENCY
            $advertEnt = new Advertisement();

            $advertEnt
                ->setTitle($data[C::FORM_TITLE])
                ->setPrice($data[C::FORM_PRICE])
                ->setStatus($status)
                ->setCurrency($currency)
                ->setDescription($data[C::FORM_DESCRIPTION])
                ->setUser($user);

            $this->_em->persist($advertEnt);

            foreach ($data[C::FORM_PHOTO_FILENAMES] as $photoFileName) {
                $photoEnt = new PhotoFile();
                $photoEnt
                    ->setFileName($photoFileName)
                    ->setAdvert($advertEnt);

                $this->_em->persist($photoEnt);
            }

            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $advertEnt;
    }

    public function setStatus($advertid, $statusId)
    {
        $this->_em->beginTransaction();

        try {
            $statusEnt = $this->_em->getRepository(C::REPO_ADVERT_STATUS)->find($statusId); // todo CURENCY

            $ent = $this->findOneOrFail($advertid);
            $ent->setStatus($statusEnt);
            $this->_em->flush($ent);
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $ent;
    }
}
