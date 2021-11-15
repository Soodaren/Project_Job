<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'firstname'
                        ]
                ]
            )

            ->add('lastname', TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'lastname'
                        ]
                ]
            )

            ->add('nic', TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'nic'
                        ]
                ]
            )

            ->add('nic', TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'nic'
                        ]
                ]
            )

            ->add('email', EmailType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'email'
                        ]
                ]
            )

            ->add('username', TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'username'
                        ]
                ]
            )

            ->add('password', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'required' => false,
                    'first_options' =>
                        [
                            'label' => 'Password',
                            'attr' => ['placeholder' => 'Password', 'style' => 'margin-bottom:12px']
                        ],
                    'second_options' =>
                        [
                            'label' => 'Confirm Password',
                            'attr' => ['placeholder' => 'Confirm Password']
                        ],
                    'constraints' => [
                        new Length([
                            'min' => 8,
                            'minMessage' => 'Your password should be at least 8 characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
