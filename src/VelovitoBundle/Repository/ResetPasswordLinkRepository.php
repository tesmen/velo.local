<?php

namespace VelovitoBundle\Repository;

use VelovitoBundle\Entity\ResetPasswordLink;
use VelovitoBundle\Entity\User;

class ResetPasswordLinkRepository extends GeneralRepository
{
    public function create(User $user)
    {
        $link = new ResetPasswordLink();

        $link
            ->setUser($user)
            ->setHash(md5(time()))
            ->setActive(true);

        $this->_em->persist($link);
        $this->_em->flush($link);

        return $link;
    }
}
