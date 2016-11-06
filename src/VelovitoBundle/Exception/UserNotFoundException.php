<?php

namespace VelovitoBundle\Exception;

class UserNotFoundException extends \Exception
{
    public function __construct()
    {
        $this->message = 'User not found';
    }
}