<?php

namespace App\Validator\Constraints;

use App\Entity\Commande;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FullCapacityValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        $limiteBillets = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->countBilletsForDate($value);

        if($limiteBillets > 980) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}