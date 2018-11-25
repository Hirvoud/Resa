<?php

namespace App\Form;

use App\Entity\Billet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, array(
                "label" => "Prénom"
            ))
            ->add('nom', TextType::class)
            ->add('pays', TextType::class)
            ->add('dateNaissance', BirthdayType::class, array(
                "label" => "Date de naissance",
                "widget" => "choice",
                "placeholder" => array("year" => "année", "month" => "mois", "day" => "jour"),
                "years" => range(1930, date("Y"))
            ))
            ->add("reduit", CheckboxType::class, array(
                "label" => "Tarif réduit*",
                "required" => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Billet::class,
        ]);
    }
}
