<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFavoriteAdvert
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\UserFavoriteAdvertRepository")
 */
class UserFavoriteAdvert
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
     * @ORM\ManyToOne(targetEntity="VelovitoBundle\Entity\Advertisement")
     * @ORM\JoinColumn(name="ad_id", referencedColumnName="id", nullable=true)
     */
    private $ad;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="VelovitoBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=true)
     */
    private $user;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

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
     * Set registeredDate
     *
     * @param \DateTime $creationDate
     *
     * @return UserFavoriteAdvert
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get registeredDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set ad
     *
     * @param \VelovitoBundle\Entity\Advertisement $ad
     *
     * @return UserFavoriteAdvert
     */
    public function setAd(\VelovitoBundle\Entity\Advertisement $ad = null)
    {
        $this->ad = $ad;

        return $this;
    }

    /**
     * Get ad
     *
     * @return \VelovitoBundle\Entity\Advertisement
     */
    public function getAd()
    {
        return $this->ad;
    }

    /**
     * Set user
     *
     * @param \VelovitoBundle\Entity\User $user
     *
     * @return UserFavoriteAdvert
     */
    public function setUser(\VelovitoBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \VelovitoBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
