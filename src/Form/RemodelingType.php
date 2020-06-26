<?php

namespace App\Form;

use App\Entity\Remodeling;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Builder;
use App\Entity\Architect;
use App\Entity\TechnicalArchitect;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemodelingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', Choicetype::class, [
                'choices' => [
                    '15/30/40/15' => '15/30/40/15',
                    '4x25' => '4x25'
                ]
            ])
            ->add('address', TextType::class)
            ->add('city', TextType::class)
            ->add('builtArea', NumberType::class, [
                'html5' => true
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('constructionTime', NumberType::class, [
                'html5' => true
            ])
            ->add('builder', EntityType::class, [
                'class' => Builder::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un constructor'
            ])
            ->add('architect', EntityType::class, [
                'class' => Architect::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un arquitecto'
            ])
            ->add('technicalArchitect', EntityType::class, [
                'class' => TechnicalArchitect::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un arquitecto técnico'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Remodeling::class,
        ]);
    }
}
