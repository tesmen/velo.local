<?php namespace VelovitoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="geo_countries")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\GeneralRepository")
 */
class Country
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
     * @ORM\Column(name="name", type="string", length=32)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Region", mappedBy="country")
     */
    private $regions;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
    }


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Country
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add city
     *
     * @param \VelovitoBundle\Entity\City $city
     *
     * @return Country
     */
    public function addCity(\VelovitoBundle\Entity\City $city)
    {
        $this->regions[] = $city;

        return $this;
    }

    /**
     * Remove city
     *
     * @param \VelovitoBundle\Entity\City $city
     */
    public function removeCity(\VelovitoBundle\Entity\City $city)
    {
        $this->regions->removeElement($city);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegions()
    {
        return $this->regions;
    }
}
