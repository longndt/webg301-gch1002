<?php

namespace App\Form;

use App\Entity\SClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Class Name',
                'required' => true,
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 30
                ]
            ])
            ->add('quantity', IntegerType::class,
            [
                'label' => 'Class Quantity',
                'required' => true,
                'attr' => [
                    'min' => 20,
                    'max' => 30
                ]
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SClass::class,
        ]);
    }
}
