<?php namespace VelovitoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Advertisement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\AdvertisementAttributesRepository")
 */
class AdvertisementAttributes
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
     * @ORM\Column(name="advertisment_id", type="integer", options={"unsigned"=true})
     */
    private $advertisment;

    /**
     * @var string
     * @ORM\Column(name="attribute_id", type="integer", options={"unsigned"=true})
     */
    private $attribute;

    /**
     * @var string
     * @ORM\Column(name="$value", type="integer", options={"unsigned"=true})
     */
    private $value;
}