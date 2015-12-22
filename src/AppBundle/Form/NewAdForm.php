<?php

namespace Artvisio\DockerBillingBundle\Form\Support;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Artvisio\DockerBillingBundle\C;

class NewTicketForm extends AbstractType
{
    private $formsData;

    public function __construct($formsData, $defaults)
    {
        $this->formsData = $formsData;
        $this->defaults = $defaults;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_CATEGORY,
            'choice',
            [
                'label'    => 'Категория',
                'data'     => isset($this->defaults[C::FORM_CATEGORY]) ? $this->defaults[C::FORM_CATEGORY] : '',
                'choices'  => $this->formsData[C::FORM_CATEGORY],
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_SUBJECT,
            'text',
            [
                'data'     => isset($this->defaults[C::FORM_SUBJECT]) ? $this->defaults[C::FORM_SUBJECT] : '',
                'label'    => 'Тема',
                'required' => true,
            ]
        );

        $builder->add(
            C::FORM_TEXT,
            'textarea',
            [
                'data'     => isset($this->defaults[C::FORM_TEXT]) ? $this->defaults[C::FORM_TEXT] : '',
                'label'    => 'Текст',
                'required' => true,
            ]
        );

        $builder->add(
            'filename',
            'file',
            [
                'required' => false,
            ]
        );

        $builder->add(
            'filename1',
            'file',
            [
                'required' => false,
            ]
        );

        $builder->add(
            'filename2',
            'file',
            [
                'required' => false,
            ]
        );

        $builder->add(
            'submit',
            'submit',
            [
                'label' => 'Отправить',
            ]
        );
    }

    public function getName()
    {
        return 'new_ticket';
    }
}