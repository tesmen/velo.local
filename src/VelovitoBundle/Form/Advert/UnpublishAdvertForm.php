<?php

namespace VelovitoBundle\Form\Advert;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;
use VelovitoBundle\Entity\Advertisement;

class UnpublishAdvertForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_SOLD_AT_VELOVITO,
            SubmitType::class,
            [
                'label' => 'Продано на ВелоВито',
            ]
        );

        $builder->add(
            C::FORM_SOLD_SOMEWHERE,
            SubmitType::class,
            [
                'label' => 'Продано где-то ещё',
            ]
        );

        $builder->add(
            C::FORM_OTHER_REASON,
            SubmitType::class,
            [
                'label' => 'Другая причина',
            ]
        );
    }

    public function getName()
    {
        return 'form';
    }
}