<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FullCapacity extends Constraint
{
    public $message = "Le nombre maximum de places à déjà été réservé, vous ne pouvez plus réserver pour cette date.";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }


}