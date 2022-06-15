<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Lecturer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LecturerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Full name'
            ])
            ->add('dateofbirth', DateType::class,
            [
                'label' => 'Date of birth',
                'widget' => 'single_text'
            ])
            ->add('email', TextType::class,
            [
                'label' => 'Email address'
            ])
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
            ->add('image', FileType::class,
            [
                'label' => 'Lecturer image',
                'data_class' => null,
                'required' => is_null($builder->getData()->getImage())
                            //is_null : boolean
                            //if image is null => required = true
                            //else if image is not null => required = false
            ])
            ->add('course', EntityType::class,
            [
                'label' => 'Course name',
                'required' => true,
                'class' => Course::class,
                'choice_label' => 'name',
                'multiple' => true, //to select many options -> Hold CTRL to select many
                'expanded' => false //false: drop-down (select) 
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
