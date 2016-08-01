<?php

namespace VelovitoBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;

class NewReferenceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_TITLE,
            TextType::class,
            [
                'label'    => 'Новый список',
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_COMMENT,
            TextType::class,
            [
                'label'    => 'Комментарий',
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
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


