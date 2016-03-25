<?php namespace VelovitoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CatalogCategory
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\CatalogCategoryRepository")
 */
class CatalogCategory
{
    public function __construct()
    {
        $this->catalogItems = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false, length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", nullable=false, length=64, unique=true)
     */
    private $alias;

    /**
     * @ORM\OneToMany(targetEntity="CatalogItem", mappedBy="category")
     */
    private $catalogItems;

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return CatalogCategory
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return CatalogCategory
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
     * Set alias
     *
     * @param string $alias
     *
     * @return CatalogCategory
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

    /**
     * Add catalogItem
     *
     * @param \VelovitoBundle\Entity\CatalogItem $catalogItem
     *
     * @return CatalogCategory
     */
    public function addCatalogItem(\VelovitoBundle\Entity\CatalogItem $catalogItem)
    {
        $this->catalogItems[] = $catalogItem;

        return $this;
    }

    /**
     * Remove catalogItem
     *
     * @param \VelovitoBundle\Entity\CatalogItem $catalogItem
     */
    public function removeCatalogItem(\VelovitoBundle\Entity\CatalogItem $catalogItem)
    {
        $this->catalogItems->removeElement($catalogItem);
    }

    /**
     * Get catalogItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCatalogItems()
    {
        return $this->catalogItems;
    }
}
