<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateVisite extends Constraint
{
    public $message = "Vous ne pouvez pas réserver pour une date antérieure à la date actuelle.";
}