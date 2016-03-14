<?php

namespace VelovitoBundle\Form\Ad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;
use VelovitoBundle\Entity\Advertisement;

class EditAdForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * @var $ent Advertisement
         */
        $ent = $options['data']['obj'];

        $builder->add(
            C::FORM_CATEGORY,
            ChoiceType::class,
            [
                'data'     => null,
                'label'    => 'Категория',
                'choices'  => $options['data']['categories'],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_STATUS,
            ChoiceType::class,
            [
                'data'     => $ent->getStatus(),
                'label'    => 'Статус',
                'choices'  => $options['data']['ad_statuses'],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_TITLE,
            TextType::class,
            [
                'data'     => $ent->getTitle(),
                'label'    => C::FORM_TITLE,
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_PRICE,
            TextType::class,
            [
                'data'     => $ent->getPrice(),
                'label'    => C::FORM_PRICE,
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_DESCRIPTION,
            TextareaType::class,
            [
                'data'     => $ent->getDescription(),
                'label'    => C::FORM_DESCRIPTION,
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SAVE,
            SubmitType::class,
            [
                'label' => 'Cохранить черновик',
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