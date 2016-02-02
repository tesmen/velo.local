<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\C;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username', TextType::class)
            ->add('password', TextType::class)
            ->add('submit', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        if ($request->isMethod('POST')) {
            $formData = $form->handleRequest($request)->getData();
            try {
                $this->get('model.user')->createuser(
                    $formData['password'],
                    $formData['username']
                );
            } catch (\Exception $e) {
                var_dump($e->getMessage());
                exit;
            }

            return $this->redirectToRoute('register');
        }

        return $this->render(
            'default/register.html.twig',
            [
                C::PAGE_NAME => 'Журнал',
                'form'       => $form->createView(),
            ]
        );
    }
}
