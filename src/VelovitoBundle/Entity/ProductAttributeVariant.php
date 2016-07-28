<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductAttributeVariant
 *
 * @ORM\Table(name="product_attribute_variants")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\GeneralRepository")
 */
class ProductAttributeVariant
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
     * @var integer
     * @ORM\Column(name="variant_list_id", type="integer", nullable=false)
     */
    private $productAttribute;

    /**
     * @var string
     * @ORM\Column(name="value", type="string", length=64, nullable=true)
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
     * Set productAttribute
     *
     * @param integer $productAttribute
     *
     * @return ProductAttributeVariants
     */
    public function setProductAttribute($productAttribute)
    {
        $this->productAttribute = $productAttribute;

        return $this;
    }

    /**
     * Get productAttribute
     *
     * @return integer
     */
    public function getProductAttribute()
    {
        return $this->productAttribute;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return ProductAttributeVariants
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
}
