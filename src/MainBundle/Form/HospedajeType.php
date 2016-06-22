<?php

namespace MainBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class HospedajeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class)
            ->add('descripcion', TextType::class)
            ->add('tipoHospedaje', EntityType::Class,
                array(
                    'class' => 'MainBundle\Entity\TipoHospedaje',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('th')
                            ->where('th.borrado' == 0)
                            ->orderBy('th.nombre', 'DESC');
                    },
                    'choice_label' => 'Tipo Hospedaje',
                )
            )
            ->add('localidad', TextType::class)
            ->add('direccion', TextType::class)
            ->add('precio', NumberType::class)
            ->add('capacidad', NumberType::class);
    }

            /*->add('fotos','collection',array(
                'type' =>new ImagenType(),
                'allow_add'=>true,
                'allow_delete'=>true,
                'by_reference' => false,
            ))*/
//    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Hospedaje'
        ));
    }
}