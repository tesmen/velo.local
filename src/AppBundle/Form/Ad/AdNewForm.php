<?php

namespace AppBundle\Form\Ad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\C;

class AdNewForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_TARIFF,
            ChoiceType::class,
            [
                'label'    => 'Категория',
                'choices'  => [1200, 200,'asd'],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_TITLE,
            TextType::class,
            [
                'label'    => C::FORM_TITLE,
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_PRICE,
            TextType::class,
            [
                'label'    => C::FORM_PRICE,
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label'    => 'New!',
            ]
        );
    }

    public function getName()
    {
        return 'new_ticket';
    }
}