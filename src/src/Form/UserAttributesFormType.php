<?php

namespace App\Form;

use App\Entity\UserAttributes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAttributesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('esCubano')
            ->add('color_pelo')
            ->add('nacionalidad')
            ->add('fecha_nac')
            ->add('ojos')
            ->add('profesion')
            ->add('ciudad')
            ->add('altura')
            ->add('peso')
            ->add('gustos',ChoiceType::class, [
                'choices'  => [
                    'Animales' => 'animales',
                    'Anime' => 'anime',
                    'Bailar' => 'bailar',
                    'Cantar' => 'cantar',
                    'Charlar' => 'charlar',
                    'Chill' => 'chill',
                    'Cine' => 'cine',
                    'Comics' => 'comics',
                    'Deportes' => 'deportes',
                    'Escribir' => 'escribir',
                    'Fiesta' => 'fiesta',
                    'Idiomas' => 'idiomas',
                    'Informatica' => 'informatica',
                    'Internet' => 'internet',
                    'Leer' => 'leer',
                    'Manga' => 'manga',
                    'Moda' => 'moda',
                    'Montaña' => 'montaña',
                    'Naturaleza' => 'naturaleza',
                    'Pasear' => 'pasear',
                    'Pintar' => 'pintar',
                    'Playa' => 'playa',
                    'Series' => 'series',
                    'Videojuegos' => 'videojuegos',

                ],
                'multiple' => true,
                'expanded'  => true,
            ])
            //->add('sexo')
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserAttributes::class,
        ]);
    }
}
