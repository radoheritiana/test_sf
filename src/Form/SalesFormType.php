<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Sale;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class SalesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seller', EntityType::class, [
                'placeholder' => 'Selectionner équipe vendeur',
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Equipe vendeur',
                'constraints' => [
                    new NotBlank,
                    new NotNull
                ],
            ])
            ->add('player', EntityType::class, [
                'class' => Player::class,
                'choice_label' => 'fullName',
                'label' => 'Joueur à transferer',
                'choices' => [],
                'constraints' => [
                    new NotBlank,
                    new NotNull
                ]
            ])
            ->add('buyer', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Equipe acheteur',
                'choices' => [],
                'constraints' => [
                    new NotBlank,
                    new NotNull
                ]
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Montant du transfert',
                'constraints' => [
                    new NotBlank
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sale::class,
        ]);
    }
}
