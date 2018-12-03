<?php

namespace App\Validator\Constraints;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FullCapacityValidator extends ConstraintValidator
{
    const TICKETS_LIMIT = 1000;

    /**
     * @var CommandeRepository
     */
    private $commandeRepository;

    /**
     * FullCapacityValidator constructor.
     * @param CommandeRepository $commandeRepository
     */
    public function __construct(CommandeRepository $commandeRepository)
    {
        $this->commandeRepository = $commandeRepository;
    }

    /**
     * @param $object
     * @param Constraint $constraint
     */
    public function validate($object, Constraint $constraint)
    {

        if(!$object instanceof  Commande){
            return ;
        }

        $todaysTickets = $this->commandeRepository->countBilletsForDate($object->getDateVisite());


        $visitsTickets = $object->getNbBillets();


        if ($todaysTickets + $visitsTickets > self::TICKETS_LIMIT) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath('dateVisite')
                ->addViolation()
            ;
        }
    }
}