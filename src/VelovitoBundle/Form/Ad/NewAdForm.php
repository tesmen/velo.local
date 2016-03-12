<?php

namespace VelovitoBundle\Form\Ad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;

class NewAdForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_CATEGORY,
            ChoiceType::class,
            [
                'label'    => 'Категория',
                'choices'  => $options['data']['categories'],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_STATUS,
            ChoiceType::class,
            [
                'label'    => 'Статус',
                'choices'  => $options['data']['ad_statuses'],
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
            C::FORM_SAVE,
            SubmitType::class,
            [
                'label' => 'Cохранить',
            ]
        );

        $builder->add(
            C::FORM_PUBLISH,
            SubmitType::class,
            [
                'label' => 'Опубликовать',
            ]
        );
    }

    public function getName()
    {
        return 'new_ad';
    }
}