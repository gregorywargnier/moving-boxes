<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class SecurityForgottenPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
                'help' => "
                Enter the email address associated with your account.",
                'help_attr' => [
                    'class' => "form-text text-muted"
                ],

                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an Email',
                    ]),
                    new Email([
                        'message' => 'Please enter a valid Email',
                    ]),
                ],
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
