<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FullCapacity extends Constraint
{
    public $message = "validator.full";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }


}