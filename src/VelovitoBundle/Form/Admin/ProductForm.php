<?php

namespace VelovitoBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;

class ProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $options['data'];

        $builder->add(
            C::FORM_TITLE,
            TextType::class,
            [
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_CATEGORY,
            ChoiceType::class,
            [
                'label'    => 'Категория',
                'choices'  => $data[C::FORM_CATEGORY],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label' => 'Ok',
            ]
        );
    }

    public function getName()
    {
        return 'upload_photo';
    }
}


