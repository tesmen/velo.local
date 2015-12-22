<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Ad\NewAdForm;

class AdController extends Controller
{
    /**
     * @Route("/ad-view/{id}")
     */
    public function indexAction(Request $request, $id)
    {
        return new Response($id, 200);
    }

    /**
     * @Route("/ad-list", name="ad_list")
     */
    public function adListAction(Request $request)
    {

        return $this->render(
            'ad/list.html.twig',
            [
                'ads' => $this->get('advertisement_service')->getAllAds(),
            ]
        );
    }

    /**
     * @Route("/ad-new", name="ad_new")
     */
    public function adNewAction(Request $request)
    {
        $form = $this->createForm(NewAdForm::class);

        return $this->render(
            'ad/ad_new.html.twig',
            [
                'form' => $form->createView(),
                'ads' => $this->get('advertisement_service')->getAllAds(),
            ]
        );
    }
}
