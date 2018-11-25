<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotAfter14 extends Constraint
{
    public $message = "Vous ne pouvez plus réserver de billet journée aujourd'hui.";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}