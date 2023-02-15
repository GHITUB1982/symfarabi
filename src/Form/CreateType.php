<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title') 
            ->add('attachement', FileType::class, [
                'mapped' => false,
            ])
            //symfony console make:entity --regenerate
            //symfony console doctrine:schema:update --force
            ->add('category', EntityType::class,[
                'class' =>  Category::class,
            ])
            ->add('Save_Article',SubmitType::class, [
                'attr' => [
                    'class' => "btn btn-success",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
