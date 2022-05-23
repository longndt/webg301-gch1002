<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Tên',
                'required' => true,
                'attr' =>
                [
                    'minlength' => 5,
                    'maxlength' => 15
                ]
            ])
            ->add('age', IntegerType::class,
            [
                'label' => 'Tuổi',
                'required' => true,
                'attr' =>
                [
                    'min' => 18,
                    'max' => 23
                ]
            ])
            ->add('grade', NumberType::class,
            [
                'label' => 'Điểm',
                'required' => true
            ])
            ->add("Add", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
