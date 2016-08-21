<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductCategory
 *
 * @ORM\Table(name="attribute_reference_items")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\GeneralRepository")
 */
class AttributeReferenceItem
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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="AttributeReference", inversedBy="items")
     * @ORM\JoinColumn(name="reference_id", referencedColumnName="id")
     */
    private $reference;

    /**
     * @var string
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

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
     * @return AttributeReferenceItem
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
     * Set active
     *
     * @param boolean $isActive
     *
     * @return Product
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
