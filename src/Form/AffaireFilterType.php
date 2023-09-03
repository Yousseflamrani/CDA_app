<?php


namespace App\Form;

use App\Entity\User;
use App\Entity\Section;
use App\Entity\Affaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;



class AffaireFilterType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!isset($options['role']) || $options['role'] != 'ROLE_USER') {
            $builder
                ->add('user',EntityType::class,[
                    'class'=>User::class,
                    'choice_label'=>'username',
                    'required'=>false,
                    'attr' => ['class' => 'select2'], 
                    'multiple' => false,
                    'placeholder' => 'Choisissez un utilisateur',
                ])


                ->add('section',EntityType::class,[
                    'class'=>Section::class,
                    'choice_label'=>'name',
                    'required'=>false,
                    'placeholder' => 'Choisissez une section',
                ]);
        }
        
        $builder
            ->add('compte_c6',TextType::class,[
                'required'=>false,
                
            ])


            ->add('statut',ChoiceType::class,[
                'choices' => [
                    'Ouvert' => Affaire::STATUT_OUVERT,
                    'Fermer' => Affaire::STATUT_FERMER,
                    'Annuler' => Affaire::STATUT_ANNULER,
                    
                ],
                'placeholder' => 'Choisissez un staut',
                'required'=>false,
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'role' => null, // Valeur par défaut
    ]);
}
    




}