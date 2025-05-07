<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\Vol;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('villeDepart')
            ->add('villeArrive')
            ->add('dateDepart',DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('heureDepart',TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('prixBilletInitial',IntegerType::class, [
                "attr" =>[
                    "min"=> 0,
                    "max"=> 500
                ]
            ])
            ->add('refAvion')
            ->add('refPilote',EntityType::class,
            [
                "class" => Utilisateur::class,
                'query_builder' => function (UtilisateurRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :role')
                        ->setParameter("role", "%ROLE_PILOTE%");
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
