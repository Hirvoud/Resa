<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoSunday extends Constraint
{
    public $message = "validator.notSunday";
}