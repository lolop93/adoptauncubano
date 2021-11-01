<?php

namespace App\Form;

use App\Entity\UserAttributes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserAttributesFormType extends AbstractType
{

    private $token;

    //Inyectamos el servicio Token con el constructor para poder acceder al login
    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $login = $this->token->getToken()->getUser();
        $fech_nac = ($login->getAtributos() && $login->getAtributos()->getFechaNac() ? $login->getAtributos()->getFechaNac()->format('Y-m-d') : '');//Formateamos la fecha de Datetime to String Si existe sino pasamos vacio
        $gustos = ($login->getAtributos() && $login->getAtributos()->getGustos() ? $login->getAtributos()->getGustos() : array());

        $builder
            //->add('esCubano')
            ->add('color_pelo')
            ->add('nacionalidad',CountryType::class,[
                'placeholder' => 'Selecciona nacionalidad',
            ])
            ->add('fecha_nac',BirthdayType::class,[
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Dia',
                ],
                'data' => new \DateTime($fech_nac),//le pasamos un array con la fecha al constructor de DaTetime Para que se lo pase al input de BirthDayType Form
            ])
            ->add('ojos',ChoiceType::class, [
                'choices'  => [
                    'Azules' => 'azules',
                    'Verdes' => 'verdes',
                    'Marrones' => 'marrones',
                    'Miel' => 'miel',
                    'Grises' => 'grises',
                    'Negros' => 'negros',
                ],
                'placeholder' => 'Elige color',
            ])
            ->add('profesion')
            ->add('ciudad')
            ->add('altura',NumberType::class,['required' => false])
            ->add('peso',IntegerType::class,['required' => false])
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
                'data' => $gustos,//Datos por defecto si existen
            ])
            ->add('descripcion',TextareaType::class, [
                'attr' => ['class' => 'tinymce', 'maxlength' => 255],
                'row_attr' => ['class' => 'text-editor'],
            ])
            //->add('buscaGenero')
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
