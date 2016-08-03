<?php

namespace VelovitoBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;

class EditProductForm extends AbstractType
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
                'choices'  => $data[C::FORM_CATEGORY_LIST],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_ATTRIBUTE,
            ChoiceType::class,
            [
                'label'    => 'Добавить аттрибут',
                'choices'  => $data[C::FORM_ATTRIBUTE_TYPE_LIST],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_IS_ACTIVE,
            CheckboxType::class,
            [
                'label'    => 'active',
                'required' => false,
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label' => 'Ok',
            ]
        );

        $builder->add(
            C::FORM_ADD,
            SubmitType::class,
            [
                'label' => 'Добавить',
            ]
        );
    }

    public function getName()
    {
        return 'form';
    }
}
