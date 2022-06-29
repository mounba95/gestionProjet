<?php

namespace App\Form;

use App\Entity\Predecesseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PredecesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomPredecesseur')
            ->add('taches', EntityType::class, array('class' => 'App\Entity\Tache','placeholder'=>'Taches'))
      
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Predecesseur::class,
        ]);
    }
}
