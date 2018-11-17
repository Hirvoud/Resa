<?php

namespace App\Service;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Payment
{
    private $params;


    public function __construct(ParameterBagInterface $params) {
        $this->params = $params;
    }


    public function Pay($commande, $request) {

        \Stripe\Stripe::setApiKey($this->params->get("stripe_private_key"));

        // Get the credit card details submitted by the form
        $token = $request->request->get('stripeToken');

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