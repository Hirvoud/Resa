<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoHolidays extends Constraint
{
    public $message = "validator.holidays";
}