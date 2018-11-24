<?php

namespace App\Manager;


use App\Entity\Billet;
use App\Entity\Commande;
use App\Service\Payment;
use App\Service\PriceCalculator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CommandeManager
 * @package App\Manager
 */
class CommandeManager
{
    const ID_SESSION_COMMANDE = 'commande';

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

    public function __construct(SessionInterface $session, PriceCalculator $priceCalculator, Payment $payment)
    {
        $this->session = $session;
        $this->priceCalculator = $priceCalculator;
        $this->payment = $payment;
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
     */
    public function getCurrentCommande()
    {
        // TODO traiter les cas d'exceptions
        return $this->session->get(self::ID_SESSION_COMMANDE);
    }

    /**
     * @param Commande $commande
     * @return bool
     */
    public function payment(Commande $commande)
    {
        $checkout = $this->payment->Pay($commande);
        return $checkout;
    }

    public function computePrice(Commande $commande)
    {
        $this->priceCalculator->priceCheck($commande);
    }


}