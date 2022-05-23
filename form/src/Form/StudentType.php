<?php

namespace App\Form;

use App\Entity\Student;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'label' => 'Full Name',
                'required' => true,
                'attr' =>
                [
                    'minlength' => 5,
                    'maxlength' => 30
                ]
            ])
            ->add('age', IntegerType::class,
            [
                'label' => 'Actual Age',
                'required' => true,
                'attr' =>
                [
                    'min' => 18,
                    'max' => 23
                ]
            ])
            ->add('grade', NumberType::class,
            [
                'label' => 'Average Grade',
                'required' => true
            ])
            ->add('gender', ChoiceType::class,
            [
                'label' => 'Student Gender',
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female'
                ],
                'expanded' => true // false (default): drop-down list (select) |  true : radio button
            ])
            ->add('enrol', DateType::class,
            [
                'label' => 'Enrolment Date',
                'widget' => 'single_text'
            ])
            ->add('graduate', ChoiceType::class,
            [
                'label' => 'Is Graduated ?',
                'choices' => [
                    'Graduate' => 'Yes',
                    'Ungraduate' => 'No'
                    //Bên trái dấu => là giá trị hiển thị ở View
                    //Bên phải dấu => là giá trị lưu trong Database
                    //2 giá trị có thể giống hoặc khác nhau
                ]
            ])
            ->add('image', TextType::class,
            [
                'label' => 'Student Avatar'
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
