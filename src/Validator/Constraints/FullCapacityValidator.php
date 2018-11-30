<?php

namespace App\Validator\Constraints;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FullCapacityValidator extends ConstraintValidator
{
    const TICKETS_LIMIT = 120;
    const TICKETS_ALERT = 6;

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

        dump($object->getDateVisite());

        $todaysTickets = $this->commandeRepository->countBilletsForDate($object->getDateVisite());

        $visitsTickets = $object->getNbBillets();

        //TODO Déplacer alerte flash ailleurs
//        if ($todaysTickets > self::TICKETS_ALERT) {
//            $this->addFlash(
//                "warning",
//                "Attention, il ne reste que xx billets disponibles pour ce jour."
//            );
//        }

        if ($todaysTickets + $visitsTickets > self::TICKETS_LIMIT) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath('dateVisite')
                ->addViolation()
            ;
        }
    }
}