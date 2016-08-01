<?php

namespace VelovitoBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;
use VelovitoBundle\Entity\ProductAttribute;

class EditAttributeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $options['data'];

        $builder->add(
            C::FORM_TITLE,
            TextType::class,
            [
                'label' => 'Новый аттрибут',
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_COMMENT,
            TextType::class,
            [
                'label' => 'Комментарий',
                'required' => false,
            ]
        );

        $builder->add(
            C::FORM_ATTRIBUTE_TYPE,
            ChoiceType::class,
            [
                'label'    => 'Тип',
                'choices'  => ProductAttribute::getTypesList(true),
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_REFERENCE,
            ChoiceType::class,
            [
                'label'    => 'Список',
                'choices'  => $data[C::FORM_REFERENCE_LIST],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label' => 'Сохранить',
            ]
        );
    }

    public function getName()
    {
        return 'form';
    }
}
