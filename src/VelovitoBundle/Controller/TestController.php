<?php

namespace VelovitoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\C;
use VelovitoBundle\Entity\Product;
use VelovitoBundle\Model\SecurityModel;

class TestController extends GeneralController
{
    public function testAction(Request $request)
    {
        /**
         * @var $em EntityManager
         * @var $secModel SecurityModel
         */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
//        $secModel = $this->container->get(C::MODEL_SECURITY);
//        $userRepo = $em->getRepository(C::REPO_USER);
//
//        $user = $userRepo->find(1);
//        $secModel->forceAuthenticate($user);
        $prodRepo = $em->getRepository(C::REPO_PRODUCT);

        $prod = new Product();
        $prod
            ->setName('asd')
//            ->setCategory(1)
            ->setActive(true);
        $em->persist($prod);
        $em->flush();

    }
}