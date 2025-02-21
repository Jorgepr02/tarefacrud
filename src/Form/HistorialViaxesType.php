<?php

namespace App\Form;

use App\Entity\HistorialViaxes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistorialViaxesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('destino', TextType::class, [
                'label' => 'Destino',
                'attr' => ['class' => 'form-control']
            ])
            ->add('data', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data',
                'attr' => ['class' => 'form-control']
            ])
            ->add('duracion', TextType::class, [
                'label' => 'Duración',
                'attr' => ['class' => 'form-control']
            ])
            ->add('motivo', TextType::class, [
                'label' => 'Motivo',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('transporte', TextType::class, [
                'label' => 'Transporte',
                'attr' => ['class' => 'form-control']
            ])
            ->add('aloxamento', TextType::class, [
                'label' => 'Aloxamento',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HistorialViaxes::class,
        ]);
    }
}

