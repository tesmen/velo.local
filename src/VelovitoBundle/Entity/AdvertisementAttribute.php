<?php namespace VelovitoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * AdvertisementAttribute
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
     * @ORM\ManyToOne(targetEntity="VelovitoBundle\Entity\Advertisement", inversedBy="attributes")
     * @ORM\JoinColumn(name="advert_id", referencedColumnName="id", nullable=false)
     */
    private $advertisement;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="VelovitoBundle\Entity\ProductAttribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id", nullable=false)
     */
    private $attribute;

    /**
     * @var string
     * @ORM\Column(name="value", type="string", length=127)
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
     * Set value
     *
     * @param string $value
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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set advertisement
     *
     * @param \VelovitoBundle\Entity\Advertisement $advertisement
     *
     * @return AdvertisementAttribute
     */
    public function setAdvertisement(\VelovitoBundle\Entity\Advertisement $advertisement)
    {
        $this->advertisement = $advertisement;

        return $this;
    }

    /**
     * Get advertisement
     *
     * @return \VelovitoBundle\Entity\Advertisement
     */
    public function getAdvertisement()
    {
        return $this->advertisement;
    }

    /**
     * Set attribute
     *
     * @param \VelovitoBundle\Entity\ProductAttribute $attribute
     *
     * @return AdvertisementAttribute
     */
    public function setAttribute(\VelovitoBundle\Entity\ProductAttribute $attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return \VelovitoBundle\Entity\ProductAttribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}
