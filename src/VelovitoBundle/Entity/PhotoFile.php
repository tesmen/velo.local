<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * PhotoFile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\PhotoFileRepository")
 */
class PhotoFile
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
     * @return PhotoFile
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
     *
     * @return PhotoFile
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
}
