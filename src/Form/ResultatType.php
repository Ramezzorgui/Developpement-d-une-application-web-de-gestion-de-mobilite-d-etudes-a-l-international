<?php
// src/Form/ResultatType.php

namespace App\Form;

use App\Entity\Resultat;
use App\Entity\Offres;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('date')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email', // Ensure 'email' field exists in User entity
            ])
            ->add('offres', EntityType::class, [
                'class' => Offres::class,
                'choice_label' => 'title', // Ensure 'title' field exists in Offres entity
            ])
            ->add('score', NumberType::class, [
                'label' => 'Score',
                'attr' => ['class' => 'form-control custom-input'],
                'required' => false, // Make it optional if it will be set programmatically
                'disabled' => true,  // Ensure the field is not editable by the user
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resultat::class,
        ]);
    }
}
