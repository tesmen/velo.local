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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\VelovitoBundle\Entity\CatalogCategory", inversedBy="catalogItems")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, length=64, unique=true)
     */
    private $alias;

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return CatalogItem
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
     * @return CatalogItem
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
     * @return CatalogItem
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
     * Set category
     *
     * @param \VelovitoBundle\Entity\CatalogCategory $category
     *
     * @return CatalogItem
     */
    public function setCategory(\VelovitoBundle\Entity\CatalogCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \VelovitoBundle\Entity\CatalogCategory
     */
    public function getCategory()
    {
        return $this->category;
    }
}
