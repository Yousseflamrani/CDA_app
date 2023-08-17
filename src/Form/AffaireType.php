<?php

namespace App\Form;

use App\Entity\Affaire;
use App\Entity\User;
use App\Entity\Section;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AffaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('user',EntityType::class,[
            'class'=>User::class,
            'choice_label'=>'username',
            'multiple' => false,
            'expanded' => true,
            'required'=>true,
        ])
            ->add('user')
            ->add('responsable')
            ->add('compte_c6')
            ->add('phase')
            ->add('journalaffiare')
            ->add('date_de_debut')
            ->add('date_de_fin', null, [
                'constraints' => new Callback([$this, 'validateDateDeFin']),
            ])
            ->add('echeance', null , [
                'constraints'=> new Callback([$this, 'validateEcheance' ]),
            ])

            ->add('statut',ChoiceType::class,[
                'choices'=> [
                    'Ouvert' => 'ouvert',
                    'Fermer' => 'fermer',
                    'Annuler' => 'annuler',
                ],
            ])



            ;
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affaire::class,
        ]);
    }

    public function validateDateDeFin($value, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();
        $startDate = $form->get('date_de_debut')->getData();

        if ($value < $startDate) {
            $context->buildViolation('La date de fin ne peut pas être Inférieure à la date de début.')
                ->atPath('date_de_fin')
                ->addViolation();
        }
    }

    public function validateEcheance($value, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();
        $startDate = $form->get('date_de_debut')->getData();

        if ($value < $startDate) {
            $context->buildViolation('La date d échance ne peut pas être Inférieure à la date de début.')
                ->atPath('echeance')
                ->addViolation();
        }
    }


}
