<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class SecurityRenewPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Current password',
                'label_attr' => [
                    // 'class' => 'sr-only'
                    'class' => 'offset-1 col-sm-3 col-form-label'
                ],

                // make it required
                'required' => true,

                'mapped' => false,

                'empty_data' => '',

                // Field attributes
                'attr' => [
                    'class' => 'form-control',
                    // 'placeholder' => "Current password"
                ],

                // Field helper
                'help' => "Write your Current password",
                'help_attr' => [
                    'class' => "form-text text-muted"
                ],

                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter current password',
                    ]),
                ],
            ])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                
                // 'label' => 'Email',
                // 'label_attr' => [
                //     'class' => 'sr-only'
                // ],

                // Field attributes
                // 'attr' => [
                //     'class' => 'form-control',
                //     // 'placeholder' => "Email"
                // ],

                'first_options'  => [

                    // make it required
                    'required' => true,

                    'label' => 'Password',
                    'label_attr' => [
                        // 'class' => 'sr-only'
                        'class' => 'offset-1 col-sm-3 col-form-label'
                    ],

                    'attr' => [
                        'class' => 'form-control',
                        // 'placeholder' => "New password"
                    ],

                    // Field helper
                    'help' => "Write your new password",
                    'help_attr' => [
                        'class' => "form-text text-muted"
                    ],

                    'constraints' => [
                        new NotBlank([
                            'message' => "Please enter your new password",
                        ]),
                    ],
                ],
                'second_options' => [

                    'label' => 'Repeat Password',
                    'label_attr' => [
                        // 'class' => 'sr-only'
                        'class' => 'offset-1 col-sm-3 col-form-label'
                    ],

                    'attr' => [
                        'class' => 'form-control',
                        // 'placeholder' => "Repeat new password"
                    ],

                    // Field helper
                    'help' => "Repeat your new password",
                    'help_attr' => [
                        'class' => "form-text text-muted"
                    ],

                    'constraints' => [
                        new NotBlank([
                            'message' => "Please repeat your new password",
                        ]),
                    ],
                ],

                'invalid_message' => "The password fields must match",
                // 'invalid_message_parameters' => ['%num%' => 6],


            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
