<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateVisite extends Constraint
{
    public $messAnt = "Vous ne pouvez pas réserver pour une date antérieure à la date actuelle.";
    public $messJour = "Vous ne pouvez pas réserver de place les mardi et dimanche.";
}