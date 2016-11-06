<?php

namespace VelovitoBundle\Model\Traits;

use Doctrine\ORM\EntityManager;
use VelovitoBundle\C;
use VelovitoBundle\Repository\ResetPasswordLinkRepository;
use VelovitoBundle\Repository\UserRepository;

/**
 * Class RepoTrait
 * @package VelovitoBundle\Model\Traits
 * @property EntityManager em
 */
trait RepoTrait
{
    private function getRepo($repoName)
    {
        return $this->em->getRepository($repoName);
    }

    /**
     * @return UserRepository
     */
    private function getUserRepo()
    {
        return $this->getRepo(C::REPO_USER);
    }

    /**
     * @return ResetPasswordLinkRepository
     */
    private function getResetLinkRepo()
    {
        return $this->getRepo(C::REPO_RESET_PASSWORD_LINK);
    }
}
