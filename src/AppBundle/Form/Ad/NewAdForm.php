<?php

namespace AppBundle\Form\Ad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\C;

class NewAdForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_CATEGORY,
            ChoiceType::class,
            [
                'label'    => 'Категория',
                'choices'  => [1200, 200,'asd'],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SUBJECT,
            TextType::class,
            [
                'label'    => 'Тема',
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_TEXT,
            TextType::class,
            [
                'label'    => 'Текст',
                'required' => true,
            ]
        );
    }

    public function getName()
    {
        return 'new_ticket';
    }
}