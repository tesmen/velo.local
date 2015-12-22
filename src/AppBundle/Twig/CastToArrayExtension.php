<?php

namespace AppBundle\Twig;

class CastToArrayExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('cast_to_array', [$this, 'objToArrayFilter']),
        ];
    }

    public function objToArrayFilter($obj)
    {
        $response = [];
            
        foreach ((Array)$obj as $key => $value) {
            $response[$key] =  $value;
        }

        return $response;
    }

    public function getName()
    {
        return 'cast_to_array';
    }
}
