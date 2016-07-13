<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFavoriteAdvert
 *
 * @ORM\Table(name="product_attributes")
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\ProductAttributesRepository")
 */
class ProductAttributes
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
     * @var string
     * @ORM\Column(name="comment", type="string", length=64, nullable=true)
     */
    private $comment;
}
