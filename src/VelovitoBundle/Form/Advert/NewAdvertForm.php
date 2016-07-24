<?php

namespace VelovitoBundle\Form\Advert;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;
use VelovitoBundle\Entity\Advertisement;

class NewAdvertForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $options['data'];

        $builder->add(
            C::FORM_CATEGORY,
            ChoiceType::class,
            [
                'label'    => 'Категория',
                'choices'  => $data[123],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_CURRENCY,
            ChoiceType::class,
            [
                'label'    => 'Валюта',
                'choices'  => Advertisement::getCurrencyList(true),
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
                'required' => false,
            ]
        );

        $builder->add(
            C::FORM_PHOTO,
            FileType::class,
            [
                'label'    => "Фотография",
                'required' => false,
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
        return 'add_advert';
    }
}
