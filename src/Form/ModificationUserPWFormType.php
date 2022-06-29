<?php /** @noinspection ALL */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ModificationUserPWFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomUser')
            ->add('prenomUser')
            ->add('email')

     
            ->add('telUser')
            ->add('roles',  ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices'  => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Client' => 'ROLE_CLIENT',
                    'Chef Equipe(interne)' => 'ROLE_CHEFINT',
                    'Chef Equipe(externe)' => 'ROLE_CHEFEXT'

                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
