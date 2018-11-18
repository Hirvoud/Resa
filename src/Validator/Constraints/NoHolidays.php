<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoHolidays extends Constraint
{
    public $message = "Vous ne pouvez pas réserver de place les jours fériés.";
}