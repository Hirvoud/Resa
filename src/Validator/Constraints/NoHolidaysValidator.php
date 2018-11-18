<?php

namespace App\Validator\Constraints;

use App\Service\Holidays;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoHolidaysValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $holidays = new Holidays();

        if($holidays->IsHoliday($value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }

    }
}