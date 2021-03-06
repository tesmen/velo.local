<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductAttribute
 *
 * @ORM\Table(name="product_attributes")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\GeneralRepository")
 */
class ProductAttribute extends AbstractAttribute
{
    const FORM_PREFIX = 'attribute_';

    const ATTRIBUTE_TYPE_STRING    = 1;
    const ATTRIBUTE_TYPE_NUMBER    = 2;
    const ATTRIBUTE_TYPE_REFERENCE = 3;
    const ATTRIBUTE_TYPE_BOOL      = 4;

    public static function getTypesList($invert = false)
    {
        $list = [
            self::ATTRIBUTE_TYPE_STRING    => 'строка',
            self::ATTRIBUTE_TYPE_NUMBER    => 'число',
            self::ATTRIBUTE_TYPE_REFERENCE => 'список на выбор',
            self::ATTRIBUTE_TYPE_BOOL      => 'чекбокс',
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
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(name="type", type="smallint", options={"unsigned"=true}, nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="AttributeReference")
     * @ORM\JoinColumn(name="reference_id", referencedColumnName="id", nullable=true)
     */
    private $reference;

    /**
     * @var integer
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string
     * @ORM\Column(name="comment", type="string", length=64, nullable=true)
     */
    private $comment;

    /**
     * @var string
     * @ORM\Column(name="alias", type="string", length=32, nullable=true)
     */
    private $alias;

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
     * Set active
     *
     * @param boolean $active
     *
     * @return ProductAttribute
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set referenceId
     *
     * @param AttributeReference $reference
     *
     * @return AttributeReferenceItem
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get referenceId
     *
     * @return AttributeReference
     */
    public function getReference()
    {
        return $this->reference;
    }



    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return ProductAttribute
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
