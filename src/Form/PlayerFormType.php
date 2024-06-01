<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PlayerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénoms',
                'constraints' => [
                    new NotBlank,
                    new Length(min: 2)
                ],
                'attr' => [
                    'placeholder' => 'Ex: Tony'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom de famille',
                'constraints' => [
                    new NotBlank,
                    new Length(min: 2)
                ],
                'attr' => [
                    'placeholder' => 'Ex: Kroos'
                ]
            ])
            ->add('team', EntityType::class, [
                'label' => 'Equipe',
                'class' => Team::class,
                'choice_label' => 'name',
                'placeholder' => 'Selectionner équipe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
