<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\Currency;

class CurrencyRepository extends GeneralRepository
{
    public function create(array $data)
    {
        $ent = new Currency();
        $ent
            ->setName($data['name'])
            ->setShortName($data['shortName'])
            ->setSign($data['htmlSign']);

        $this->_em->persist($ent);
        $this->_em->flush($ent);
    }

    /**
     * @return Currency
     */
    public function getDefault()
    {
       return $this->findOneBy(
           []
       );
    }
}

