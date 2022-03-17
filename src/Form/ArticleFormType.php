<?php

namespace App\Form;
use App\Entity\Categorie;
use App\Entity\Article;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label'=>'Titre de l\'article',

            ])
            ->add('subtitle',TextType::class,[
                'label'=>'Sous-titre',
            ])
            ->add('content',TextareaType::class,[
                'label'=>false,
                'attr'=>[
                    'placehlder'=>'Ici le contenu de l\'article'
                ],
            ])
            ->add('category',EntityType::class,[
                'class'=>Categorie::class,
                'choice_label'=>'name',
                'label'=>'Choisissez une catégorie',
            ])
            ->add('photo',FileType::class,[
                'label'=>'Photo',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
