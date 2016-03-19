<?php

namespace VelovitoBundle\Twig;

class TariffParamsExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('tariff_params', [$this, 'paramsFilter']),
        ];
    }

    public function paramsFilter($in)
    {
        return str_replace(
            ['(', ')'],
            ['<span>','</span>'],
            $in
        );
    }

    public function getName()
    {
        return 'tariff_params';
    }
}
