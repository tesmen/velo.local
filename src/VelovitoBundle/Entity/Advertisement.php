<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Advertisement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\AdvertisementRepository")
 */
class Advertisement
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
     * @ORM\Column(name="title", type="string", length=64)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="VelovitoBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="VelovitoBundle\Entity\Currency")
     * @ORM\JoinColumn(name="currency", referencedColumnName="id")
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=4096)
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
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set user
     *
     * @param \VelovitoBundle\Entity\User $user
     *
     * @return Advertisement
     */
    public function setUser(\VelovitoBundle\Entity\User $user = null)
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
     * Set status
     *
     * @param integer $status
     *
     * @return Advertisement
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set currency
     *
     * @param Currency $currency
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
}
