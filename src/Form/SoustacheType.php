<?php

namespace App\Form;

use App\Entity\Soustache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SoustacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSoutache')
            ->add('pourcentageAchever')
            ->add('taches', EntityType::class, array('class' => 'App\Entity\Tache','placeholder'=>'Taches'))
            ->add('statues', EntityType::class, array('class' => 'App\Entity\Status','placeholder'=>'Status'))
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Soustache::class,
        ]);
    }
}
