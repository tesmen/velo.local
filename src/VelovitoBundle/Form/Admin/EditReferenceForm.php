<?php

namespace VelovitoBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;

class EditReferenceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_TITLE,
            TextType::class,
            [
                'label'    => 'Название',
                'required' => true,
            ]
        );

        $builder->add(
            'item_name',
            TextType::class,
            [
                'label'    => 'Новый элемент',
                'required' => false,
            ]
        );

        $builder->add(
            C::FORM_COMMENT,
            TextType::class,
            [
                'label'    => 'Комментарий',
                'required' => false,
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
            C::FORM_SAVE,
            SubmitType::class,
            [
                'label' => 'Сохранить',
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


