<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoTuesday extends Constraint
{
    public $message = "validator.notTuesday";
}