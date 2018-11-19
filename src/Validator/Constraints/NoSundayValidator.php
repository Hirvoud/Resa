<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoSundayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $visitDay = $value->format("D");

        if($visitDay == "Sun") {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }

    }
}