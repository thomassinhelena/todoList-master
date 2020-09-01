<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label',TextType::class, [
                'label' => 'Libellé'
                ,'required'=>true
                ,'attr' => ['minLength' => '1','maxLength' => '150',"autoComplete"=>"abc"]
                ,'constraints' => [
                    new NotBlank([
                        'message' => "Saisir le libellé  ",
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Nombre de caratère incorrect',
                        'max' => 100,
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
