<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoTuesdayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $visitDay = $value->format("D");

        if($visitDay == "Tue") {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }

        //TODO Ajouter contraintes pour les jours fériés

    }
}