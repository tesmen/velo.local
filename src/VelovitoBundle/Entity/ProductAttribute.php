<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductAttribute
 *
 * @ORM\Table(name="product_attributes")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\GeneralRepository")
 */
class ProductAttribute
{
    const ATTRIBUTE_TYPE_STRING = 1;
    const ATTRIBUTE_TYPE_NUMBER = 2;
    const ATTRIBUTE_TYPE_VARIANT = 3;
    const ATTRIBUTE_TYPE_BOOL = 4;

    public static function getTypesList($invert = false)
    {
        $list = [
            self::ATTRIBUTE_TYPE_STRING  => 'строка',
            self::ATTRIBUTE_TYPE_NUMBER  => 'число',
            self::ATTRIBUTE_TYPE_VARIANT => 'варианты',
            self::ATTRIBUTE_TYPE_BOOL    => 'чекбокс',
        ];

        return $invert
            ? array_flip($list)
            : $list;
    }

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
     * @ORM\Column(name="name", type="string", length=64, nullable=true)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(name="type", type="smallint", options={"unsigned"=true}, nullable=false)
     */
    private $type;

    /**
     * @var integer
     * @ORM\Column(name="product_id", type="integer", options={"unsigned"=true}, nullable=false)
     */
    private $productId;

    /**
     * @var string
     * @ORM\Column(name="comment", type="string", length=64, nullable=true)
     */
    private $comment;

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
     * @return ProductAttribute
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
     * Set type
     *
     * @param integer $type
     *
     * @return ProductAttribute
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return ProductAttribute
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     *
     * @return ProductAttribute
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
}
