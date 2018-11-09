<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $currentDate = new \DateTime();

        if($currentDate->diff($value) < "0") {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }

        // TODO: implémenter une méthode de validation correcte.
    }
}