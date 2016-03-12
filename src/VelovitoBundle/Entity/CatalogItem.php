<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\CatalogItemRepository")
 */
class CatalogItem
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
     * @ORM\ManyToOne(targetEntity="\VelovitoBundle\Entity\CatalogCategory")
     * @ORM\JoinColumn(referencedColumnName="id", unique=true)
     */
    private $item;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\VelovitoBundle\Entity\CatalogCategory")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, length=64)
     */
    private $override;

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
     * Set override
     *
     * @param string $override
     *
     * @return CatalogItem
     */
    public function setOverride($override)
    {
        $this->override = $override;

        return $this;
    }

    /**
     * Get override
     *
     * @return string
     */
    public function getOverride()
    {
        return $this->override;
    }

    /**
     * Set item
     *
     * @param \VelovitoBundle\Entity\CatalogCategory $item
     *
     * @return CatalogItem
     */
    public function setItem(\VelovitoBundle\Entity\CatalogCategory $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \VelovitoBundle\Entity\CatalogCategory
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set parent
     *
     * @param \VelovitoBundle\Entity\CatalogCategory $parent
     *
     * @return CatalogItem
     */
    public function setParent(\VelovitoBundle\Entity\CatalogCategory $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \VelovitoBundle\Entity\CatalogCategory
     */
    public function getParent()
    {
        return $this->parent;
    }
}
