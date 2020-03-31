<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Nom'
            ])
            ->add('firstname', TextType::class, [
                'label'=>'Prénom'
            ])
            // le widget vient modifier l'affichage de dateofbirth dans le formulaire côté twig
            ->add('dateofbirth', DateType::class, [
                'widget'=>'single_text',
                'label'=>'Date de naissance'
                //'required' => false (si je ne veux pas rendre obligatoire une saisie)
            ])
            ->add('biography', TextType::class, [
                'label'=>'Biographie'
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
