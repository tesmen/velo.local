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
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\VelovitoBundle\Entity\CatalogCategory", inversedBy="catalogItems")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="CatalogCategory", mappedBy="parent")
     */
    private $catalogItems;

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
     * Set parent
     *
     * @param \VelovitoBundle\Entity\CatalogCategory $parent
     *
     * @return CatalogCategory
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

    /**
     * Add catalogItem
     *
     * @param \VelovitoBundle\Entity\CatalogCategory $catalogItem
     *
     * @return CatalogCategory
     */
    public function addCatalogItem(\VelovitoBundle\Entity\CatalogCategory $catalogItem)
    {
        $this->catalogItems[] = $catalogItem;

        return $this;
    }

    /**
     * Remove catalogItem
     *
     * @param \VelovitoBundle\Entity\CatalogCategory $catalogItem
     */
    public function removeCatalogItem(\VelovitoBundle\Entity\CatalogCategory $catalogItem)
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
