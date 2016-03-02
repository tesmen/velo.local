<?php

namespace AppBundle\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\C;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_USERNAME,
            TextType::class,
            [
                'label'    => 'Имя пользователя',
                'required' => true,
                'attr'     => [
                    'placeholder' => 'Имя пользователя',
                ],
            ]
        );

        $builder->add(
            C::FORM_EMAIL,
            TextType::class,
            [
                'label'    => 'Электронная почта',
                'required' => true,
                'attr'     => [
                    'placeholder' => 'Электронная почта',
                ],
            ]
        );

        $builder->add(
            C::FORM_PASSWORD,
            PasswordType::class,
            [
                'label'    => C::FORM_PASSWORD,
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_CONFIRM_PASSWORD,
            PasswordType::class,
            [
                'label'    => C::FORM_CONFIRM_PASSWORD,
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label' => 'Регистрация',
            ]
        );
    }

    public function getName()
    {
        return 'register';
    }
}