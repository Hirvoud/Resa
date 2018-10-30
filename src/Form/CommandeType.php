<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('dateVisite', DateType::class, array(
                "widget" => "choice",
            ))
            ->add('prixTotal')
            ->add('numCommande')
            ->add("nbBillets", ChoiceType::class, array(
                "choices" => array(
                    "1" => 1,
                    "2" => 2,
                    "3" => 3,
                    "4" => 4,
                    "5" => 5,
                    "6" => 6,
                )
            ))
            ->add("typeVisite", ChoiceType::class, array(
                "choices" => array(
                    "Journée" => "j",
                    "Demi-journée" => "dj"
                )
            ))
            ->add("billets", CollectionType::class, array(
                "entry_type" => BilletType::class,
                "entry_options" => array("label" => false),
                "allow_add" => true,
            ))
            ->add("save", SubmitType::class, [
                "label" => "Valider",
                "attr" => [
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
