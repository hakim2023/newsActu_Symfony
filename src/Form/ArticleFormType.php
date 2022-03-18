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
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label'=>'Titre de l\'article',
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Ce champs ne peut pas etre null'
                    ]),
                    new Length([
                        'min'=>"5",
                        'max'=>"255",
                        'minMessage'=>"le nombre minimal est {{ limit }} ",
                        'maxMessage'=>"le nombre maximal est {{ limit }} ",

                    ])

                ]

            ])
            ->add('subtitle',TextType::class,[
                'label'=>'Sous-titre',  'constraints'=>[
                    new NotBlank([
                        'message'=>'Ce champs ne peut pas etre null'
                    ]),
                    new Length([
                        'min'=>"5",
                        'max'=>"255",
                        'minMessage'=>"le nombre minimal est {{ limit }} ",
                        'maxMessage'=>"le nombre maximal est {{ limit }} ",

                    ])

                ]
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
                'data_class'=>null,
                'attr'=>[
                    'data-default-file'=>$options['photo']
                ],
                'constraints'=>[
                  new Image([
                      'mimeTypes'=>['image/jpg', 'image/png' , 'image/jpeg'],
                      'mimeTypesMessage'=>"Les types des photos autorisés sont: jpeg , jpg , png"
                  ]),
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'allow_file_upload'=>true,
            'photo'=>null,
        ]);  
    }
}
