<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * PhotoFile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\PhotoFileRepository")
 */
class Photo
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
     * @ORM\Column(name="filename", type="string", length=64, nullable=false, unique=true)
     */
    private $fileName;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Advertisement", inversedBy="photos")
     * @ORM\JoinColumn(name="advert", referencedColumnName="id")
     *
     */
    private $advert;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="photos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    private $user;


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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Photo
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set advert
     *
     * @param \VelovitoBundle\Entity\Advertisement $advert
     * @return Photo
     */
    public function setAdvert(\VelovitoBundle\Entity\Advertisement $advert = null)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \VelovitoBundle\Entity\Advertisement
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set user
     *
     * @param \VelovitoBundle\Entity\User $user
     *
     * @return Photo
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
