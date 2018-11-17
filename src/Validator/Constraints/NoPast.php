<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoPast extends Constraint
{
    public $message = "Vous ne pouvez pas réserver de place pour une date antérieure à la date actuelle.";
}