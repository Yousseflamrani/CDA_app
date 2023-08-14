<?php


namespace App\Form;

use App\Entity\User;
use App\Entity\Section;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;


class AffaireFilterType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder

        ->add('user',EntityType::class,[
            'class'=>User::class,
            'choice_label'=>'username',
            'required'=>true,

        ])
        ->add('section',EntityType::class,[
            'class'=>Section::class,
            'choice_label'=>'name',
            'required'=>true,


        ])
        ->add('compte_c6',TextType::class,[
            'required'=>false,


        ]);






    }
  




}