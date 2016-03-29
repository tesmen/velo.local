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

    public function createAdvert($data, User $user)
    {
        $this->_em->beginTransaction();
        $currency = $this->_em->getRepository(C::REPO_CURRENCY)->findOneOrFail(['id' => 1]);

        try {
            $advertEnt = new Advertisement();

            $advertEnt
                ->setTitle($data[C::FORM_TITLE])
                ->setPrice($data[C::FORM_PRICE])
                ->setCurrency($currency)
                ->setIsDeleted(false)
                ->setIsPublished(true)
                ->setDescription($data[C::FORM_DESCRIPTION])
                ->setUser($user);

            $this->_em->persist($advertEnt);

            foreach ($data[C::FORM_PHOTO_FILENAMES] as $photoFileName) {
                $this->_em->getRepository(C::REPO_PHOTO_FILE)->create(
                    [
                        'advert'   => $advertEnt,
                        'fileName' => $photoFileName,
                    ]
                );
            }

            $this->_em->flush();
            $this->_em->commit();
        } catch (\Exception $e) {
            $this->_em->rollback();
            throw $e;
        }

        return $advertEnt;
    }

    public function unPublish($advertid)
    {
        $ent = $this->findOneOrFail($advertid);
        $ent->setIsPublished(false);
        $this->_em->flush($ent);

        return $ent;
    }
}
