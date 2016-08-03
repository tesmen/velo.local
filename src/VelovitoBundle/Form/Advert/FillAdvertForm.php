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
            switch ($attribute->getType()) {
                case ProductAttribute::ATTRIBUTE_TYPE_NUMBER:
                    $builder->add('field' . $attribute->getId(),
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
                    $builder->add('field' . $attribute->getId(),
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
                        C::FORM_IS_ACTIVE,
                        CheckboxType::class,
                        [
                            'label'    => $attribute->getName(),
                            'required' => false,
                        ]
                    );
                    break;
                case ProductAttribute::ATTRIBUTE_TYPE_REFERENCE:
                    $builder->add(
                        C::FORM_CATEGORY,
                        ChoiceType::class,
                        [
                            'label'    => 'Категория',
                            'choices'  => [],
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
