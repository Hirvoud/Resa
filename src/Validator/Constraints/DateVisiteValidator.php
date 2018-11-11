<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateVisiteValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $currentDate = new \DateTime();

        if($currentDate->diff($value)->invert == 1) {
            $this->context
                ->buildViolation($constraint->messAnt)
                ->addViolation()
            ;
        }

        $visitDay = $value->format("D");

        if($visitDay == "Sun" || $visitDay == "Tue") {
            $this->context
                ->buildViolation($constraint->messJour)
                ->addViolation()
            ;
        }

        //TODO Ajouter contraintes pour les jours fériés

    }
}