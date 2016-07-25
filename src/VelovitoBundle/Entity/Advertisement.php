<?php namespace VelovitoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Advertisement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\AdvertisementRepository")
 */
class Advertisement
{
    const CURRENCY_RUB = 1;
    const CURRENCY_GRN = 2;
    const CURRENCY_USD = 3;
    const CURRENCY_EUR = 4;

    public static function getCurrencyList($invert = false)
    {
        $list = [
            self::CURRENCY_RUB => 'руб.',
            self::CURRENCY_GRN => 'грн.',
            self::CURRENCY_USD => 'долл.',
            self::CURRENCY_EUR => 'евро',
        ];

        return $invert
            ? array_flip($list)
            : $list;
    }

    public function getCurrencyName($id = null)
    {
        if (empty($id)) {
            return self::getCurrencyList()[$this->currency];
        }

        return self::getCurrencyList()[$id];
    }

    public function __construct()
    {
        $this->creationDate = new \DateTime();
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
     * @ORM\Column(name="title", type="string", length=128)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="integer", options={"unsigned"=true})
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="VelovitoBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_published", type="boolean", nullable=false)
     */
    private $isPublished;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    private $isDeleted;

    /**
     * @var integer
     *
     * @ORM\Column(name="views_count", type="integer", nullable=true)
     */
    private $viewsCount;

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="VelovitoBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true)
     */
    private $product;

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="VelovitoBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_category_id", referencedColumnName="id", nullable=true)
     */
    private $productCategory;

    /**
     * @var integer
     * @ORM\Column(name="currency", type="smallint", nullable=false, options={"unsigned"=true})
     */
    private $currency;

    /**
     * @var string
     * @ORM\OneToOne(targetEntity="VelovitoBundle\Entity\UserPhoto")
     * @ORM\JoinColumn(name="user_photo_id", referencedColumnName="id", nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=8096, nullable=true)
     */
    private $description;

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
     * Set title
     *
     * @param string $title
     *
     * @return Advertisement
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Advertisement
     */
    public function setCreationDate($createdDate)
    {
        $this->creationDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set user
     *
     * @param \VelovitoBundle\Entity\User $user
     *
     * @return Advertisement
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \VelovitoBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Advertisement
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set currency
     *
     * @param integer $currency
     *
     * @return Advertisement
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return integer
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Advertisement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set viewsCount
     *
     * @param integer $viewsCount
     *
     * @return Advertisement
     */
    public function setViewsCount($viewsCount)
    {
        $this->viewsCount = $viewsCount;

        return $this;
    }

    /**
     * Get viewsCount
     *
     * @return integer
     */
    public function getViewsCount()
    {
        return $this->viewsCount;
    }

    /**
     * Set isPublished
     *
     * @param boolean $isPublished
     *
     * @return Advertisement
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get isPublished
     *
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Advertisement
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set photo
     *
     * @param \VelovitoBundle\Entity\UserPhoto $photo
     *
     * @return Advertisement
     */
    public function setPhoto(UserPhoto $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \VelovitoBundle\Entity\UserPhoto
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set productId
     *
     * @param Product $product
     *
     * @return Advertisement
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get productId
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set productCategoryId
     *
     * @param ProductCategory $productCategory
     *
     * @return Advertisement
     */
    public function setProductCategory($productCategory)
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    /**
     * Get productCategoryId
     *
     * @return ProductCategory
     */
    public function getProductCategory()
    {
        return $this->productCategory;
    }
}
