<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 02/04/2019
 * Time: 16:51
 */

namespace AppBundle\Form;


use AppBundle\Entity\Lieu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle',
                EntityType::class,
                array(
                    'class' => Lieu::class,
                    'data' => 'libelle',
                    'required' => true,
                    'label' => 'Lieux 1 : '
                ))
            ->add('libelle',
                EntityType::class,
                array(
                    'class' => Lieu::class,
                    'data' => 'libelle',
                    'required' => true,
                    'label' => 'Lieux 1 : '
                ))
            ->add('name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}