<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('resume')
            ->add('nbPages')
            //contrairemenn aux champs, author est une relation vers une autre entité
            //du coup on utilise EntityType
            ->add('author', EntityType::class, [
                //je choisis ici vers quelle entité
                'class' => Author::class,
                //je choisi aussi quelle champs dans auteur
                'choice_label' => 'name'
            ])
            ->add('submit', SubmitType::class)
            ->add('cover', FileType::class, [
                'mapped'=> false,
                'required' => false

                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
