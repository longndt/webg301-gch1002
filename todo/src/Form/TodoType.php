<?php

namespace App\Form;

use App\Entity\Todo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Todo Title',
                'required' => true,
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 20
                ]
            ])
            ->add('description', TextType::class,
            [
                'label' => 'Todo Description'
            ])
            ->add('category', ChoiceType::class,
            [
                'label' => 'Todo Type',
                'choices' => [
                    "Personal" => "Personal",
                    "Work" => "Work",
                    "Study" => "Study",
                    "Family" => "Family"       
                ]
            ])
            ->add('priority', IntegerType::class,
            [
                'label' => 'Todo Priority',
                'attr' => [
                    'min' => 1,
                    'max' => 5
                ]
            ])
            ->add('duedate', DateType::class,
            [
                'label' => 'Todo Deadline',
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}
