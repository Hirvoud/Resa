<?php

namespace App\Manager;


use App\Entity\Billet;
use App\Entity\Commande;
use App\Exception\CommandeNotFoundException;
use App\Repository\CommandeRepository;
use App\Service\Payment;
use App\Service\PriceCalculator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CommandeManager
 * @property CommandeRepository commandeRepository
 * @package App\Manager
 */
class CommandeManager
{
    const ID_SESSION_COMMANDE = 'commande';
    const TICKETS_ALERT = 975;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var PriceCalculator
     */
    private $priceCalculator;

    /**
     * @var Payment
     */
    private $payment;

    public function __construct(SessionInterface $session, PriceCalculator $priceCalculator, Payment $payment, CommandeRepository $commandeRepository)
    {
        $this->session = $session;
        $this->priceCalculator = $priceCalculator;
        $this->payment = $payment;
        $this->commandeRepository = $commandeRepository;

    }


    public function creationBillets(Commande $commande)
    {
        for ($i = 1; $i <= $commande->getNbBillets(); $i++) {
            $billet[$i] = new Billet();
            $commande->addBillet($billet[$i]);
        }
    }

    public function generateOrderId(Commande $commande)
    {
        $uniq = strtoupper(uniqid());

        $id = substr($uniq, 0, 4) . "-" . substr($uniq, 4, 4) . "-" . substr($uniq, 8, 3) . "-" . substr($uniq, 11, 2);

        $commande->setNumCommande($id);
    }

    /**
     * @return Commande
     */
    public function initCommande()
    {
        $commande = new Commande();

        $this->session->set(self::ID_SESSION_COMMANDE, $commande);
        return $commande;
    }

    /**
     * @return Commande
     * @throws CommandeNotFoundException
     */
    public function getCurrentCommande()
    {
        $commande = $this->session->get(self::ID_SESSION_COMMANDE);

        if(!$commande instanceof Commande){
            throw new CommandeNotFoundException();
        }

        return $commande;
    }

    /**
     * @param Commande $commande
     * @return bool
     */
    public function payment(Commande $commande)
    {
        $checkout = $this->payment->pay($commande);
        return $checkout;
    }

    /**
     * @param Commande $commande
     */
    public function computePrice(Commande $commande)
    {
        $this->priceCalculator->priceCheck($commande);
    }

    public function clearSession()
    {
        $this->session->clear();
    }

    public function checkWarningTickets(Commande $commande)
    {
        $todaysTickets = $this->commandeRepository->countBilletsForDate($commande->getDateVisite());

        if ($todaysTickets > self::TICKETS_ALERT) {
            return true;
        } else {
            return false;
        }
    }
}