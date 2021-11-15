<?php

namespace App\Form;

use App\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'title'
                        ]
                ]
            )

            ->add('description', TextareaType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'description'
                        ]
                ]
            )

            ->add('qualification', TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'qualification'
                        ]
                ]
            )

            ->add('salary', TextType::class,
                [
                    'required' => false,
                    'attr' =>
                        [
                            'placeholder' => 'salary'
                        ]
                ]
            )

            ->add('deadline_date', DateType::class,
                [
                    'required' => false,
                    'widget' => 'single_text',
                    'attr' =>
                        [
                            'placeholder' => 'deadline date'
                        ]
                ]
            )

            ->add('image', FileType::class, array('data_class' => null),
                [
                    'required' => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
