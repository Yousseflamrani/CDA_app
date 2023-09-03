<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Section;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('username')
            ->add('email');
            if ($options['modify_password']) {
                $builder->add('plainPassword', TextType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Modiffier le mot de pass (Laisser le champ vide si vous voulez garder votre mot de pass Actuel)'
                   
                ]);
            }

            $builder
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Utilisateur' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Responsable' => 'ROLE_RESPONSABLE',   
                ],
                'multiple' => true,
                'expanded' => true, 
            ])
            ->add('section', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'name',
                'label' => 'Section',
                'placeholder' => 'Sélectionnez une section',
            ])
            
            //->add('affaires')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'modify_password' => true, 
        ]);
    }
}
