<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class SecurityRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            /* User Fisrtsname */
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
                'label_attr' => [
                    'class' => 'sr-only'
                ],

                // make it required
                'required' => true,

                // Field attributes
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Firstname"
                ],

                // Field helper
                // 'help' => "Write your Firstname",
                // 'help_attr' => [
                //     'class' => "form-text text-muted"
                // ],

                'constraints' => [
                    new NotBlank([
                        'message' => "Please enter your firstname",
                    ])
                ],
            ])


            /* User Lastname */
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'label_attr' => [
                    'class' => 'sr-only'
                ],

                // make it required
                'required' => true,

                // Field attributes
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Lastname"
                ],

                // Field helper
                // 'help' => "Write your Lastname",
                // 'help_attr' => [
                //     'class' => "form-text text-muted"
                // ],

                'constraints' => [
                    new NotBlank([
                        'message' => "Please enter your lastname",
                    ])
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'sr-only'
                ],

                // make it required
                'required' => true,

                // Field attributes
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Email"
                ],

                // Field helper
                // 'help' => "Write your Email",
                // 'help_attr' => [
                //     'class' => "form-text text-muted"
                // ],

                'constraints' => [
                    new NotBlank([
                        'message' => "Please enter an Email",
                    ]),
                    new Email([
                        'message' => "Please enter a valid Email",
                    ]),
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                'label_attr' => [
                    'class' => 'sr-only'
                ],

                // make it required
                'required' => true,

                // Field attributes
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Password"
                ],

                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 40,
                    ]),
                ],
            ])
            
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "You should agree to our terms.",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
