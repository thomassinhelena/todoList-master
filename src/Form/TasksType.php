<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Tasks;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TasksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['placeholder' => 'Description de la tâche']
            ])
            ->add('project', EntityType::class, [
                'class'        => Project::class,
                'choice_label' => 'label',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'En attente',
                    'A faire' => 'A faire',
                    'En cours' => 'En cours',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tasks::class,
        ]);
    }
}
