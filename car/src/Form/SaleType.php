<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Customer;
use App\Entity\Sale;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('discount')
            ->add(
                'car',
                EntityType::class,
                [
                    'class' => Car::class,
                    'choice_label' => 'make'
                ]
            )
            ->add(
                'customer',
                EntityType::class,
                [
                    'class' => Customer::class,
                    'choice_label' => 'name'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sale::class,
        ]);
    }
}
