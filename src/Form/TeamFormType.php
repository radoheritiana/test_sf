<?php

namespace App\Form;

use App\Entity\Team;
use App\Service\JsonLoaderService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TeamFormType extends AbstractType
{
    private JsonLoaderService $jsonLoaderService;

    public function __construct(JsonLoaderService $jsonLoaderService)
    {
        $this->jsonLoaderService = $jsonLoaderService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $countries = $this->jsonLoaderService->loadJson('public/countries.json');
        $countries_formatted = [];
        foreach ($countries as $key => $country) {
            $countries_formatted[$country] = $country;
        }
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'équipe',
                'constraints' => [
                    new NotBlank,
                    new Length(min: 3)
                ],
                'attr' => [
                    'placeholder' => 'Ex: Fc Seville'
                ]
            ])
            ->add('country', ChoiceType::class, [
                'choices' => $countries_formatted,
                'label' => 'Pays',
                'constraints' => [
                    new NotBlank
                ]
            ])
            ->add('balance', NumberType::class, [
                'label' => 'Solde monétaire',
                'constraints' => [
                    new NotBlank
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
