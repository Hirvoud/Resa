<?php

namespace App\Validator\Constraints;

use App\Service\Holidays;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoHolidaysValidator extends ConstraintValidator
{
    /**
     * @var Holidays
     */
    private $holidays;

    public function __construct(Holidays $holidays)
    {
        $this->holidays = $holidays;
    }


    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if($this->holidays->IsHoliday($value)) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }

    }
}