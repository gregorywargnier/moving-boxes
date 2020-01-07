<?php

namespace App\Form;

use App\Entity\Boxes;
use App\Entity\Rooms;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoxesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('name')
            ->add('origin', EntityType::class, [
                'class' => Rooms::class,
                'choice_label' => "name",
            ])
            ->add('destination', EntityType::class, [
                'class' => Rooms::class,
                'choice_label' => "name",
            ])
            ->add('content')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Boxes::class,
        ]);
    }
}
