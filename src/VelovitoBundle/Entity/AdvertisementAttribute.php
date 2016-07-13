<?php namespace VelovitoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Advertisement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\GeneralRepository")
 */
class AdvertisementAttribute
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
     * @ORM\Column(name="advertisement_id", type="integer", options={"unsigned"=true})
     */
    private $advertisement;

    /**
     * @var string
     * @ORM\Column(name="attribute_id", type="integer", options={"unsigned"=true})
     */
    private $attribute;

    /**
     * @var string
     * @ORM\Column(name="$value", type="integer", options={"unsigned"=true})
     */
    private $value;

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
     * Set advertisment
     *
     * @param integer $advertisment
     *
     * @return AdvertisementAttribute
     */
    public function setAdvertisement($advertisment)
    {
        $this->advertisement = $advertisment;

        return $this;
    }

    /**
     * Get advertisment
     *
     * @return integer
     */
    public function getAdvertisement()
    {
        return $this->advertisement;
    }

    /**
     * Set attribute
     *
     * @param integer $attribute
     *
     * @return AdvertisementAttribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return integer
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return AdvertisementAttribute
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
}
