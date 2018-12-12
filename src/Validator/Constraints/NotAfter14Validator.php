<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotAfter14Validator extends ConstraintValidator
{
     /**
     * @param $value
     * @param Constraint $constraint
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint)
    {
        $date = \DateTime::createFromFormat('U',time());

        $today = $date->format("d/M/y");
        $visitDate = $value->getDateVisite()->format("d/M/y");
        $hour = $date->format("H");

        if($today == $visitDate && $hour >= 14 && $value->getTypeVisite() == "j") {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }

    }
}