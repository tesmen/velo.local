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
                    'maxlength'   => C::GLOBAL_USERNAME_LENGTH,
                    'autocomplete' => 'off'
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
                    'maxlength'   => C::GLOBAL_EMAIL_LENGTH,
                    'autocomplete' => 'off'
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
                    'maxlength'   => C::GLOBAL_PASSWORD_LENGTH,
                    'autocomplete' => 'off'
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
                    'maxlength'   => C::GLOBAL_PASSWORD_LENGTH,
                    'autocomplete' => 'off'
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
                $formData = $event->getData();
                $username = $formData[C::FORM_USERNAME];

                if (empty($username)) {
                    $form->get(C::FORM_USERNAME)->addError(new FormError('Обязательное поле'));
                }

                if (strlen($username) > C::GLOBAL_USERNAME_LENGTH) {
                    $form->get(C::FORM_USERNAME)->addError(
                        new FormError(
                            sprintf('Максимальная длина %s символов', C::GLOBAL_USERNAME_LENGTH)
                        )
                    );
                }

                if (!preg_match(sprintf('/^([0-9A-Za-z]){2,%s}$/', C::GLOBAL_USERNAME_LENGTH), $username)) {
                    $form->get(C::FORM_USERNAME)->addError(new FormError('Неверно символы в имени пользователя'));
                }
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $formData = $event->getData();
                $email = $formData[C::FORM_EMAIL];

                if (empty($email)) {
                    $form->get(C::FORM_EMAIL)->addError(new FormError('Обязательное поле'));
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $form->get(C::FORM_EMAIL)->addError(new FormError('Неверно указан email'));
                }

                if (strlen($email) > C::GLOBAL_EMAIL_LENGTH) {
                    $form->get(C::FORM_EMAIL)->addError(
                        new FormError(
                            sprintf('Максимальная длина %s символов', C::GLOBAL_EMAIL_LENGTH)
                        )
                    );
                }
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $formData = $event->getData();
                $password = $formData[C::FORM_PASSWORD];

                if (!preg_match(sprintf('/^([0-9A-Za-z]){2,%s}$/', C::GLOBAL_PASSWORD_LENGTH), $password)) {
                    $form->get(C::FORM_PASSWORD)->addError(new FormError('Неверные символы'));
                }

                if ($password !== $formData[C::FORM_CONFIRM_PASSWORD]) {
                    $form->get(C::FORM_CONFIRM_PASSWORD)->addError(new FormError('Пароли не совпадают'));
                }
            }
        );
    }

    public function getName()
    {
        return 'register';
    }
}