<?php

namespace VelovitoBundle\Twig;

class PriceExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }

    public function priceFilter($price)
    {
        if ($price * 100 % 100 === 0) {
            $price = number_format($price, 0, '.', '');
        } else {
            $price = number_format($price, 2, ',', '');
        }

        return $price;
    }

    public function getName()
    {
        return 'price';
    }
}
