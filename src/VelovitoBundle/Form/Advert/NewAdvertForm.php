<?php

namespace VelovitoBundle\Form\Advert;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;

class NewAdvertForm extends AbstractType
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
                'label'    => "Название",
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_PRICE,
            TextType::class,
            [
                'label'    => "Цена",
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_DESCRIPTION,
            TextareaType::class,
            [
                'label'    => "Описание",
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label' => 'Готово',
            ]
        );
    }

    public function getName()
    {
        return 'new_ad';
    }
}