<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Lecturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LecturerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('dateofbirth', DateType::class)
            ->add('email', TextType::class)
            ->add('address', ChoiceType::class,
            [
                'label' => 'Campus',
                'required' => true,
                'choices' => [
                    'Ha Noi' => 'Ha Noi',
                    'HCM City' => 'HCM City',
                    'Da Nang' => 'Da Nang',
                    'Can Tho' => 'Can Tho'
                ],
                'multiple' => false,
                'expanded' => true
            ])
            ->add('image', TextType::class)
            ->add('course', EntityType::class,
            [
                'label' => 'Course name',
                'required' => true,
                'class' => Course::class,
                'choice_label' => 'name',
                'multiple' => true, //to select many options 
                'expanded' => false //false: drop-down (select) -> Hold CTRL to select many
                                    //true: check-box       
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lecturer::class,
        ]);
    }
}
