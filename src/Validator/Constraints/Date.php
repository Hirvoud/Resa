<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Date extends Constraint
{
    public $message = "Vous ne pouvez pas réserver pour une date antérieure à aujourd'hui.";
}