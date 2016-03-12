<?php

namespace VelovitoBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;
use VelovitoBundle\Entity\User;

class UserProfileForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['data'];

        $builder->add(
            C::FORM_USERNAME,
            TextType::class,
            [
                'data'     => $user->getUsername(),
                'label'    => 'Ник',
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_EMAIL,
            TextType::class,
            [
                'data'     => $user->getEmail(),
                'label'    => 'Почта',
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_REGISTERED_DATE,
            TextType::class,
            [
                'data'     => $user->getRegisteredDate()->format('d m Y'),
                'label'    => 'С нами с...',
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label' => 'New!',
            ]
        );
    }

    public function getName()
    {
        return 'new_ticket';
    }
}