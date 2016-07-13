<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFavoriteAdvert
 *
 * @ORM\Table(name="product_attribute_variants")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\ProductAttributeVariantsRepository")
 */
class ProductAttributeVariants
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
     * @ORM\Column(name="product_attribute_id", type="integer", nullable=false)
     */
    private $productAttribute;

    /**
     * @var string
     * @ORM\Column(name="value", type="string", length=64, nullable=true)
     */
    private $value;
}
