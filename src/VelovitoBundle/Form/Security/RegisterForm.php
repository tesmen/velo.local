<?php

namespace VelovitoBundle\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
                'label'    => 'Пароль',
                'required' => true,
                'attr'     => [
                    'placeholder' => 'Пароль',
                ],
            ]
        );

        $builder->add(
            C::FORM_CONFIRM_PASSWORD,
            PasswordType::class,
            [
                'label'    => 'Подтверждение пароля',
                'required' => true,
                'attr'     => [
                    'placeholder' => 'Подтверждение пароля',
                ],
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label' => 'Регистрация',
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();

                $username = $data[C::FORM_USERNAME];
                if ($username === '') {
                    $form->get(C::FORM_USERNAME)->addError(new FormError('Обязательное поле'));
                } elseif (!preg_match('/^([0-9A-Za-z]){2,32}$/', $username)) {
                    $form->get(C::FORM_USERNAME)->addError(new FormError('Неверно указано имя пользователя'));
                }

                $email = $data[C::FORM_EMAIL];
                if ($email === '') {
                    $form->get(C::FORM_EMAIL)->addError(new FormError('Обязательное поле'));
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $form->get(C::FORM_EMAIL)->addError(new FormError('Неверно указан email'));
                }
            }
        );
    }

    public function getName()
    {
        return 'register';
    }
}