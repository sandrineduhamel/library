<?php

namespace App\Form;

use App\Entity\Author;

use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName')
            ->add('firstName')

            //j'ajoute le type DATETYPE sur le champ
            //et l'option 'widget' a single_text
            //pour avoir un calendrier a la place des boutons
            //de selection
            ->add('birthDate', DateType::class,
                [
                    'widget'=>'single_text'
                ])
            ->add('deathDate',DateType::class, [
                    'widget'=>'single_text',
                    //permet de garder le champ de la deathDate vide
                    'required'=> false
                ]
               )
            ->add('bio')
            ->add('enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
