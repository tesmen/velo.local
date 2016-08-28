<?php

namespace VelovitoBundle\Form\Advert;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use VelovitoBundle\C;
use VelovitoBundle\Entity\ProductAttribute;
use VelovitoBundle\Service\CommonFunction;

class FillAdvertForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * @var $attributes ProductAttribute[]
         */
        $data = $options['data'];
        $attributes = $data[C::FORM_ATTRIBUTE_LIST];

        foreach ($attributes as $attribute) {
            $formId = $attribute->getFormId();

            switch ($attribute->getType()) {
                case ProductAttribute::ATTRIBUTE_TYPE_NUMBER:
                    $builder->add(
                        $formId,
                        TextType::class,
                        [
                            'label'    => $attribute->getName(),
                            'required' => false,
                            'attr'     => [
                                'class' => 'generated_number_type',
                            ],
                        ]
                    );

                    break;

                case ProductAttribute::ATTRIBUTE_TYPE_STRING:
                    $builder->add(
                        $formId,
                        TextType::class,
                        [
                            'label'    => $attribute->getName(),
                            'required' => false,
                            'attr'     => [
                                'class' => 'generated_string_type',
                            ],
                        ]
                    );

                    break;
                    break;
                case ProductAttribute::ATTRIBUTE_TYPE_BOOL:
                    $builder->add(
                        $formId,
                        CheckboxType::class,
                        [
                            'label'    => $attribute->getName(),
                            'required' => false,
                        ]
                    );
                    break;
                case ProductAttribute::ATTRIBUTE_TYPE_REFERENCE:
                    $builder->add(
                        $formId,
                        ChoiceType::class,
                        [
                            'label'    => $attribute->getName(),
                            'choices'  => CommonFunction::entitiesToFormView($attribute->getReference()->getItems()),
                            'required' => true,
                        ]
                    );
                    break;
            }
        }


        $builder->add(
            C::FORM_SUBMIT,
            SubmitType::class,
            [
                'label' => 'Готово',
            ]
        );
    }

    public function getName()
    {
        return 'add_advert';
    }
}
