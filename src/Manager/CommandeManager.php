<?php

namespace App\Manager;


use App\Entity\Billet;
use App\Entity\Commande;
use App\Service\PriceCalculator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

    public function __construct(SessionInterface $session, PriceCalculator $priceCalculator)
    {
        $this->session = $session;
        $this->priceCalculator = $priceCalculator;
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
        $random = strtoupper(uniqid());

        $commande->setNumCommande($random);
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

    public function computePrice(Commande $commande)
    {
        $this->priceCalculator->priceCheck($commande);
    }


}