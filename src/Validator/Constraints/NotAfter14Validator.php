<?php

namespace App\Validator\Constraints;

use App\Entity\Commande;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotAfter14Validator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        $dt = new \DateTime();
        $today = $dt->format("d/M/y");
        $visitDate = $value->format("d/M/y");
        $hour = $dt->format("H");


        if($today == $visitDate && $hour > "14") {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }

    }
}