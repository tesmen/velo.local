<?php

namespace VelovitoBundle\Twig;

class GregwarImageExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('image', [$this, 'paramsFilter']),
        ];
    }

    public function paramsFilter($in, $width, $heigth)
    {
        return 'image';
    }

    public function getName()
    {
        return 'image';
    }
}
