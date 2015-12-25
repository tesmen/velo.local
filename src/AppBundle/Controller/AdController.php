<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Ad\AdNewForm;
use AppBundle\C;

class AdController extends Controller
{
    /**
     * @Route("/ad-list", name="ad_list")
     */
    public function adListAction(Request $request)
    {
        return $this->render(
            'ad/ad_list.html.twig',
            [
                'ads' => $this->get(C::MODEL_ADVERTISEMENT)->getAllAds(),
            ]
        );
    }

    /**
     * @Route("/ad-new", name="ad_new")
     */
    public function adNewAction(Request $request)
    {
        $form = $this->createForm(AdNewForm::class);

        try{
            if($request->isMethod('POST')){
                $form->handleRequest($request);
                $this->get('advertisement_service')->createAd($form->getData());
                return $this->redirectToRoute('ad_list');
            }
        }catch (\Exception $e){
            var_dump($e->getMessage());
        }

        return $this->render(
            'ad/ad_new.html.twig',
            [
                'form' => $form->createView(),
                'ads' => $this->get(C::MODEL_ADVERTISEMENT)->getAllAds(),
            ]
        );
    }

    /**
     * @Route("/ad-view/{adId}", name="ad_view")
     */
    public function adViewAction(Request $request, $adId)
    {
        return $this->render(
            'ad/ad_view.html.twig',
            [
                'ad' => $this->get(C::MODEL_ADVERTISEMENT)->getAdById($adId),
            ]
        );
    }
}
