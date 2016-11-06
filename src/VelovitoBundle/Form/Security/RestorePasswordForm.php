<?php

namespace VelovitoBundle\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RestorePasswordForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_EMAIL,
            TextType::class,
            [
                'label'    => 'Электронная почта',
                'required' => true,
                'attr'     => [
                    'placeholder'  => 'Электронная почта',
                    'maxlength'    => C::GLOBAL_EMAIL_LENGTH,
                    'autocomplete' => 'off',
                    'required'     => true,
                ],
            ]
        );

        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label' => 'Сбросить пароль',
            ]
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
            }
        );
    }

    public function getName()
    {
        return 'form';
    }
}