<?php

namespace VelovitoBundle\Twig;

class YesNoExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('yes_no', [$this, 'paramsFilter']),
        ];
    }

    public function paramsFilter($in, $yes, $no)
    {
        switch((bool)$in){
            case true:
                return $yes;
            case false:
                return $no;
        }
    }

    public function getName()
    {
        return 'yes_no';
    }
}
