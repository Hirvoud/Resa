<?php

namespace App\Service;


use App\Entity\Commande;
use Symfony\Component\HttpFoundation\RequestStack;


class Payment
{

    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;
    private $private_key;

    public function __construct($stripePrivateKey, RequestStack $requestStack) {
        $this->request = $requestStack->getCurrentRequest();
        $this->private_key = $stripePrivateKey;
    }

    /**
     * @param Commande $commande
     * @return bool
     */
    public function Pay(Commande $commande) {

        \Stripe\Stripe::setApiKey($this->private_key);

        // Get the credit card details submitted by the form
        $token = $this->request->get('stripeToken');

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $commande->getPrixTotal() * 100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Commande n° " . $commande->getNumCommande() . "."
            ));

            return true;
        } catch(\Stripe\Error\Card $e) {

            return false;
        }

    }
}