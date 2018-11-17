<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoSunday extends Constraint
{
    public $message = "Vous ne pouvez pas réserver de place le dimanche.";
}