<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use VelovitoBundle\C;
use VelovitoBundle\Form\User\UserProfileForm;

class TestController extends GeneralController
{
    public function testAction(Request $request)
    {
        return $this->render(
            '@Velovito/email/greeting.html.twig',
            [
            ]
        );
    }
}