<?php

namespace VelovitoBundle\Exception;

class ConsistencyException extends \Exception
{
    private $route;

    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute($route)
    {
        $this->route = $route;
    }
}