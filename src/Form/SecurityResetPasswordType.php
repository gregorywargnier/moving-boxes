<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class SecurityResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,

                'first_options'  => [

                    // make it required
                    'required' => true,

                    'label' => 'Password',
                    'label_attr' => [
                        'class' => 'sr-only'
                    ],

                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "New password"
                    ],

                    // Field helper
                    'help' => "Write your new password",
                    'help_attr' => [
                        'class' => "form-text text-muted"
                    ],

                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter your new password',
                        ]),
                    ],
                ],
                
                'second_options' => [

                    // make it required
                    'required' => true,

                    'label' => 'Repeat Password',
                    'label_attr' => [
                        'class' => 'sr-only'
                    ],

                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Repeat new password"
                    ],

                    // Field helper
                    'help' => "Repeat your new password",
                    'help_attr' => [
                        'class' => "form-text text-muted"
                    ],

                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please repeat your new password',
                        ]),
                    ],
                ],

                'invalid_message' => 'The password fields must match.',
                // 'invalid_message_parameters' => ['%num%' => 6],
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
