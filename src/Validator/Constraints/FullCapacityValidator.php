<?php

namespace App\Validator\Constraints;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FullCapacityValidator extends ConstraintValidator
{


    /**
     * @var CommandeRepository
     */
    private $commandeRepository;

    public function __construct(CommandeRepository $commandeRepository)
    {
        $this->commandeRepository = $commandeRepository;
    }


    public function validate($object, Constraint $constraint)
    {

        if(!$object instanceof  Commande){
            return ;
        }

        $limiteBillets = $this-$this->commandeRepository->countBilletsForDate($object);

        if($limiteBillets > 980) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}