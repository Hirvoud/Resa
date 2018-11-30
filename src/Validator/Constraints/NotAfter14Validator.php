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

        $dt = new \DateTime();
        $today = $dt->format("d/M/y");
        $visitDate = $value->getDateVisite()->format("d/M/y");
        $hour = $dt->format("H");

        //TODO add type visite journée

        if($today == $visitDate && $hour >= 12) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }

    }
}