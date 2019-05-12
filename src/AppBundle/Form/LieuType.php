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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class)
            ->add('commentaire', TextType::class)
            ->add(
                'valider', SubmitType::class,
                [
                    'label' => 'Valider',
                    'attr' => [
                        'class' => 'btn-success'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}