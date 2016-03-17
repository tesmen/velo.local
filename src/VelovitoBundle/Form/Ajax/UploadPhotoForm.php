<?php

namespace VelovitoBundle\Form\Ajax;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;

class UploadPhotoForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            C::FORM_PHOTO,
            FileType::class,
            [
                'required' => true,
            ]
        );

//        $builder->add(
//            C::FORM_SUBMIT,
//            SubmitType::class,
//            [
//                'label' => 'Опубликовать',
//            ]
//        );
    }

    public function getName()
    {
        return 'upload_photo';
    }
}


