<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotAfter14 extends Constraint
{
    public $message = "validator.not14";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}