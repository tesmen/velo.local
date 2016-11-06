<?php namespace VelovitoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="reset_password_link")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\ResetPasswordLinkRepository")
 */
class ResetPasswordLink
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=32)
     */
    private $hash;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return ResetPasswordLink
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return ResetPasswordLink
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set userId
     *
     * @param \VelovitoBundle\Entity\User $userId
     *
     * @return ResetPasswordLink
     */
    public function setUser(\VelovitoBundle\Entity\User $userId = null)
    {
        $this->user = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \VelovitoBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
