<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFavoriteAdvert
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\ProductsRepository")
 */
class ProductsAttributes
{
    const ATTRIBUTE_TYPE_STRING = 1;
    const ATTRIBUTE_TYPE_NUMBER = 2;
    const ATTRIBUTE_TYPE_SELECT = 3;
    const ATTRIBUTE_TYPE_BOOL = 4;

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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(name="type", type="smallint", options={"unsigned"=true})
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="comment", type="string", length=64)
     */
    private $comment;
}
