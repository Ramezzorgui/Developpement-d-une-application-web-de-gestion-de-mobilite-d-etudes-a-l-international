<?php

namespace App\Form;

use App\Entity\Postulation;
use App\Entity\Offres; // Import the Offres entity
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class PostulationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Last Name',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter your last name.',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'First Name',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter your first name.',
                    ]),
                ],
            ])
            ->add('mail', TextType::class, [
                'label' => 'Email Address',
                'constraints' => [
                    new Assert\Email([
                        'message' => 'The email "{{ value }}" is not a valid email.',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Please enter your email address.',
                    ]),
                ],
            ])
            ->add('specialite', ChoiceType::class, [
                'label' => 'Specialization',
                'choices' => [
                    'DS' => 'DS',
                    'TWIN' => 'TWIN',
                    'ArcTic' => 'ArcTic',
                    'Mobile' => 'Mobile',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please select a specialization.',
                    ]),
                ],
            ])
            ->add('moy1', NumberType::class, [
                'label' => 'Grade Year 1',
                'scale' => 2,
                'attr' => ['step' => '0.01'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter your grade for year 1.',
                    ]),
                    new Assert\Type([
                        'type' => 'numeric',
                        'message' => 'The value {{ value }} is not a valid number.',
                    ]),
                ],
            ])
            ->add('moy2', NumberType::class, [
                'label' => 'Grade Year 2',
                'scale' => 2,
                'attr' => ['step' => '0.01'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter your grade for year 2.',
                    ]),
                    new Assert\Type([
                        'type' => 'numeric',
                        'message' => 'The value {{ value }} is not a valid number.',
                    ]),
                ],
            ])
            ->add('moy3', NumberType::class, [
                'label' => 'Grade Year 3',
                'scale' => 2,
                'attr' => ['step' => '0.01'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter your grade for year 3.',
                    ]),
                    new Assert\Type([
                        'type' => 'numeric',
                        'message' => 'The value {{ value }} is not a valid number.',
                    ]),
                ],
            ])
            ->add('etude', ChoiceType::class, [
                'label' => 'Type of Education',
                'choices' => [
                    'ESPRIT' => 'esprit',
                    'Licence' => 'licence',
                    'Préparatoire' => 'preparatoire',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please select the type of education.',
                    ]),
                ],
            ])
            ->add('relevenote', TextType::class, [
                'label' => 'Transcript',
                'attr' => ['placeholder' => 'e.g., Transcript of Records'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter your transcript.',
                    ]),
                ],
            ])
            ->add('offre', EntityType::class, [
                'class' => Offres::class,
                'choice_label' => 'title', // or any other field from the Offres entity
                'label' => 'Offer',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please select an offer.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Postulation::class,
        ]);
    }
}
