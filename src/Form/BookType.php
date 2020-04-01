<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{

    // création du formulaire lié aux données de la base de donnée avec le terminal make:form
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            // TextType va modifier le nom du champ du formulaire côté utilisateur
            ->add('title', TextType::class, [
                'label'=>'Titre'
            ])
            ->add('resume', TextType::class, [
                'label'=>'Résumé'
            ])
            ->add('nbPages', IntegerType::class, [
                'label'=>'Nombre de pages'
            ])
            ->add('author', EntityType::class, [
                'class'=>Author::class,
                'choice_label'=> 'name'
            ])
            ->add('picture', FileType::class, [
                'label'=> 'Photo du livre',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
