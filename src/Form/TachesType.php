<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TachesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomTache')
            ->add('dateActuelDebut',DateType::class, array('label' => 'Date Debut','widget' => 'single_text','required' => false))
            ->add('dateActuelFin',DateType::class, array('label' => 'Date Fin','widget' => 'single_text','required' => false))
            ->add('pourcentageAchever')
            ->add('projets', EntityType::class, array('class' => 'App\Entity\Projet','placeholder'=>'Projet'))
            ->add('equipes', EntityType::class, array('class' => 'App\Entity\Equipe','placeholder'=>'Equipes'))
            ->add('statues', EntityType::class, array('class' => 'App\Entity\Status','placeholder'=>'Status'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
