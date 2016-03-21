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

class EditAdvertForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * @var $ent Advertisement
         */
        $ent = $options['data']['entity'];

//        $builder->add(
//            C::FORM_CATEGORY,
//            ChoiceType::class,
//            [
//                'data'     => $options[],
//                'label'    => 'Категория',
//                'choices'  => $options['data']['categories'],
//                'required' => true,
//            ]
//        );
//

        $builder->add(
            C::FORM_TITLE,
            TextType::class,
            [
                'data'     => $ent->getTitle(),
                'label'    => 'Название',
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_PRICE,
            TextType::class,
            [
                'data'     => $ent->getPrice(),
                'label'    => "Цена",
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_DESCRIPTION,
            TextareaType::class,
            [
                'data'     => $ent->getDescription(),
                'label'    => 'Описание',
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
    }

    public function getName()
    {
        return 'form';
    }
}