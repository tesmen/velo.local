<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductAttribute
 *
 * @ORM\Table(name="product_attribute_map")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\GeneralRepository")
 */
class ProductAttributeMap
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
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     */
    private $productId;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="VelovitoBundle\Entity\ProductAttribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id", nullable=true)
     */
    private $attribute;

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
     * Set productId
     *
     * @param integer $productId
     *
     * @return ProductAttributeMap
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set referenceId
     *
     * @param ProductAttribute $attribute
     *
     * @return ProductAttributeMap
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get referenceId
     *
     * @return ProductAttribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}
